<?php
// Define que a resposta será JSON
header('Content-Type: application/json');

// --- 1. Configuração e Carregamento do Ambiente ---
$diretorio = __DIR__ . '/../../';

if (!@include_once $diretorio . 'vendor/autoload.php') {
    http_response_code(500);
    echo json_encode(['reply' => 'Erro interno do servidor.']);
    exit;
}

use Classes\Chat; 
use Classes\EncryptionHelper;

// Inicia a sessão para verificar o login
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// --- Validação de Segurança ---
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Acesso não autorizado.']);
    exit;
}

$user_id = (int)$_SESSION['user_id'];
$user_type = $_SESSION['user_type']; 

try {
    // Instancia a nova classe
    $chat = new Chat(); 
    
    $action = $_GET['action'] ?? '';

    switch ($action) {
        
        case 'get_conversations':
            $conversations = $chat->buscaConversa($user_id, $user_type);
            echo json_encode($conversations);
            break;

        case 'get_messages':
            $conversation_id = (int)($_GET['conversation_id'] ?? 0);
            
            // 1. Segurança: Verifica o acesso
            if (!$chat->verificaAcessoConversa($conversation_id, $user_id, $user_type)) {
                throw new Exception('Acesso negado a este chat.');
            }

            // 2. Marca como lidas
            $chat->marcaComoLido($conversation_id, $user_id);

            // 3. Busca e descriptografa
            $messages = $chat->buscaMensagens($conversation_id);
            
            foreach ($messages as &$msg) {
                // A descriptografia continua aqui, pois é lógica de "apresentação"
                $msg['message_content'] = EncryptionHelper::decrypt($msg['message_content']);
            }
            
            echo json_encode($messages);
            break;

        case 'send_message':
            $conversation_id = (int)($_POST['conversation_id'] ?? 0);
            $message_text = trim($_POST['message_text'] ?? '');
            
            if (empty($conversation_id) || empty($message_text)) {
                throw new Exception('Dados inválidos.');
            }

            // 1. Pega os IDs da conversa para saber quem é o receiver
            $conversa = $chat->getConversationParticipants($conversation_id);

            if (!$conversa) {
                throw new Exception('Conversa não encontrada.');
            }
            
            // 2. Define o destinatário
            $receiver_id = ($user_type === 'comerciante') ? $conversa['cliente_id'] : $conversa['comerc_id'];
            
            // 3. Segurança (já coberta pelo verificaAcessoConversa, mas redundância é boa)
            if ($user_id != $conversa['cliente_id'] && $user_id != $conversa['comerc_id']) {
                 throw new Exception('Acesso negado.');
            }

            // 4. Criptografa e Salva
            $encrypted_message = EncryptionHelper::encrypt($message_text);
            
            $chat->insereConversa($conversation_id, $user_id, $receiver_id, $encrypted_message);
            
            echo json_encode(['status' => 'success']);
            break;
            
        default:
            throw new Exception('Ação desconhecida.');
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}