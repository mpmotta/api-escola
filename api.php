<?php
// --- 1. CONFIGURAÇÕES DE ERRO ---
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// --- 2. PERMISSÕES DE ACESSO (CORS) ---
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// --- 3. IMPORTAR ARQUIVOS ---
$files = [
    'config/Database.php',
    'controllers/AuthController.php',
    'controllers/TesteController.php',
    'controllers/AppController.php'
];

foreach ($files as $file) {
    if (!file_exists($file)) {
        die(json_encode(["erro_critico" => "Arquivo faltando: $file"]));
    }
    require_once $file;
}

// --- 4. CONEXÃO COM O BANCO ---
try {
    $database = new Database();
    $db = $database->getConnection();
} catch (Exception $e) {
    die(json_encode(["erro_critico" => "Falha no banco: " . $e->getMessage()]));
}

// --- 5. ROTEAMENTO ---
$acao = isset($_GET['acao']) ? $_GET['acao'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : 1; 
$metodo = $_SERVER['REQUEST_METHOD'];

// Tenta pegar também da URL amigável se o GET estiver vazio
$path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
if (empty($acao) && !empty($path_info)) {
    $parts = explode('/', trim($path_info, '/'));
    $acao = isset($parts[0]) ? $parts[0] : '';
    if (isset($parts[1])) {
        $id = $parts[1];
    }
}

// Se não tiver ação nenhuma
if (empty($acao)) {
    echo json_encode(["status" => "API ONLINE", "mensagem" => "Use ?acao=avisos para testar"]);
    exit;
}

// --- 6. ROTAS (USANDO IF / ELSEIF) ---

// ---------------- AUTENTICAÇÃO ----------------
if ($acao == 'login') {
    if ($metodo == 'POST') {
        $auth = new AuthController($db);
        $auth->login();
    } else {
        echo json_encode(["erro" => "Login exige metodo POST"]);
    }
}

// ---------------- LEITURA (GET) ----------------
elseif ($acao == 'provas') {
    $controller = new TesteController($db);
    $controller->listarProvas($id);
}

elseif ($acao == 'avisos') {
    $controller = new TesteController($db);
    $controller->listarAvisos();
}

elseif ($acao == 'chat') {
    $controller = new TesteController($db);
    $controller->listarChat($id);
}

elseif ($acao == 'solicitacoes') {
    $controller = new TesteController($db);
    $controller->listarSolicitacoes($id);
}

// ---------------- ESCRITA (POST) ----------------
elseif ($acao == 'salvar_token') {
    if ($metodo == 'POST') {
        $app = new AppController($db);
        $app->salvarToken();
    } else {
        echo json_encode(["erro" => "Metodo incorreto"]);
    }
}

elseif ($acao == 'enviar_chat') {
    if ($metodo == 'POST') {
        $app = new AppController($db);
        $app->novaMensagemChat();
    } else {
        echo json_encode(["erro" => "Metodo incorreto"]);
    }
}

elseif ($acao == 'nova_solicitacao') {
    if ($metodo == 'POST') {
        $app = new AppController($db);
        $app->novaSolicitacao();
    } else {
        echo json_encode(["erro" => "Metodo incorreto"]);
    }
}

elseif ($acao == 'marcar_lido') {
    if ($metodo == 'POST') {
        $app = new AppController($db);
        $app->marcarAvisoLido();
    } else {
        echo json_encode(["erro" => "Metodo incorreto"]);
    }
}

elseif ($acao == 'disparar_aviso') { // <-- NOVO ENDPOINT DE DISPARO DA ESCOLA
    if ($metodo == 'POST') {
        $app = new AppController($db);
        $app->dispararAviso();
    } else {
        echo json_encode(["erro" => "Metodo incorreto"]);
    }
}

// ---------------- ROTA NÃO ENCONTRADA ----------------
else {
    http_response_code(404);
    echo json_encode(["erro" => "Rota '$acao' nao encontrada"]);
}
?>