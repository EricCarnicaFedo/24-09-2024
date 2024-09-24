<?php
class Tutor
{
    private $id; // Alterado para 'id'
    private $nome;
    private $email;
    private $telefone; // Se não estiver na tabela, remova
    private $endereco; // Se não estiver na tabela, remova
    private $cidade; // Se não estiver na tabela, remova
    private $estado; // Se não estiver na tabela, remova
    private $cep; // Se não estiver na tabela, remova

    // Métodos setters
    public function setId($valor) {
        $this->id = $valor;
    }

    public function setNome($valor) {
        $this->nome = $valor;
    }

    public function setEmail($valor) {
        $this->email = $valor;
    }

    // Outros setters podem ser removidos se não forem usados

    // Métodos getters
    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getEmail() {
        return $this->email;
    }

    // Outros getters podem ser removidos se não forem usados

    // Listar todos os tutores
    public function listar() {
        require("conexaobd.php");
    
        // Atualizando a consulta para incluir todos os campos necessários
        $consulta = "SELECT id, nome, email, telefone, endereco, cidade, estado, cep FROM tutores ORDER BY nome"; 
        $resultado = $pdo->prepare($consulta);
        $resultado->execute();
    
        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Consultar um tutor específico
    public function consultar($id) {
        require("conexaobd.php");

        $comando = "SELECT id, nome, email FROM tutores WHERE id = :id"; 
        $resultado = $pdo->prepare($comando);
        $resultado->bindParam(':id', $id);
        $resultado->execute();

        return $resultado->fetch(PDO::FETCH_ASSOC);
    }

    // Inserir um novo tutor
    public function inserir() {
        require("conexaobd.php");

        $comando = "INSERT INTO tutores (nome, email) VALUES (:nome, :email)";
        $resultado = $pdo->prepare($comando);

        $resultado->bindParam(':nome', $this->nome);
        $resultado->bindParam(':email', $this->email);

        return $resultado->execute();
    }

    // Alterar um tutor existente
    public function alterar() {
        require("conexaobd.php");

        $comando = "UPDATE tutores SET nome = :nome, email = :email WHERE id = :id"; 
        $resultado = $pdo->prepare($comando);

        $resultado->bindParam(':id', $this->id);
        $resultado->bindParam(':nome', $this->nome);
        $resultado->bindParam(':email', $this->email);

        return $resultado->execute();
    }

    // Excluir um tutor
    public function excluir($id) {
        require("conexaobd.php");

        $comando = "DELETE FROM tutores WHERE id = :id"; 
        $resultado = $pdo->prepare($comando);
        $resultado->bindParam(':id', $id);

        return $resultado->execute();
    }
}


