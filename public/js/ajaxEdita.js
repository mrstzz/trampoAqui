

const modal = document.getElementById('contratar-modal');
const modalContentArea = document.getElementById('modal-content-area');
const closeModalBtn = document.getElementById('modal-close-btn');

// Função para abrir o modal
function openModal() {
    modal.classList.remove('hidden');
}

// Função para fechar o modal
function closeModal() {
    modal.classList.add('hidden');
    // Limpa o conteúdo ao fechar para a próxima abertura
    modalContentArea.innerHTML = '<p class="text-center text-gray-600 py-8">Carregando...</p>';
}

        



// Event listeners para fechar o modal
closeModalBtn.addEventListener('click', closeModal);
modal.addEventListener('click', function(e) {
    // Fecha o modal se clicar fora do painel branco
    if (e.target === modal) {
        closeModal();
    }
});





// Função para popular o modal com os dados do anúncio (via AJAX)
function populateModal(data) {
    console.log(data);
   
    if (!data || data.error) {
        modalContentArea.innerHTML = '<p class="text-red-500 text-center">Erro ao carregar os detalhes do anúncio. Tente novamente.</p>';
        return;
    }

    modalContentArea.innerHTML = `
        <div class="flex items-center gap-4 mb-4">
            <img src="./icons/user-default.svg" alt="Avatar do Prestador"
                 class="w-12 h-12 rounded-full ring-2 ring-orange-600 ring-offset-2" />
            <div>
                <h3 class="text-lg font-bold text-gray-900">${data.nome}</h3>
                <p class="text-sm text-gray-600">${data.localidade}</p>
            </div>
        </div>

        <h4 class="font-semibold text-gray-800 mt-4">Descrição Completa:</h4>
        <p class="text-gray-700 mb-4 text-sm h-32 overflow-y-auto p-2 bg-gray-50 rounded">
            ${data.descricao}
        </p>

        <div class="mb-4 p-4 bg-gray-100 rounded-lg text-center">
            <span class="text-xs uppercase font-semibold text-gray-600">Valor do Serviço</span>
            <div class="text-3xl font-bold text-orange-600">
                R$ ${data.valor}
                <span class="text-lg font-normal text-gray-600">/diária</span>
            </div>
        </div>

        <hr class="my-6">

        <h3 class="text-xl font-semibold text-center text-gray-800 mb-4">Gostaria de contratar este serviço?</h3>
        
        <form action="processarContratacao.php" method="POST">
            <input type="hidden" name="id_anuncio" value="${data.idAnuncio}">
            
            <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-indigo-700 transition-colors">
                Sim, quero contratar!
            </button>
            <button type="button" onclick="closeModal()" class="w-full bg-gray-200 text-gray-700 font-bold py-2 px-6 rounded-lg hover:bg-gray-300 transition-colors mt-2">
                Cancelar
            </button>
        </form>
    `;
}


// index

document.querySelector('.modal-edita').addEventListener('click', function(e) {
    
    const contratarBtn = e.target.closest('.btn-editar');
    
    if (contratarBtn) {
        e.preventDefault();
        const anuncioId = contratarBtn.dataset.id;
        
        openModal();
        
        // 2. Busca os dados do anúncio via AJAX (Fetch API)
        fetch(`pages/comerciante/cad_painel_comerciante.php?editar=1&id=${anuncioId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro de rede ao buscar anúncio.');
                }
                return response.json();
            })
            .then(data => {
                populateModal(data);
            })
            .catch(error => {
                console.error('Erro ao buscar detalhes do anúncio:', error);
                modalContentArea.innerHTML = '<p class="text-red-500 text-center">Não foi possível carregar os detalhes. Tente novamente mais tarde.</p>';
            });
    }
});


