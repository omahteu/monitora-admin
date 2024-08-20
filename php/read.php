<?php
ini_set('memory_limit', '1024M'); // Aumenta o limite de memória

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

include_once './Database.php';
include_once './RegistroTrocasHidrometros.php';

$database = new Database();
$db = $database->getConnection();

$registro = new RegistroTrocasHidrometros($db);

// Obter página e limite de registros
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$records_per_page = isset($_GET['limit']) ? $_GET['limit'] : 5;
$offset = ($page - 1) * $records_per_page;

$stmt = $registro->read($offset, $records_per_page);
$num = $stmt->rowCount();

// Contar o total de registros para calcular o número de páginas
$total_rows = $registro->count();
$total_pages = ceil($total_rows / $records_per_page);

if ($num > 0) {
    $registros_arr = array();
    $registros_arr["records"] = array();
    $registros_arr["total_pages"] = $total_pages;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $registro_item = array(
            "id" => $id,
            "usuario" => $usuario,
            "os" => $os,
            "codigo" => $codigo,
            "data" => $data,
            "testada" => $testada !== null ? base64_encode($testada) : null,
            "hretirado" => $hretirado !== null ? base64_encode($hretirado) : null,
            "hnovo" => $hnovo !== null ? base64_encode($hnovo) : null,
            "cavalete" => $cavalete !== null ? base64_encode($cavalete) : null,
            "solservico" => $solservico !== null ? base64_encode($solservico) : null
        );
        array_push($registros_arr["records"], $registro_item);

        unset($registro_item); // Libera memória
    }
    header('Content-Type: application/json');
    echo json_encode($registros_arr);
} else {
    echo json_encode(
        array("message" => "Nenhum registro encontrado.")
    );
}
?>
