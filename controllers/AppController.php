<?php
// Imports todos os Models que este controller de escrita usa
require_once 'models/Aluno.php';
require_once 'models/Chat.php';
require_once 'models/Solicitacao.php';
require_once 'models/Aviso.php'; 

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
        $assunto = isset($data->assunto) ? $data->assunto : '';

        if($model->criar($data->id_aluno, $data->setor, $assunto, $data->mensagem)) {
            echo json_encode(["sucesso" => true, "mensagem" => "Solicitação criada"]);
        } else {
            echo json_encode(["sucesso" => false, "mensagem" => "Erro ao criar"]);
        }
    }

    // 4. Marcar Aviso como Lido (Alunos - POST)
    public function marcarAvisoLido() {
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->id_aviso) || !isset($data->id_aluno)) {
            echo json_encode(["sucesso" => false, "mensagem" => "ID do aluno e aviso são obrigatórios."]);
            return;
        }

        $model = new Aviso($this->db);
        if ($model->marcarLido($data->id_aviso, $data->id_aluno)) {
            echo json_encode(["sucesso" => true, "mensagem" => "Aviso marcado como lido."]);
        } else {
            echo json_encode(["sucesso" => false, "mensagem" => "Erro ao marcar."]);
        }
    }
    
    // 5. Disparar Aviso (Escola - POST) - FUNÇÃO QUE ESTAVA FALTANDO
    public function dispararAviso() {
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->titulo) || !isset($data->corpo)) {
             echo json_encode(["sucesso" => false, "mensagem" => "Título e corpo são obrigatórios."]);
             return;
        }

        $prioridade = isset($data->prioridade) ? $data->prioridade : 'normal';
        // id_turma_alvo pode ser null, mas o POST envia uma string vazia ou 0
        $id_turma_alvo = isset($data->id_turma_alvo) && $data->id_turma_alvo > 0 ? $data->id_turma_alvo : null; 

        $model = new Aviso($this->db);
        
        // Salva no banco de dados primeiro
        if ($model->criarAviso($data->titulo, $data->corpo, $prioridade, $id_turma_alvo)) {
            
            // LÓGICA DE ENVIO DE PUSH VITAL ENTRARIA AQUI DEPOIS
            
            echo json_encode(["sucesso" => true, "mensagem" => "Aviso salvo e notificação (simulada) disparada com sucesso."]);
        } else {
            echo json_encode(["sucesso" => false, "mensagem" => "Erro ao salvar aviso no banco."]);
        }
    }
}
?>
