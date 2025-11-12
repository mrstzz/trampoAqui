    document.addEventListener('DOMContentLoaded', function() {
        
        // --- Lógica da Navegação (SEU SCRIPT ATUAL) ---
        const navLinks = document.querySelectorAll('.nav-link');
        const contentSections = document.querySelectorAll('.content-section');
        // ... (todo o seu script de navegação que já existe) ...
        // ... (não apague!) ...

        
        // --- LÓGICA DO MODAL DE AVALIAÇÃO (NOVO) ---
        
        const modal = document.getElementById('avaliacao-modal');
        const closeModalBtn = document.getElementById('modal-close-btn-avaliacao');
        const avaliarBtns = document.querySelectorAll('.btn-avaliar');
        
        // Inputs escondidos do formulário
        const hiddenContratoId = document.getElementById('hidden-contrato-id');
        const hiddenComercianteId = document.getElementById('hidden-comerciante-id');
        const hiddenAnuncioId = document.getElementById('hidden-anuncio-id');
        const modalTitle = document.getElementById('avaliacao-modal-title');
        
        // Abrir o modal
        avaliarBtns.forEach(button => {
            button.addEventListener('click', () => {
                // 1. Pegar os dados do botão clicado
                const contratoId = button.dataset.contratoId;
                const comercianteId = button.dataset.comercianteId;
                const anuncioId = button.dataset.anuncioId;
                const anuncioTitulo = button.dataset.anuncioTitulo;

                // 2. Preencher o formulário do modal
                hiddenContratoId.value = contratoId;
                hiddenComercianteId.value = comercianteId;
                hiddenAnuncioId.value = anuncioId;
                modalTitle.textContent = `Avaliar: ${anuncioTitulo}`;
                
                // 3. Mostrar o modal
                modal.classList.remove('hidden');
            });
        });

        // Fechar o modal
        function closeModal() {
            modal.classList.add('hidden');
            // Opcional: Resetar o formulário
            document.getElementById('avaliacao-form').reset();
        }

        closeModalBtn.addEventListener('click', closeModal);

        // Opcional: Fechar clicando fora do modal
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal();
            }
        });
    });