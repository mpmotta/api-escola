<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Teste Marcar Lido</title>
    <style>body{font-family:sans-serif;padding:20px;background:#f4f4f4}.card{background:white;padding:20px;max-width:500px;margin:0 auto;border-radius:8px;box-shadow:0 2px 5px rgba(0,0,0,0.1)}input{width:100%;padding:10px;margin:5px 0 15px;box-sizing:border-box}button{width:100%;padding:10px;background:#F4D35E;border:none;font-weight:bold;cursor:pointer}pre{background:#222;color:#0f0;padding:10px;overflow:auto}</style>
</head>
<body>
    <div class="card">
        <h2>✅ Marcar Aviso como Lido (POST)</h2>
        <p>Use o ID de um aviso existente (ex: 1) e o ID do aluno (ex: 1).</p>

        <label>ID do Aluno (Leitor):</label>
        <input type="number" id="id_aluno" value="1">
        
        <label>ID do Aviso Lido:</label>
        <input type="number" id="id_aviso" value="1">
        
        <button onclick="enviar()">MARCAR COMO LIDO</button>
        
        <h3>Resposta da API:</h3>
        <pre id="resultado">Aguardando...</pre>
    </div>

    <script>
        async function enviar() {
            const id_aluno = document.getElementById('id_aluno').value;
            const id_aviso = document.getElementById('id_aviso').value;
            
            // URL ajustada para o seu ambiente
            const url = 'http://localhost/api-escola/api.php?acao=marcar_lido';

            try {
                const res = await fetch(url, {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({ id_aluno, id_aviso })
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