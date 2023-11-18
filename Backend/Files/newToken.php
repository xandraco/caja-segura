<?php
session_start();

include("../config/conexion.php");
$conn = conectar();
$dataPost = file_get_contents('php://input');
$body = json_decode($dataPost, true);

$token = $body['token'];
$idUsuario = $body['idUsuario'];  
$tokenhash = password_hash($token, PASSWORD_BCRYPT);

$queryCheckExisting = "SELECT * FROM tokenActual WHERE ta_id_user = :idUsuario";
$stmt = $conn->prepare($queryCheckExisting);
$stmt->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);
$stmt->execute();
$validTokens = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($validTokens) > 0) {
    // Si existe un registro para este usuario, elimínalo
    $queryDeleteExisting = "DELETE FROM tokenActual WHERE ta_id_user = :idUsuario";
    $stmtDelete = $conn->prepare($queryDeleteExisting);
    $stmtDelete->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);
    $stmtDelete->execute();

    if (!$stmtDelete) {
        echo json_encode(['STATUS' => 'ERROR', 'MESSAGE' => 'Error al eliminar el token existente']);
        exit();
    }
}

$queryInsertToken = "INSERT INTO tokenActual (id, token, ta_id_user) VALUES (:idUsuario, :tokenhash, :idUsuario)";
$stmtInsert = $conn->prepare($queryInsertToken);
$stmtInsert->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);
$stmtInsert->bindParam(":tokenhash", $tokenhash, PDO::PARAM_STR);
$stmtInsert->execute();

if ($stmtInsert) {
    echo json_encode(['STATUS' => 'SUCCESS', 'MESSAGE' => 'Token almacenado en la base de datos']);
} else {
    echo json_encode(['STATUS' => 'ERROR', 'MESSAGE' => 'Error al almacenar el token']);
}
?>
