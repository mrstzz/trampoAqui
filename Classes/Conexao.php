<?php

require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

class Conexao
{
    private static ?PDO $instancia = null;

    private static ?int $insert_id = null;

    private function __construct() {}
    private function __clone() {}
    public function __wakeup() {}

    /**
     * Obtém a instância única da conexão PDO (Singleton).
     * @return PDO
     */
    
    public static function getInstancia(): PDO
    {
        if (self::$instancia === null) {
            try {
                $dotenv = Dotenv::createImmutable(__DIR__); 
                $dotenv->load();

                $db_driver = $_ENV['DB_DRIVER'] ?? 'mysql';
                $db_host = $_ENV['DB_HOST'] ?? 'localhost';
                $db_name = $_ENV['DB_NAME'] ?? 'meu_banco';
                $db_user = $_ENV['DB_USER'] ?? 'root';
                $db_pass = $_ENV['DB_PASS'] ?? '';
                $db_charset = $_ENV['DB_CHARSET'] ?? 'utf8mb4';

                $dsn = "$db_driver:host=$db_host;dbname=$db_name;charset=$db_charset";
                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ];

                self::$instancia = new PDO($dsn, $db_user, $db_pass, $options);
                
            } catch (Exception $e) {
                error_log("Falha ao carregar .env ou conectar ao DB: " . $e->getMessage());
                exit();
            }
        }
        return self::$instancia;
    }

    /**
     * Método estático para executar consultas de forma segura.
     * 
     *
     * @param string $query A query SQL com placeholders (?, ?, etc.)
     * @param array  $params Um array de parâmetros para o bind.
     * @param bool   $notdie Se true, retorna um array de erro em vez de 'die()'.
     * @return PDOStatement|array Retorna o PDOStatement em sucesso, ou um array de erro.
     */
    public static function consulta(string $query, array $params = [], bool $notdie = false)
    {
        self::$insert_id = null; 
        
        try {
            $pdo = self::getInstancia();

            $stmt = $pdo->prepare($query);
            $stmt->execute($params);

            if (stripos(trim($query), 'INSERT') === 0) {
                 self::$insert_id = $pdo->lastInsertId();
            }
            
            return $stmt; 

        } catch (PDOException $e) {
            if ($notdie) {
                return [
                    'error_code' => $e->getCode(),
                    'error_desc' => $e->getMessage()
                ];
            }
            
            die("<b>Ocorreu um erro ao executar a consulta:</b><br>" . $e->getMessage());
        }
    }

    /**
     * Obtém o ID do último INSERT executado pela classe Conexao.
     * @return int|null
     */
    public static function getInsertId(): ?int
    {
        return self::$insert_id;
    }
}