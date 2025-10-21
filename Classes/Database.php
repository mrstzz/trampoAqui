<?php
class Database {
    private $host = "localhost";
    private $dbname = "loja";
    private $username = "root";
    private $password = "";
    private $conn;

    protected function connect() {
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION, PDO::FETCH_ASSOC);
            return $this->conn;

        } catch (PDOException $e) {
            echo "Erro na conexão: " . $e->getMessage();
            return null;
        }
    }
}
?>
