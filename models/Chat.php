<?php
class Chat {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Busca histórico de mensagens (LISTA TODOS SE id_aluno FOR NULL)
    public function buscarHistorico($id_aluno = null) {
        $query = "SELECT 
                    c.*, 
                    a.nome_completo AS nome_aluno
                  FROM chat_nadd c
                  JOIN alunos a ON c.id_aluno = a.id";
        
        // CORREÇÃO DA LÓGICA: Se o ID NÃO É nulo E NÃO É 0, adiciona o WHERE
        if ($id_aluno !== null && $id_aluno != 0) {
            $query .= " WHERE c.id_aluno = :id";
        }
        
        $query .= " ORDER BY c.data_envio ASC";
        
        $stmt = $this->conn->prepare($query);
        
        if ($id_aluno !== null && $id_aluno != 0) {
            $stmt->bindParam(':id', $id_aluno);
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Função de escrita...
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