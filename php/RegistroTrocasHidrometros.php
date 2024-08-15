<?php

class RegistroTrocasHidrometros {
    private $conn;
    private $table_name = "registro_trocas_hidrometros";

    public $id;
    public $usuario;
    public $os;
    public $codigo;
    public $testada;
    public $hretirado;
    public $hnovo;
    public $cavalete;
    public $solservico;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET usuario=:usuario, os=:os, codigo=:codigo, 
                      testada=:testada, hretirado=:hretirado, 
                      hnovo=:hnovo, cavalete=:cavalete, solservico=:solservico";

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

    public function read($offset = 0, $records_per_page = 5) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  LIMIT :offset, :records_per_page";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':records_per_page', $records_per_page, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt;
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->usuario = $row['usuario'];
        $this->os = $row['os'];
        $this->codigo = $row['codigo'];
        $this->testada = $row['testada'];
        $this->hretirado = $row['hretirado'];
        $this->hnovo = $row['hnovo'];
        $this->cavalete = $row['cavalete'];
        $this->solservico = $row['solservico'];
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET usuario = :usuario, os = :os, codigo = :codigo, 
                      testada = :testada, hretirado = :hretirado, 
                      hnovo = :hnovo, cavalete = :cavalete, 
                      solservico = :solservico 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':usuario', $this->usuario);
        $stmt->bindParam(':os', $this->os);
        $stmt->bindParam(':codigo', $this->codigo);
        $stmt->bindParam(':testada', $this->testada, PDO::PARAM_LOB);
        $stmt->bindParam(':hretirado', $this->hretirado, PDO::PARAM_LOB);
        $stmt->bindParam(':hnovo', $this->hnovo, PDO::PARAM_LOB);
        $stmt->bindParam(':cavalete', $this->cavalete, PDO::PARAM_LOB);
        $stmt->bindParam(':solservico', $this->solservico, PDO::PARAM_LOB);
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

    public function count() {
        $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total_rows'];
    }
}
?>
