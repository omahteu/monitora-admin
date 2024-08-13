<?php

class RegistroTrocasHidrometros {
    private $conn;
    private $table_name = "registro_trocas_hidrometros";

    public $id;
    public $os;
    public $codigo;
    public $testada;
    public $hretirado;
    public $hnovo;
    public $cavalete;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET usuario=:usuario, os=:os, codigo=:codigo, testada=:testada, hretirado=:hretirado, hnovo=:hnovo, cavalete=:cavalete, solservico=:solservico";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":usuario", $this->usuario);
        $stmt->bindParam(":os", $this->os);
        $stmt->bindParam(":codigo", $this->codigo);
        $stmt->bindParam(":testada", $this->testada, PDO::PARAM_LOB);
        $stmt->bindParam(":hretirado", $this->hretirado, PDO::PARAM_LOB);
        $stmt->bindParam(":hnovo", $this->hnovo, PDO::PARAM_LOB);
        $stmt->bindParam(":cavalete", $this->cavalete, PDO::PARAM_LOB);
        $stmt->bindParam(":solservico", $this->solservico, PDO::PARAM_LOB);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->os = $row['os'];
        $this->codigo = $row['codigo'];
        $this->testada = $row['testada'];
        $this->hretirado = $row['hretirado'];
        $this->hnovo = $row['hnovo'];
        $this->cavalete = $row['cavalete'];
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET os = :os, codigo = :codigo, testada = :testada, hretirado = :hretirado, hnovo = :hnovo, cavalete = :cavalete WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':os', $this->os);
        $stmt->bindParam(':codigo', $this->codigo);
        $stmt->bindParam(':testada', $this->testada, PDO::PARAM_LOB);
        $stmt->bindParam(':hretirado', $this->hretirado, PDO::PARAM_LOB);
        $stmt->bindParam(':hnovo', $this->hnovo, PDO::PARAM_LOB);
        $stmt->bindParam(':cavalete', $this->cavalete, PDO::PARAM_LOB);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>
