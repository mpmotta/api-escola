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
    
    public function marcarLido($id_aviso, $id_aluno) {
        // Insere na tabela avisos_lidos, se não existir
        $query = "INSERT IGNORE INTO avisos_lidos (id_aviso, id_aluno) VALUES (:aviso, :aluno)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':aviso', $id_aviso);
        $stmt->bindParam(':aluno', $id_aluno);
        return $stmt->execute();
    }
    
    // Nova Função: Inserir novo aviso (chamada pelo Painel da Escola)
    public function criarAviso($titulo, $corpo, $prioridade, $id_turma_alvo) {
        $query = "INSERT INTO avisos (titulo, corpo, prioridade, id_turma_alvo) 
                  VALUES (:titulo, :corpo, :prioridade, :id_turma)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':corpo', $corpo);
        $stmt->bindParam(':prioridade', $prioridade);
        $stmt->bindParam(':id_turma', $id_turma_alvo);

        return $stmt->execute();
    }
}
?>