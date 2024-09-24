<?php
class Horarios {
    private $conn;

    public function __construct() {
        // Conexão com o banco de dados
        $this->conn = new mysqli("localhost", "root", "", "tccdois");

        // Verifica se a conexão foi bem-sucedida
        if ($this->conn->connect_error) {
            die("Conexão falhou: " . $this->conn->connect_error);
        }
    }

    public function listar($clinica_id) {
        // Prepara a consulta para listar os horários da clínica
        $sql = "SELECT data, horario, disponibilidade FROM horarios WHERE clinica_id = ? ORDER BY data, horario";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $clinica_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $horarios = [];
        while ($row = $result->fetch_assoc()) {
            $horarios[] = $row;
        }

        // Fecha a conexão
        $stmt->close();
        return $horarios;
    }

    public function __destruct() {
        // Fecha a conexão quando a classe for destruída
        $this->conn->close();
    }
}
?>
