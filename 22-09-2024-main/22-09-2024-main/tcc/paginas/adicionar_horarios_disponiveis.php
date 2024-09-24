<?php
session_start(); // Inicie a sessão

$message = ''; // Inicializa a variável
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); // Limpa a mensagem após exibição
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tccdois";

// Criando conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificando a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Obtendo o ID do veterinário (considerando que só haverá um por clínica)
$clinica_id = $_SESSION['clinica_id'];

// Adicionando tratamento de erro para a consulta SQL
$sql = "SELECT id FROM veterinarios WHERE clinica_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Erro na preparação da consulta: " . $conn->error);
}

$stmt->bind_param("i", $clinica_id);
$stmt->execute();
$result = $stmt->get_result();

// Verificando se foi encontrado um veterinário
if ($result->num_rows > 0) {
    $veterinario = $result->fetch_assoc();
    $veterinario_id = $veterinario['id'];
} else {
    die("Nenhum veterinário encontrado para esta clínica.");
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.1/css/boxicons.min.css">
    <style>
        /* Estilos semelhantes ao formulário de adicionar cliente */
        body {
            background-image: url(https://img.freepik.com/free-vector/cat-lover-pattern-background-design_53876-100662.jpg?t=st=1727098307~exp=1727101907~hmac=71100b70a50679ff101ccace3876aa8ec8eff768f242ed477a284f39dcbc473f&w=1380);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex; 
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            display: flex;
            align-items: flex-start;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 1000px;
            width: 80%;
        }
        h2 {
            text-align: center;
            flex-basis: 100%;
        }
        .form-content {
            flex-grow: 1;
        }
        .input-group {
            margin-bottom: 15px;
        }
        .input-group label {
            display: block;
            margin-bottom: 5px;
        }
        .input-with-icon {
            position: relative;
        }
        .input-with-icon i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #888;
        }
        .input-with-icon input {
            width: 100%;
            padding: 10px 0px 10px 0px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .button-container {
            text-align: center;
        }
        .button-container button {
            padding: 10px 25px;
            background-color: #7c655c;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .button-container button:hover {
            background-color: #45a049;
        }
        .message {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #dff0d8;
            color: #3c763d;
            padding: 15px 20px;
            border: 1px solid #d6e9c6;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            display: none; /* Inicialmente escondido */
        }
    </style>
    <title>Adicionar Horários Disponíveis</title>
</head>
<body>
<div class="message" id="message"><?php echo $message; ?></div>

<h1 class="titulo-cliente">Cadastro de Horário Disponível</h1>
<div class="form-container">
    <div class="form-content">
        <h2>Adicionar Horário Disponível</h2>
        <form id="formAddHorario" method="POST" action="salvar_horario.php">
            <input type="hidden" name="veterinario_id" value="<?php echo $veterinario_id; ?>">

            <div class="input-group">
                <label for="data_hora">Data e Hora:</label>
                <div class="input-with-icon">
                    <i class='bx bx-calendar'></i>
                    <input type="datetime-local" name="data_hora" required>
                </div>
            </div>

            <div class="input-group">
                <label for="status">Status:</label>
                <div class="input-with-icon">
                    <i class='bx bx-check-circle'></i>
                    <input type="text" name="status" required placeholder="Por exemplo: Disponível">
                </div>
            </div>

            <div class="button-container">
                <button type="submit">Salvar</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Exibe a mensagem se existir
    window.onload = function() {
        var messageElement = document.getElementById('message');
        if (messageElement.innerHTML.trim() !== '') {
            messageElement.style.display = 'block'; // Mostra a mensagem
            setTimeout(function() {
                messageElement.style.display = 'none'; // Esconde após 4 segundos
                window.location.href = 'agenda.php'; // Redireciona para outra página após 4 segundos
            }, 4000); // 4000 milissegundos = 4 segundos
        }
    };
</script>
</body>
</html>
