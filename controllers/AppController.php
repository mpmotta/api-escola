<?php
require_once 'models/Aluno.php';
require_once 'models/Chat.php';
require_once 'models/Solicitacao.php';

class AppController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // 1. Salvar Token do Firebase (Para notificações)
    public function salvarToken() {
        $data = json_decode(file_get_contents("php://input"));
        
        if(!isset($data->id_aluno) || !isset($data->token)) {
            echo json_encode(["sucesso" => false, "mensagem" => "Dados incompletos"]);
            return;
        }
        
        $model = new Aluno($this->db);
        // Se o app não mandar a plataforma, assume android
        $plat = isset($data->plataforma) ? $data->plataforma : 'android';
        
        if($model->atualizarToken($data->id_aluno, $data->token, $plat)) {
            echo json_encode(["sucesso" => true, "mensagem" => "Token atualizado"]);
        } else {
            echo json_encode(["sucesso" => false, "mensagem" => "Erro ao salvar token"]);
        }
    }

    // 2. Enviar nova mensagem no Chat
    public function novaMensagemChat() {
        $data = json_decode(file_get_contents("php://input"));
        
        if(!isset($data->id_aluno) || !isset($data->mensagem)) {
            echo json_encode(["sucesso" => false, "mensagem" => "Dados incompletos"]);
            return;
        }

        $model = new Chat($this->db);
        if($model->enviarMensagem($data->id_aluno, $data->mensagem)) {
            echo json_encode(["sucesso" => true, "mensagem" => "Enviado"]);
        } else {
            echo json_encode(["sucesso" => false, "mensagem" => "Erro ao enviar"]);
        }
    }

    // 3. Criar nova solicitação (Atestado/Financeiro)
    public function novaSolicitacao() {
        $data = json_decode(file_get_contents("php://input"));
        
        if(!isset($data->id_aluno) || !isset($data->setor) || !isset($data->mensagem)) {
            echo json_encode(["sucesso" => false, "mensagem" => "Dados incompletos"]);
            return;
        }

        $model = new Solicitacao($this->db);
        // Assunto é opcional, se não vier fica vazio
        $assunto = isset($data->assunto) ? $data->assunto : '';

        if($model->criar($data->id_aluno, $data->setor, $assunto, $data->mensagem)) {
            echo json_encode(["sucesso" => true, "mensagem" => "Solicitação criada"]);
        } else {
            echo json_encode(["sucesso" => false, "mensagem" => "Erro ao criar"]);
        }
    }
}
?>