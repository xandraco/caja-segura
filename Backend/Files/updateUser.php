<?php
include("../config/conexion.php");
$conn = conectar();
$dataPost = file_get_contents('php://input');
$body = json_decode($dataPost, true);

$idUsuario = $body['idUsuario'];
$user = $body['user'];
$password = $body['password'];
$admin = $body['admin'];

if ($user && $password) {
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    // Buscamos el usuario dentro de la base de datos
    $queryuser = "UPDATE users SET user = :user, password = :password, admin = :admin WHERE id = :idUsuario";
    $stmt = $conn->prepare($queryuser);
    $stmt->bindParam(":user", $user, PDO::PARAM_STR);
    $stmt->bindParam(":password", $passwordHash, PDO::PARAM_STR);
    $stmt->bindParam(":admin", $admin, PDO::PARAM_STR);
    $stmt->bindParam(":idUsuario", $idUsuario, PDO::PARAM_STR);
    $validQuery = $stmt->execute();

    if ($validQuery) {
        echo json_encode(['STATUS' => 'SUCCESS', 'MESSAGE' => '1']);
    } else {
        echo json_encode(['STATUS' => 'ERROR', 'MESSAGE' => 'NO SUCCESS']);
    }
} else if($user) {
    // Buscamos el usuario dentro de la base de datos
    $queryuser = "UPDATE users SET user = :user, admin = :admin WHERE id = :idUsuario";
    $stmt = $conn->prepare($queryuser);
    $stmt->bindParam(":user", $user, PDO::PARAM_STR);
    $stmt->bindParam(":admin", $admin, PDO::PARAM_STR);
    $stmt->bindParam(":idUsuario", $idUsuario, PDO::PARAM_STR);
    $validQuery = $stmt->execute();

    if ($validQuery) {
        echo json_encode(['STATUS' => 'SUCCESS', 'MESSAGE' => '2']);
    } else {
        echo json_encode(['STATUS' => 'ERROR', 'MESSAGE' => 'NO SUCCESS']);
    }
} else if($password) {
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    // Buscamos el usuario dentro de la base de datos
    $queryuser = "UPDATE users SET password = :password, admin = :admin WHERE id = :idUsuario";
    $stmt = $conn->prepare($queryuser);
    $stmt->bindParam(":password", $passwordHash, PDO::PARAM_STR);
    $stmt->bindParam(":admin", $admin, PDO::PARAM_STR);
    $stmt->bindParam(":idUsuario", $idUsuario, PDO::PARAM_STR);
    $validQuery = $stmt->execute();

    if ($validQuery) {
        echo json_encode(['STATUS' => 'SUCCESS', 'MESSAGE' => '2']);
    } else {
        echo json_encode(['STATUS' => 'ERROR', 'MESSAGE' => 'NO SUCCESS']);
    }
}else if($admin == 0 || $admin == 1) {
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    // Buscamos el usuario dentro de la base de datos
    $queryuser = "UPDATE users SET admin = :admin WHERE id = :idUsuario";
    $stmt = $conn->prepare($queryuser);
    $stmt->bindParam(":admin", $admin, PDO::PARAM_STR);
    $stmt->bindParam(":idUsuario", $idUsuario, PDO::PARAM_STR);
    $validQuery = $stmt->execute();

    if ($validQuery) {
        echo json_encode(['STATUS' => 'SUCCESS', 'MESSAGE' => '3']);
    } else {
        echo json_encode(['STATUS' => 'ERROR', 'MESSAGE' => 'NO SUCCESS']);
    }
} else {
    http_response_code(400);
    echo 'Invalid Data';
}
?>