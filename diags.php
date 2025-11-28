<?php
// Diagnóstico Completo do Ambiente
header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h1>Diagnóstico da API Alcides Maya</h1>";

// 1. VERIFICAR ARQUIVOS
echo "<h3>1. Verificação de Arquivos</h3>";
$arquivos = [
    'config/Database.php',
    'models/Aluno.php',
    'models/Chat.php',
    'models/Aviso.php',
    'models/Solicitacao.php',
    'models/Prova.php',
    'controllers/TesteController.php'
];

foreach ($arquivos as $arq) {
    if (file_exists($arq)) {
        echo "<div style='color:green'>[OK] Arquivo encontrado: $arq</div>";
    } else {
        echo "<div style='color:red; font-weight:bold'>[ERRO] Arquivo FALTANDO: $arq</div>";
    }
}

// 2. VERIFICAR CONEXÃO COM BANCO
echo "<h3>2. Teste de Conexão MySQL</h3>";
require_once 'config/Database.php';
try {
    $database = new Database();
    $db = $database->getConnection();
    echo "<div style='color:green'>[OK] Conexão com o banco 'escola_app' realizada com sucesso!</div>";
} catch (Exception $e) {
    echo "<div style='color:red'>[ERRO] Falha na conexão: " . $e->getMessage() . "</div>";
    exit; // Se não conecta, para por aqui
}

// 3. TESTAR QUERIES (Se tem dados)
echo "<h3>3. Teste de Conteúdo (Aluno ID 1)</h3>";

function testarQuery($db, $sql, $nome) {
    try {
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $total = $stmt->rowCount();
        if ($total > 0) {
            echo "<div style='color:green'>[OK] $nome: Encontrou $total registro(s).</div>";
        } else {
            echo "<div style='color:orange'>[AVISO] $nome: Tabela existe, mas retornou 0 registros.</div>";
        }
    } catch (Exception $e) {
        echo "<div style='color:red'>[ERRO CRÍTICO] $nome: " . $e->getMessage() . "</div>";
    }
}

testarQuery($db, "SELECT * FROM alunos WHERE id = 1", "Tabela Alunos");
testarQuery($db, "SELECT * FROM chat_nadd", "Tabela Chat");
testarQuery($db, "SELECT * FROM avisos", "Tabela Avisos");
testarQuery($db, "SELECT * FROM solicitacoes", "Tabela Solicitações");
testarQuery($db, "SELECT * FROM provas", "Tabela Provas");

echo "<hr><h3>Conclusão</h3>";
echo "Se houver algum item em VERMELHO acima, corrija antes de testar a API.";
?>