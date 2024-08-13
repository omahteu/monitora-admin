<?php
include_once 'Database.php';
include_once 'RegistroTrocasHidrometros.php';

$database = new Database();
$db = $database->getConnection();

$registro = new RegistroTrocasHidrometros($db);

$registro->usuario = $_POST['usuario'];
$registro->os = $_POST['os'];
$registro->codigo = $_POST['codigo'];

$registro->testada = isset($_FILES['testada']) ? file_get_contents($_FILES['testada']['tmp_name']) : null;
$registro->hretirado = isset($_FILES['hretirado']) ? file_get_contents($_FILES['hretirado']['tmp_name']) : null;
$registro->hnovo = isset($_FILES['hnovo']) ? file_get_contents($_FILES['hnovo']['tmp_name']) : null;
$registro->cavalete = isset($_FILES['cavalete']) ? file_get_contents($_FILES['cavalete']['tmp_name']) : null;
$registro->solservico = isset($_FILES['solservico']) ? file_get_contents($_FILES['solservico']['tmp_name']) : null;

if ($registro->create()) {
    echo "Registro criado com sucesso.";
} else {
    echo "Não foi possível criar o registro.";
}
?>
