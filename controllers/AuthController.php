<?php
require_once 'models/Aluno.php';

class AuthController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function login() {
        // 1. Recebe o JSON
        $data = json_decode(file_get_contents("php://input"));

        if(empty($data->ra) || empty($data->senha)) {
            echo json_encode(["sucesso" => false, "mensagem" => "Dados incompletos."]);
            return;
        }

        // 2. Chama o Model
        $alunoModel = new Aluno($this->db);
        $aluno = $alunoModel->buscarPorRA($data->ra);

        // 3. Valida a Senha
        if($aluno && $aluno['senha'] == $data->senha) {
            // Login Correto
            $token = md5($aluno['id'] . time() . 'segredo_escola');
            
            echo json_encode([
                "sucesso" => true,
                "mensagem" => "Login realizado com sucesso.",
                "token" => $token,
                "usuario" => [
                    "id" => $aluno['id'],
                    "nome" => $aluno['nome_completo'],
                    "ra" => $data->ra
                ]
            ]);
        } else {
            // Login Errado
            echo json_encode(["sucesso" => false, "mensagem" => "RA ou Senha inválidos."]);
        }
    }
}
?>