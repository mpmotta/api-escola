<?php
require_once 'models/Chat.php';

class ChatController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // LISTAR HISTÓRICO - Aceita ID ou NULO (para listar tudo)
    public function listarHistorico($id_aluno = null) {
        $model = new Chat($this->db);
        
        // Se id_aluno for 0 ou nulo, o Model buscará todos os chats (listagem)
        if ($id_aluno == 0) $id_aluno = null; 

        $dados = $model->buscarHistorico($id_aluno);
        
        echo json_encode(["sucesso" => true, "endpoint" => "chat_historico", "dados" => $dados]);
    }
}
?>