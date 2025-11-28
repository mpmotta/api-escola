<?php
class Solicitacao {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Busca histórico de solicitações
    public function listarPorAluno($id_aluno) {
        $query = "SELECT * FROM solicitacoes WHERE id_aluno = :id ORDER BY data_criacao DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id_aluno);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Nova função: Criar uma nova solicitação
    public function criar($id_aluno, $setor, $assunto, $mensagem) {
        $query = "INSERT INTO solicitacoes (id_aluno, setor, assunto, mensagem) 
                  VALUES (:id, :setor, :assunto, :msg)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id_aluno);
        $stmt->bindParam(':setor', $setor);
        $stmt->bindParam(':assunto', $assunto);
        $stmt->bindParam(':msg', $mensagem);
        return $stmt->execute();
    }
}
?>