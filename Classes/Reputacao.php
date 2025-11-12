<?php
namespace Classes;
use PDO;

class Reputacao extends Conexao {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Atualiza a tabela 'comerciante_reputacao' com dados frescos.
     * Esta é a função mais importante!
     */
    public function atualizarReputacao(int $comerc_id) {
        
        // 1. Calcula as estatísticas de AVALIAÇÃO (das reviews)
        $sql_avaliacoes = "SELECT
                                COUNT(id) as total_avaliacoes,
                                AVG(nota) as nota_media
                           FROM avaliacoes
                           WHERE comerc_id = ?";
        
        $stmt_reviews = $this->consulta($sql_avaliacoes, [$comerc_id]);
        $stats_reviews = $stmt_reviews->fetch(PDO::FETCH_ASSOC);
        
        $total_avaliacoes = $stats_reviews['total_avaliacoes'] ?? 0;
        $nota_media = $stats_reviews['nota_media'] ?? 0.00;

        // 2. Calcula as estatísticas de CONTRATOS (concluídos vs recusados)
        $sql_contratos = "SELECT
                                SUM(CASE WHEN status = 'concluido' THEN 1 ELSE 0 END) as concluidos,
                                SUM(CASE WHEN status = 'recusado' THEN 1 ELSE 0 END) as recusados
                            FROM anuncios_contratados
                            WHERE comerc_id = ?";
                            
        $stmt_contratos = $this->consulta($sql_contratos, [$comerc_id]);
        $stats_contratos = $stmt_contratos->fetch(PDO::FETCH_ASSOC);
        
        $total_concluidos = $stats_contratos['concluidos'] ?? 0;
        $total_recusados = $stats_contratos['recusados'] ?? 0;
        
        // 3. Calcula a Taxa de Conclusão (evita divisão por zero)
        $total_jobs = $total_concluidos + $total_recusados;
        $taxa_conclusao = ($total_jobs > 0) ? ($total_concluidos / $total_jobs) * 100 : 0.00;

        // 4. Salva tudo na tabela resumo (INSERT...ON DUPLICATE KEY UPDATE)
        $sql_update = "INSERT INTO comerciante_reputacao (
                            comerc_id, nota_media, total_avaliacoes, 
                            total_contratos_concluidos, total_contratos_recusados, 
                            taxa_conclusao_percent, data_ultima_atualizacao
                       ) 
                       VALUES (?, ?, ?, ?, ?, ?, NOW())
                       ON DUPLICATE KEY UPDATE
                            nota_media = VALUES(nota_media),
                            total_avaliacoes = VALUES(total_avaliacoes),
                            total_contratos_concluidos = VALUES(total_contratos_concluidos),
                            total_contratos_recusados = VALUES(total_contratos_recusados),
                            taxa_conclusao_percent = VALUES(taxa_conclusao_percent),
                            data_ultima_atualizacao = NOW()";
        
        $params = [
            $comerc_id, $nota_media, $total_avaliacoes, 
            $total_concluidos, $total_recusados, $taxa_conclusao
        ];

        $this->consulta($sql_update, $params);
        return true;
    }
    
    /**
     * Pega os dados de reputação de um comerciante para exibir no perfil.
     */
    public function getReputacao(int $comerc_id): ?array {
        $sql = "SELECT * FROM comerciante_reputacao WHERE comerc_id = ?";
        $stmt = $this->consulta($sql, [$comerc_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Retorna os dados ou null se ele ainda não tiver reputação
        return $result ?: null; 
    }

    public function insereAvaliacao($contrato_id, $cliente_id, $comerc_id, $nota, $comentario){
        // 1. Insere a avaliação
    $sql = "INSERT INTO avaliacoes (contrato_id, cliente_id, comerc_id, nota, comentario) 
                   VALUES (?, ?, ?, ?, ?)";

    $params = [
            $contrato_id, 
            $cliente_id, 
            $comerc_id,
            $nota,
            $comentario
        ];
    $result = $this->consulta($sql, $params);

    }
}