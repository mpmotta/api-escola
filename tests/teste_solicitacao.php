<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Teste Solicitação</title>
    <style>body{font-family:sans-serif;padding:20px;background:#f4f4f4}.card{background:white;padding:20px;max-width:500px;margin:0 auto;border-radius:8px;box-shadow:0 2px 5px rgba(0,0,0,0.1)}input,textarea,select{width:100%;padding:10px;margin:5px 0 15px;box-sizing:border-box}button{width:100%;padding:10px;background:#F4D35E;border:none;font-weight:bold;cursor:pointer}pre{background:#222;color:#0f0;padding:10px;overflow:auto}</style>
</head>
<body>
    <div class="card">
        <h2>📄 Abrir Solicitação (POST)</h2>
        
        <label>ID do Aluno:</label>
        <input type="number" id="id_aluno" value="1">
        
        <label>Setor:</label>
        <select id="setor">
            <option value="SECRETARIA">Secretaria</option>
            <option value="FINANCEIRO">Financeiro</option>
            <option value="FALE_CONOSCO">Fale Conosco</option>
        </select>

        <label>Assunto:</label>
        <input type="text" id="assunto" value="Atestado de Matrícula">

        <label>Mensagem:</label>
        <textarea id="mensagem" rows="3">Gostaria de solicitar meu documento.</textarea>
        
        <button onclick="enviar()">CRIAR TICKET</button>
        
        <h3>Resposta da API:</h3>
        <pre id="resultado">Aguardando...</pre>
    </div>

    <script>
        async function enviar() {
            const id_aluno = document.getElementById('id_aluno').value;
            const setor = document.getElementById('setor').value;
            const assunto = document.getElementById('assunto').value;
            const mensagem = document.getElementById('mensagem').value;
            
            // Ajuste a URL se necessário (api-escola ou escola_api)
            const url = 'http://localhost/api-escola/api.php?acao=nova_solicitacao';

            try {
                const res = await fetch(url, {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({ id_aluno, setor, assunto, mensagem })
                });
                const json = await res.json();
                document.getElementById('resultado').textContent = JSON.stringify(json, null, 2);
            } catch (err) {
                document.getElementById('resultado').textContent = 'Erro: ' + err.message;
            }
        }
    </script>
</body>
</html>