<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Teste Token FCM</title>
    <style>body{font-family:sans-serif;padding:20px;background:#f4f4f4}.card{background:white;padding:20px;max-width:500px;margin:0 auto;border-radius:8px;box-shadow:0 2px 5px rgba(0,0,0,0.1)}input,textarea,select{width:100%;padding:10px;margin:5px 0 15px;box-sizing:border-box}button{width:100%;padding:10px;background:#F4D35E;border:none;font-weight:bold;cursor:pointer}pre{background:#222;color:#0f0;padding:10px;overflow:auto}</style>
</head>
<body>
    <div class="card">
        <h2>🔔 Salvar Token Push (POST)</h2>
        
        <label>ID do Aluno:</label>
        <input type="number" id="id_aluno" value="1">
        
        <label>Plataforma:</label>
        <select id="plataforma">
            <option value="android">Android</option>
            <option value="ios">iOS</option>
        </select>

        <label>Token FCM (Simulado):</label>
        <textarea id="token" rows="4">fcm_token_exemplo_simulado_1234567890</textarea>
        
        <button onclick="enviar()">SALVAR TOKEN</button>
        
        <h3>Resposta da API:</h3>
        <pre id="resultado">Aguardando...</pre>
    </div>

    <script>
        async function enviar() {
            const id_aluno = document.getElementById('id_aluno').value;
            const plataforma = document.getElementById('plataforma').value;
            const token = document.getElementById('token').value;
            
            // Ajuste a URL se necessário
            const url = 'http://localhost/api-escola/api.php?acao=salvar_token';

            try {
                const res = await fetch(url, {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({ id_aluno, token, plataforma })
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