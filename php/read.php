<?php
ini_set('memory_limit', '1024M'); // Aumenta o limite de memória

include_once './Database.php';
include_once './RegistroTrocasHidrometros.php';

$database = new Database();
$db = $database->getConnection();

$registro = new RegistroTrocasHidrometros($db);

$stmt = $registro->read();
$num = $stmt->rowCount();

if ($num > 0) {
    $registros_arr = array();
    $registros_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $registro_item = array(
            "id" => $id,
            "usuario" => $usuario,
            "os" => $os,
            "codigo" => $codigo,
            "testada" => base64_encode($testada),
            "hretirado" => base64_encode($hretirado),
            "hnovo" => base64_encode($hnovo),
            "cavalete" => base64_encode($cavalete),
            "solservico" => base64_encode($solservico)
        );
        array_push($registros_arr["records"], $registro_item);

        unset($registro_item); // Libera memória
    }
    echo json_encode($registros_arr);
} else {
    echo json_encode(
        array("message" => "Nenhum registro encontrado.")
    );
}
?>
