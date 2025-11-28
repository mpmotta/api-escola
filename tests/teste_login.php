<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Teste Login</title>
    <style>body{font-family:sans-serif;padding:20px;background:#f4f4f4}.card{background:white;padding:20px;max-width:500px;margin:0 auto;border-radius:8px;box-shadow:0 2px 5px rgba(0,0,0,0.1)}input{width:100%;padding:10px;margin:5px 0 15px;box-sizing:border-box}button{width:100%;padding:10px;background:#F4D35E;border:none;font-weight:bold;cursor:pointer}pre{background:#222;color:#0f0;padding:10px;overflow:auto}</style>
</head>
<body>
    <div class="card">
        <h2>🔑 Testar Login (POST)</h2>
        <label>RA:</label>
        <input type="text" id="ra" value="2025001">
        <label>Senha:</label>
        <input type="text" id="senha" value="123">
        <button onclick="enviar()">LOGAR</button>
        
        <h3>Resposta da API:</h3>
        <pre id="resultado">Aguardando...</pre>
    </div>

    <script>
        async function enviar() {
            const ra = document.getElementById('ra').value;
            const senha = document.getElementById('senha').value;
            
            // URL Ajustada
            const url = 'http://localhost/api-escola/api.php?acao=login';

            try {
                const res = await fetch(url, {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({ ra, senha })
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