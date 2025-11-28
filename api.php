<?php
// --- 1. MOSTRAR ERROS (Para você ver se algo der errado) ---
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

// --- 3. IMPORTAR ARQUIVOS (Se faltar algum, ele avisa) ---
$files = [
    'config/Database.php',
    'controllers/AuthController.php',
    'controllers/TesteController.php',
    'controllers/AppController.php'
];

foreach ($files as $file) {
    if (!file_exists($file)) {
        die(json_encode(["erro_critico" => "Arquivo faltando: $file. Verifique as pastas controllers e config."]));
    }
    require_once $file;
}

// --- 4. CONECTAR NO BANCO ---
try {
    $database = new Database();
    $db = $database->getConnection();
} catch (Exception $e) {
    die(json_encode(["erro_critico" => "Banco não conectou: " . $e->getMessage()]));
}

// --- 5. ROTEADOR HÍBRIDO (O Segredo para funcionar no XAMPP) ---

// Tenta ler do jeito bonito (/provas)
$path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
$parts = explode('/', trim($path_info, '/'));
$recurso_path = isset($parts[0]) ? $parts[0] : '';
$id_path = isset($parts[1]) ? $parts[1] : null;

// Tenta ler do jeito clássico (?acao=provas)
$recurso_get = isset($_GET['acao']) ? $_GET['acao'] : '';
$id_get = isset($_GET['id']) ? $_GET['id'] : null;

// Se o clássico existir, usa ele. Se não, usa o bonito.
$recurso = $recurso_get ? $recurso_get : $recurso_path;
$id = $id_get ? $id_get : $id_path;

// Se não tiver nada, mostra que está vivo
if (empty($recurso)) {
    echo json_encode([
        "status" => "API ONLINE",
        "ambiente" => "Windows/XAMPP",
        "dica" => "Tente acessar: /api.php?acao=avisos"
    ]);
    exit;
}

$metodo = $_SERVER['REQUEST_METHOD'];

// --- 6. SWITCH DE ROTAS ---

switch ($recurso) {
    // --- LEITURA (GET) ---
    case 'provas':
        $controller = new TesteController($db);
        $alunoId = $id ? $id : 1; 
        $controller->listarProvas($alunoId);
        break;

    case 'avisos':
        $controller = new TesteController($db);
        $controller->listarAvisos();
        break;

    case 'chat':
        $controller = new TesteController($db);
        $alunoId = $id ? $id : 1;
        $controller->listarChat($alunoId);
        break;

    case 'solicitacoes':
        $controller = new TesteController($db);
        $alunoId = $id ? $id : 1;
        $controller->listarSolicitacoes($alunoId);
        break;

    // --- LOGIN (POST) ---
    case 'login':
        if ($metodo === 'POST') {
            $auth = new AuthController($db);
            $auth->login();
        } else {
            echo json_encode(["erro" => "Login exige metodo POST"]);
        }
        break;

    // --- ESCRITA (POST) ---
    case 'salvar_token':
        if ($metodo === 'POST') {
            $app = new AppController($db);
            $app->salvarToken();
        }
        break;

    case 'enviar_chat':
        if ($metodo === 'POST') {
            $app = new AppController($db);
            $app->novaMensagemChat();
        }
        break;

    case 'nova_solicitacao':
        if ($metodo === 'POST') {
            $app = new AppController($db);
            $app->novaSolicitacao();
        }
        break;

    default:
        http_response_code(404);
        echo json_encode([
            "erro" => "Rota nao encontrada",
            "tentativa" => $recurso
        ]);
        break;
}
?>