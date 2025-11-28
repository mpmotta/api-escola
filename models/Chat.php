<?php
class Chat {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Busca histórico de mensagens
    public function buscarHistorico($id_aluno) {
        $query = "SELECT * FROM chat_nadd WHERE id_aluno = :id ORDER BY data_envio ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id_aluno);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Nova função: Salvar mensagem enviada pelo aluno
    public function enviarMensagem($id_aluno, $mensagem) {
        $query = "INSERT INTO chat_nadd (id_aluno, remetente, tipo_mensagem, mensagem) 
                  VALUES (:id, 'ALUNO', 'TEXTO', :msg)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id_aluno);
        $stmt->bindParam(':msg', $mensagem);
        return $stmt->execute();
    }
}
?>