document.addEventListener('DOMContentLoaded', () => {

    const chatApiUrl = '../../api/chat_msg.php'; // Caminho para sua API
    const chatListContainer = document.getElementById('chat-list-container');
    const chatHeaderName = document.getElementById('chat-header-name');
    const chatHistory = document.getElementById('chat-history');
    const chatPlaceholder = document.getElementById('chat-placeholder');
    
    const chatForm = document.getElementById('chat-send-form');
    const chatConversationIdInput = document.getElementById('chat-conversation-id');
    const chatMessageInput = document.getElementById('chat-message-input');
    const chatSendButton = document.getElementById('chat-send-button');

    let activeConversationId = null;
    let pollingInterval = null; // Variável para controlar nosso polling de 5s
    let currentUserId = null; 
    let activeContactId = null;

    // --- 1. Carrega a lista de conversas ---
    async function loadConversations() {
        try {
            const response = await fetch(`${chatApiUrl}?action=get_conversations`);
            if (!response.ok) throw new Error('Falha ao carregar conversas.');
            
            const conversations = await response.json();
            chatListContainer.innerHTML = ''; // Limpa o "Carregando..."

            if (conversations.length === 0) {
                chatListContainer.innerHTML = '<div class="p-4 text-center text-gray-500">Nenhuma conversa encontrada.</div>';
                return;
            }
            
            // Assume que a sessão PHP expõe o user_id globalmente (PERIGO! Melhor passar via data-attribute)
            // Por simplicidade, vamos buscar o ID da primeira mensagem (se houver)
            // Forma CORRETA: O PHP deveria imprimir o $_SESSION['user_id'] em um local seguro.
            // Para este exemplo, vamos assumir que o `sender_id` nas mensagens nos dirá.

            conversations.forEach(convo => {
                const convoEl = document.createElement('div');
                convoEl.className = 'p-4 border-b border-gray-200 hover:bg-gray-50 cursor-pointer';
                convoEl.textContent = convo.nome;
                convoEl.dataset.contratoId = convo.conversation_id;
                convoEl.dataset.contactName = convo.nome;
                convoEl.dataset.contactId = convo.id;

                convoEl.addEventListener('click', () => openChat(convo));
                chatListContainer.appendChild(convoEl);
            });

        } catch (error) {
            console.error(error);
            chatListContainer.innerHTML = '<div class="p-4 text-center text-red-500">Erro ao carregar.</div>';
        }
    }

    // --- 2. Abre uma conversa específica ---
    function openChat(convo) {
        if (pollingInterval) {
            clearInterval(pollingInterval); // Para o polling antigo
        }
        
        activeConversationId = convo.conversation_id;
        activeContactId = convo.id; // <-- 1. ADICIONE ISSO (guarda o ID de quem falamos)

        // Atualiza o Header e Form
        // 2. CORREÇÃO AQUI (mude de convo.contactName para convo.nome)
        chatHeaderName.textContent = `Conversando com ${convo.nome}`; 
        
        chatConversationIdInput.value = activeConversationId;
        chatMessageInput.disabled = false;
        chatSendButton.disabled = false;
        
        // Remove o placeholder se ele existir
        const placeholder = document.getElementById('chat-placeholder');
        if(placeholder) placeholder.remove();

        // Carrega as mensagens imediatamente
        loadMessages(activeConversationId);

        // Inicia o novo polling de 5 segundos
        pollingInterval = setInterval(() => loadMessages(activeConversationId), 5000);
    }

    // --- 3. Carrega as mensagens (Polling) ---
    async function loadMessages(conversationId) {
        if (conversationId !== activeConversationId) return; // Parou de ver este chat

        try {
            const response = await fetch(`${chatApiUrl}?action=get_messages&conversation_id=${conversationId}`);
            if (!response.ok) throw new Error('Falha ao carregar mensagens.');
            
            const messages = await response.json();
            
            chatHistory.innerHTML = ''; // Limpa o chat
            
            messages.forEach(msg => {
                let bubbleClass = '';
                let wrapperClass = '';
                let isSentByMe = false; // Flag para mostrar o check

                if (msg.sender_id == 0) {
                    // --- 1. MENSAGEM DO SISTEMA ---
                    // (Centralizada e com fundo leve)
                    bubbleClass = 'bg-gray-100 text-gray-600 text-sm italic';
                    wrapperClass = 'justify-center'; 
                
                } else if (msg.sender_id == activeContactId) {
                    // --- 2. MENSAGEM RECEBIDA ---
                    // (Alinhada à esquerda)
                    bubbleClass = 'bg-gray-200 text-gray-800 self-start';
                    wrapperClass = 'justify-start';
                
                } else {
                    // --- 3. MENSAGEM ENVIADA POR MIM ---
                    // (Alinhada à direita)
                    bubbleClass = 'bg-orange-500 text-white self-end';
                    wrapperClass = 'justify-end';
                    isSentByMe = true; // Marca para adicionar o check
                }

                // Cria os elementos
                const msgBubble = document.createElement('div');
                msgBubble.className = `p-3 rounded-lg max-w-[70%] ${bubbleClass}`;
                
                const contentWrapper = document.createElement('div');
                contentWrapper.className = 'flex items-end'; // Alinha texto e check
                
                const textSpan = document.createElement('span');
                textSpan.style.whiteSpace = 'pre-wrap'; // Respeita o \n da msg de sistema
                textSpan.textContent = msg.message_content;
                contentWrapper.appendChild(textSpan);

                // --- LÓGICA DO CHECK DE LEITURA ---
                if (isSentByMe) {
                    const checkmark = document.createElement('i');
                    
                    // Define o ícone e a cor baseado no is_read
                    const iconClass = (msg.is_read == 1) ? 'bi-check2-all' : 'bi-check';
                    const iconColor = (msg.is_read == 1) ? '#3b82f6' : '#6b7280'; // Azul / Cinza
                    
                    checkmark.className = `bi ${iconClass} ml-2`;
                    checkmark.style.color = iconColor;
                    
                    contentWrapper.appendChild(checkmark);
                }
                // --- FIM DA LÓGICA DO CHECK ---
                
                msgBubble.appendChild(contentWrapper);
                
                const wrapper = document.createElement('div');
                wrapper.className = `flex w-full ${wrapperClass}`;
                wrapper.appendChild(msgBubble);
                
                chatHistory.appendChild(wrapper);
            });

            // Auto-scroll para o final
            chatHistory.scrollTop = chatHistory.scrollHeight;

        } catch (error) {
            console.error(error);
        }
    }

    // --- 4. Envia uma mensagem ---
    chatForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const messageText = chatMessageInput.value.trim();
        if (!messageText || !activeConversationId) return;

        chatSendButton.disabled = true;

        try {
            const formData = new FormData(chatForm);
            
            const response = await fetch(`${chatApiUrl}?action=send_message`, {
                method: 'POST',
                body: formData
            });

            if (!response.ok) throw new Error('Falha ao enviar.');

            chatMessageInput.value = ''; // Limpa o input
            loadMessages(activeConversationId); // Carrega imediatamente
            
        } catch (error) {
            console.error(error);
        } finally {
            chatSendButton.disabled = false;
        }
    });

    // --- Inicialização ---
    // Encontra o link do chat na NAV e adiciona o 'listener'
    const chatNavLink = document.querySelector('.nav-link[data-target="chat"]');
    if (chatNavLink) {
        chatNavLink.addEventListener('click', () => {
            // Só carrega as conversas quando clica (ou se já estiver na aba)
            if (chatListContainer.children.length <= 1) { // <=1 por causa do "carregando..."
                loadConversations();
            }
        });
    }
});