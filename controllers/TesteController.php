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

    public function listarProvas($id) {
        $model = new Prova($this->db);
        $dados = $model->listarPorAluno($id);
        echo json_encode(["sucesso" => true, "endpoint" => "provas", "dados" => $dados]);
    }

    public function listarAvisos() {
        $model = new Aviso($this->db);
        $dados = $model->listarTodos();
        echo json_encode(["sucesso" => true, "endpoint" => "avisos", "dados" => $dados]);
    }

    public function listarChat($id) {
        $model = new Chat($this->db);
        $dados = $model->buscarHistorico($id);
        echo json_encode(["sucesso" => true, "endpoint" => "chat", "dados" => $dados]);
    }

    public function listarSolicitacoes($id) {
        $model = new Solicitacao($this->db);
        $dados = $model->listarPorAluno($id);
        echo json_encode(["sucesso" => true, "endpoint" => "solicitacoes", "dados" => $dados]);
    }
}
?>