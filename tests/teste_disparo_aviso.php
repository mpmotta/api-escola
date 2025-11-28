<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Teste Disparo Aviso</title>
    <style>body{font-family:sans-serif;padding:20px;background:#f4f4f4}.card{background:white;padding:20px;max-width:500px;margin:0 auto;border-radius:8px;box-shadow:0 2px 5px rgba(0,0,0,0.1)}input,textarea,select{width:100%;padding:10px;margin:5px 0 15px;box-sizing:border-box}button{width:100%;padding:10px;background:#F4D35E;border:none;font-weight:bold;cursor:pointer}pre{background:#222;color:#0f0;padding:10px;overflow:auto}</style>
</head>
<body>
    <div class="card">
        <h2>📢 Disparar Novo Aviso (POST)</h2>
        <p>Isso simula a Coordenação salvando uma mensagem que será enviada aos alunos.</p>
        
        <label>Título:</label>
        <input type="text" id="titulo" value="ALERTA DE PROVA: Matrícula">
        
        <label>Mensagem:</label>
        <textarea id="corpo" rows="3">Lembrete: O prazo final é amanhã. Não faltem!</textarea>
        
        <label>Prioridade:</label>
        <select id="prioridade">
            <option value="normal">Normal</option>
            <option value="alta">ALTA (Sirene Vital)</option>
        </select>
        
        <button onclick="enviar()">DISPARAR AVISO</button>
        
        <h3>Resposta da API:</h3>
        <pre id="resultado">Aguardando...</pre>
    </div>

    <script>
        async function enviar() {
            const titulo = document.getElementById('titulo').value;
            const corpo = document.getElementById('corpo').value;
            const prioridade = document.getElementById('prioridade').value;
            
            // URL ajustada para o seu ambiente
            const url = 'http://localhost/api-escola/api.php?acao=disparar_aviso';

            try {
                const res = await fetch(url, {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({ titulo, corpo, prioridade })
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