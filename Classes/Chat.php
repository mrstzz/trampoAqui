<?php

namespace Classes;
use PDO;

class Chat extends Conexao {
    public function __construct() {
        parent::__construct();
    }



    /**
     * Insere  o chat  (cliente e comerciante).
     */


    public function insereChat($cliente_id, $comerc_id){


        $sql =  "INSERT INTO 
                    chat_conversations (cliente_id, comerc_id) 
                    VALUES (?, ?)
                    ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id)";
        
        $params = [$cliente_id, $comerc_id];
        $result = $this->consulta($sql,$params);
        return $this->getInsertId($result);
    }



    /**
     * Insere  conversa no chat (cliente ou comerciante).
     */

    public function insereConversa($chatId, $sender_id, $receiver_id, $encrypted_message ){

        $sql = "INSERT INTO chat_messages (conversation_id, sender_id, receiver_id, message_content) 
                VALUES (?, ?, ?, ?)";

        $params = [$chatId, $sender_id, $receiver_id, $encrypted_message]; 
        $result = $this->consulta($sql,$params);

        return (1);
    }



    /**
     * Busca todas as conversas de um usuário (cliente ou comerciante).
     */
    public function buscaConversa(int $user_id, string $user_type): array {
        if ($user_type === 'comerciante') {
            $sql = "SELECT 
                        conv.id as conversation_id, c.id, c.nome 
                    FROM chat_conversations conv
                    JOIN clientes c ON conv.cliente_id = c.id 
                    WHERE conv.comerc_id = ?";
        } else {
            $sql = "SELECT 
                        conv.id as conversation_id, co.id, co.nome 
                    FROM chat_conversations conv 
                    JOIN comerciantes co ON conv.comerc_id = co.id 
                    WHERE conv.cliente_id = ?";
        }
        
        $stmt = $this->consulta($sql, [$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * Busca todas as mensagens de uma conversa específica.
    */
    public function buscaMensagens(int $conversation_id): array {
        $sql = "SELECT * FROM chat_messages 
                WHERE conversation_id = ? 
                ORDER BY timestamp ASC";
        
        $stmt = $this->consulta($sql, [$conversation_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Busca os participantes (cliente_id, comerc_id) de uma conversa.
     * Usado para determinar o destinatário.
     */
    public function getConversationParticipants(int $conversation_id): ?array {
        $sql = "SELECT cliente_id, comerc_id FROM chat_conversations WHERE id = ?";
        $stmt = $this->consulta($sql, [$conversation_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Retorna os dados ou null se a conversa não for encontrada
        return $result ?: null; 
    }


    /**
     * Marca as mensagens como lidas para um usuário em um chat.
     */
    public function marcaComoLido(int $conversation_id, int $receiver_id): bool {
        $sql = "UPDATE chat_messages SET is_read = 1 
                WHERE conversation_id = ? AND receiver_id = ? AND is_read = 0";
        
        $stmt = $this->consulta($sql, [$conversation_id, $receiver_id]);
        return $stmt->rowCount() > 0;
    }

    /**
     * Verifica se um usuário específico pertence a uma conversa.
     * (Função de segurança)
     */
    public function verificaAcessoConversa(int $conversation_id, int $user_id, string $user_type): bool {
        $id_field = ($user_type === 'comerciante') ? 'comerc_id' : 'cliente_id';

        // Validação extra para evitar SQL Injection se $user_type vier de fonte insegura
        if (!in_array($id_field, ['comerc_id', 'cliente_id'])) {
            return false;
        }

        $sql = "SELECT id FROM chat_conversations 
                WHERE id = ? AND $id_field = ?";
        
        $stmt = $this->consulta($sql, [$conversation_id, $user_id]);
        return $stmt->rowCount() > 0;
    }




}