<?php
include_once 'Database.php';
include_once 'RegistroTrocasHidrometros.php';

$database = new Database();
$db = $database->getConnection();

$registro = new RegistroTrocasHidrometros($db);

$registro->id = $_POST['id'];
$registro->os = $_POST['os'];
$registro->codigo = $_POST['codigo'];
$registro->testada = file_get_contents($_FILES['testada']['tmp_name']);
$registro->hretirado = file_get_contents($_FILES['hretirado']['tmp_name']);
$registro->hnovo = file_get_contents($_FILES['hnovo']['tmp_name']);
$registro->cavalete = file_get_contents($_FILES['cavalete']['tmp_name']);

if ($registro->update()) {
    echo "Registro atualizado com sucesso.";
} else {
    echo "Não foi possível atualizar o registro.";
}
?>
