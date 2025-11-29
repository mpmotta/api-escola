<?php
require_once 'models/Prova.php';
require_once 'models/Aviso.php';
require_once 'models/Chat.php';
require_once 'models/Solicitacao.php';

class TesteController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Rotas GET devem aceitar o ID (para o App) ou NULO (para o Painel Admin)

    public function listarProvas($id_aluno) {
        $model = new Prova($this->db);
        $dados = $model->listarPorAluno($id_aluno);
        echo json_encode(["sucesso" => true, "endpoint" => "provas", "dados" => $dados]);
    }

    public function listarAvisos() {
        $model = new Aviso($this->db);
        $dados = $model->listarTodos();
        echo json_encode(["sucesso" => true, "endpoint" => "avisos", "dados" => $dados]);
    }

    public function listarChat($id_aluno = null) { // <--- CORREÇÃO AQUI
        $model = new Chat($this->db);
        
        // Se id_aluno for 0 ou null, ele lista TUDO (passa o null para o model)
        if ($id_aluno == 0) $id_aluno = null; 

        $dados = $model->buscarHistorico($id_aluno);
        
        echo json_encode(["sucesso" => true, "endpoint" => "chat", "dados" => $dados]);
    }

    public function listarSolicitacoes($id_aluno) {
        $model = new Solicitacao($this->db);
        $dados = $model->listarPorAluno($id_aluno);
        echo json_encode(["sucesso" => true, "endpoint" => "solicitacoes", "dados" => $dados]);
    }
}
?>