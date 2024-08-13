<?php
include_once 'Database.php';
include_once 'RegistroTrocasHidrometros.php';

$database = new Database();
$db = $database->getConnection();

$registro = new RegistroTrocasHidrometros($db);

$registro->id = $_POST['id'];

if ($registro->delete()) {
    echo "Registro excluído com sucesso.";
} else {
    echo "Não foi possível excluir o registro.";
}
?>
