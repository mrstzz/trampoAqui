<button id="open-chat-btn" class="fixed bottom-6 right-6 w-14 h-14 bg-indigo-600 rounded-full flex items-center justify-center cursor-pointer shadow-xl hover:bg-indigo-700 transition-all z-50">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
    </svg>
</button>

<div id="chat-modal" class="fixed bottom-24 right-6 w-96 h-[500px] bg-white rounded-lg shadow-2xl flex flex-col hidden z-50 border border-gray-200 font-sans">
    <div class="bg-indigo-700 p-4 rounded-t-lg flex justify-between items-center text-white">
        <div class="flex items-center space-x-2">
             <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
            <h3 class="font-semibold">Suporte TrampoAqui</h3>
        </div>
        <button id="close-chat-btn" class="text-gray-300 hover:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div id="chat-messages" class="flex-1 p-4 overflow-y-auto bg-gray-50 flex flex-col space-y-3">
        <div class="self-start max-w-[80%] bg-white p-3 rounded-lg rounded-tl-none shadow-sm border border-gray-100 text-sm text-gray-800">
            Olá! Sou o assistente virtual do TrampoAqui. Como posso te ajudar hoje?
        </div>
    </div>

    <div class="p-3 border-t border-gray-200 bg-white rounded-b-lg flex">
        <input type="text" id="chat-input" placeholder="Digite sua dúvida..." class="flex-1 border border-gray-300 rounded-l-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm" onkeypress="if(event.key === 'Enter') sendMessage()">
        <button onclick="sendMessage()" class="bg-indigo-600 text-white px-4 rounded-r-lg hover:bg-indigo-700 transition flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
            </svg>
        </button>
    </div>
</div>

<script>
    const chatModal = document.getElementById('chat-modal');
    const openBtn = document.getElementById('open-chat-btn');
    const closeBtn = document.getElementById('close-chat-btn');
    const chatMessages = document.getElementById('chat-messages');
    const chatInput = document.getElementById('chat-input');

    // Toggle Modal
    openBtn.addEventListener('click', () => chatModal.classList.remove('hidden'));
    closeBtn.addEventListener('click', () => chatModal.classList.add('hidden'));

    function appendMessage(text, isUser = false) {
        const div = document.createElement('div');
        div.className = isUser 
            ? 'self-end max-w-[80%] bg-indigo-600 text-white p-3 rounded-lg rounded-tr-none shadow-sm text-sm' 
            : 'self-start max-w-[80%] bg-white p-3 rounded-lg rounded-tl-none shadow-sm border border-gray-100 text-sm text-gray-800';
        div.innerText = text;
        chatMessages.appendChild(div);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    async function sendMessage() {
        const text = chatInput.value.trim();
        if (!text) return;

        appendMessage(text, true);
        chatInput.value = '';

        // Loading indicator simples
        const loadingDiv = document.createElement('div');
        loadingDiv.className = 'self-start bg-gray-200 text-gray-500 p-3 rounded-lg rounded-tl-none text-sm animate-pulse';
        loadingDiv.innerText = 'Digitando...';
        loadingDiv.id = 'chat-loading';
        chatMessages.appendChild(loadingDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;

        try {
            // Ajuste o caminho se sua API estiver em outro lugar
            const response = await fetch('/api/chat.php', { 
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ message: text })
            });
            
            const data = await response.json();
            document.getElementById('chat-loading').remove(); // Remove loading

            if (data.reply) {
                appendMessage(data.reply);
            } else {
                appendMessage("Desculpe, tive um erro técnico.");
            }

        } catch (error) {
            document.getElementById('chat-loading').remove();
            appendMessage("Erro ao conectar com o servidor.");
            console.error(error);
        }
    }
</script>