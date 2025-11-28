<?php
class Prova {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function listarPorAluno($id_aluno) {
        $query = "SELECT p.id, p.titulo, p.data_prova, d.nome as disciplina 
                  FROM provas p
                  JOIN disciplines d ON p.id_disciplina = d.id
                  JOIN matriculas m ON m.id_disciplina = d.id
                  WHERE m.id_aluno = :id
                  ORDER BY p.data_prova ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id_aluno);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>