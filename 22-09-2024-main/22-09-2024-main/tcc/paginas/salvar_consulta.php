<?php
session_start(); // Inicie a sessão

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

// Capturando os dados do formulário
$nome_animal = $_POST['nome_animal'];
$raca = $_POST['raca'];
$proprietario = $_POST['proprietario'];
$data_consulta = $_POST['data_consulta'];
$hora_consulta = $_POST['hora_consulta'];
$descricao = $_POST['descricao'];
$status = $_POST['status'];

// Inserindo no banco de dados
$sql = "INSERT INTO consultas_marcadas (nome_animal, raca, proprietario, data_consulta, hora_consulta, descricao, status) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssss", $nome_animal, $raca, $proprietario, $data_consulta, $hora_consulta, $descricao, $status);

if ($stmt->execute()) {
    $_SESSION['message'] = "Consulta adicionada com sucesso!";
} else {
    $_SESSION['message'] = "Erro ao adicionar consulta: " . $conn->error;
}

$stmt->close();
$conn->close();

// Redirecionando para a página de adicionar consulta
header("Location: adicionarconsulta.php");
exit();
