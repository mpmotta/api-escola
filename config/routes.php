<?php
// Definição das Rotas da API
// Formato: 'acao' => ['Metodo Aceito', 'Nome do Controller', 'Nome da Função']

return [
    // --- AUTENTICAÇÃO ---
    'login' => ['POST', 'AuthController', 'login'],

    // --- LEITURA (GET) ---
    'provas' => ['GET', 'TesteController', 'listarProvas'],
    'avisos' => ['GET', 'TesteController', 'listarAvisos'],
    'chat'   => ['GET', 'TesteController', 'listarChat'],
    'solicitacoes' => ['GET', 'TesteController', 'listarSolicitacoes'],

    // --- ESCRITA (POST) ---
    'salvar_token' => ['POST', 'AppController', 'salvarToken'],
    'enviar_chat'  => ['POST', 'AppController', 'novaMensagemChat'],
    'nova_solicitacao' => ['POST', 'AppController', 'novaSolicitacao'],
];
?>