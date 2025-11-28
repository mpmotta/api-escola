<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Testes API - Alcides Maya</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f6f9; color: #333; padding: 20px; }
        .container { max-width: 900px; margin: 0 auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        
        .header { display: flex; align-items: center; border-bottom: 3px solid #F4D35E; padding-bottom: 20px; margin-bottom: 30px; }
        .logo-circle { width: 60px; height: 60px; background: #F4D35E; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 24px; margin-right: 15px; }
        h1 { margin: 0; color: #2c3e50; }
        p.subtitle { color: #7f8c8d; margin-top: 5px; }

        .section-title { font-size: 1.2em; color: #34495e; margin-top: 30px; margin-bottom: 15px; display: flex; align-items: center; }
        .section-title::before { content: ''; display: inline-block; width: 5px; height: 20px; background: #F4D35E; margin-right: 10px; border-radius: 2px; }

        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 15px; }

        a.card { 
            display: block; 
            text-decoration: none; 
            background: white; 
            border: 1px solid #e0e0e0; 
            border-radius: 8px; 
            padding: 20px; 
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        a.card:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); border-color: #F4D35E; }
        
        .card-title { font-weight: bold; font-size: 1.1em; margin-bottom: 5px; display: block; }
        .card-method { font-size: 0.8em; font-weight: bold; padding: 3px 8px; border-radius: 4px; display: inline-block; margin-bottom: 10px; }
        .card-desc { font-size: 0.9em; color: #666; }

        .get { color: #00b894; background: #e0f9f1; }
        .post { color: #0984e3; background: #e1f0fa; }

        .footer { margin-top: 40px; text-align: center; font-size: 0.9em; color: #aaa; border-top: 1px solid #eee; padding-top: 20px; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <div class="logo-circle">A</div>
        <div>
            <h1>Painel de Controle da API</h1>
            <p class="subtitle">Backend Alcides Maya • Ambiente de Testes</p>
        </div>
    </div>

    <!-- SEÇÃO DE LEITURA (GET) -->
    <div class="section-title">Leitura de Dados (GET)</div>
    <div class="grid">
        <a href="api.php?acao=provas&id=1" target="_blank" class="card">
            <span class="card-method get">GET</span>
            <span class="card-title">Listar Provas</span>
            <span class="card-desc">Retorna as provas do aluno ID 1.</span>
        </a>

        <a href="api.php?acao=avisos" target="_blank" class="card">
            <span class="card-method get">GET</span>
            <span class="card-title">Listar Avisos</span>
            <span class="card-desc">Retorna avisos gerais da escola.</span>
        </a>

        <a href="api.php?acao=chat&id=1" target="_blank" class="card">
            <span class="card-method get">GET</span>
            <span class="card-title">Histórico do Chat</span>
            <span class="card-desc">Ver conversas do aluno com o NADD.</span>
        </a>

        <a href="api.php?acao=solicitacoes&id=1" target="_blank" class="card">
            <span class="card-method get">GET</span>
            <span class="card-title">Minhas Solicitações</span>
            <span class="card-desc">Ver status de tickets abertos.</span>
        </a>
    </div>

    <!-- SEÇÃO DE ENVIO (POST) -->
    <div class="section-title">Envio e Ação (POST)</div>
    <p style="margin-bottom: 15px; color: #666;">
        Estes botões abrem scripts de teste localizados na pasta <code>tests/</code>.
    </p>
    <div class="grid">
        <a href="tests/teste_login.php" target="_blank" class="card">
            <span class="card-method post">POST</span>
            <span class="card-title">Realizar Login</span>
            <span class="card-desc">Simula envio de RA e Senha.</span>
        </a>

        <a href="tests/teste_chat.php" target="_blank" class="card">
            <span class="card-method post">POST</span>
            <span class="card-title">Enviar Mensagem</span>
            <span class="card-desc">Simula aluno enviando msg pro NADD.</span>
        </a>

        <a href="tests/teste_solicitacao.php" target="_blank" class="card">
            <span class="card-method post">POST</span>
            <span class="card-title">Abrir Solicitação</span>
            <span class="card-desc">Cria um novo ticket (Financeiro/Secretaria).</span>
        </a>

        <a href="tests/teste_token.php" target="_blank" class="card">
            <span class="card-method post">POST</span>
            <span class="card-title">Salvar Token Push</span>
            <span class="card-desc">Regista o dispositivo para notificações.</span>
        </a>
    </div>

    <div class="footer">
        API rodando em: <strong><?php echo $_SERVER['HTTP_HOST']; ?></strong>
    </div>
</div>

</body>
</html>