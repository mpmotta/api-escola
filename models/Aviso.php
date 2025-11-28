<?php
class Aviso {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function listarTodos() {
        // Busca avisos gerais (sem turma específica)
        $query = "SELECT * FROM avisos WHERE id_turma_alvo IS NULL ORDER BY data_envio DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>