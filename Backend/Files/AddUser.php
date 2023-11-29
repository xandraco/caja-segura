<?php
include("../config/conexion.php");
$conn = conectar();

$dataPost = file_get_contents('php://input');
$body = json_decode($dataPost, true);

$user = $body['user'];
$email = $body['email'];
$password = $body['password'];
$admin = $body['admin'];

// Verificar que el usuario exista
$queryver = "SELECT * FROM users WHERE email = :email";
$stmt = $conn->prepare($queryver);
$stmt->bindParam(":email", $email, PDO::PARAM_STR);
$stmt->execute();
$validemail = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($validemail) == 0) {
    // Usuario no existe
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    $queryInsert = "INSERT INTO users VALUES(null, :user, :email, :passwordHash, :admin)";
    $stmt = $conn->prepare($queryInsert);
    $stmt->bindParam(":user", $user, PDO::PARAM_STR);
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->bindParam(":passwordHash", $passwordHash, PDO::PARAM_STR);
    $stmt->bindParam(":admin", $admin, PDO::PARAM_INT);

    $result = $stmt->execute();
    if ($result) {
        echo json_encode(['STATUS' => 'SUCCESS', 'MESSAGE' => '1']);
    } else {
        echo json_encode(['STATUS' => 'ERROR', 'MESSAGE' => $result]);

    }
} else {
    // Usuario existe
    echo json_encode(['STATUS' => 'ERROR', 'MESSAGE' => 'Email ya existe']);
}
?>