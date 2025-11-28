<?php
// Configurações de Cabeçalho (CORS)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Incluir arquivos necessários
require_once 'config/Database.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/TesteController.php'; // <--- Adicionamos este

// Iniciar Conexão
$database = new Database();
$db = $database->getConnection();

// Ler qual ação o App/Navegador quer executar
$acao = isset($_GET['acao']) ? $_GET['acao'] : '';

switch ($acao) {
    // Rota de Login (POST)
    case 'login':
        $auth = new AuthController($db);
        $auth->login();
        break;

    // --- ROTAS DE TESTE (GET) ---
    case 'ver_provas':
        $teste = new TesteController($db);
        $teste->listarProvas();
        break;

    case 'ver_avisos':
        $teste = new TesteController($db);
        $teste->listarAvisos();
        break;

    case 'ver_chat':
        $teste = new TesteController($db);
        $teste->listarChat();
        break;

    case 'ver_solicitacoes':
        $teste = new TesteController($db);
        $teste->listarSolicitacoes();
        break;

    default:
        echo json_encode(["sucesso" => false, "mensagem" => "Rota não encontrada."]);
        break;
}
?>