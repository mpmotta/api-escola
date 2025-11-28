<?php
class Aluno {
    private $conn;
    private $table_name = "alunos";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Função para buscar aluno pelo RA (Login)
    public function buscarPorRA($ra) {
        $query = "SELECT id, nome_completo, senha FROM " . $this->table_name . " WHERE ra = :ra AND ativo = 1 LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":ra", $ra);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Nova Função: Salvar o Token FCM (Notificações)
    public function atualizarToken($id_aluno, $token, $plataforma) {
        // 1. Remove se esse token já existir (evita duplicidade)
        $sql = "DELETE FROM tokens_dispositivos WHERE token_fcm = :token";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':token', $token);
        $stmt->execute();

        // 2. Insere o novo vínculo
        $query = "INSERT INTO tokens_dispositivos (id_aluno, token_fcm, plataforma) VALUES (:id, :token, :plat)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id_aluno);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':plat', $plataforma);
        
        return $stmt->execute();
    }
}
?>