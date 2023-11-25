<?php
include("../config/conexion.php");
$conn = conectar();
$id = $_GET['id'];
$querydelete = "DELETE FROM users WHERE id= :id";
$stmt = $conn->prepare($querydelete);
$stmt->bindParam(":id", $id, PDO::PARAM_INT);
$res = $stmt->execute();
if($res) {
    echo json_encode(['STATUS' => 'SUCCESS', 'MESSAGE' => $res]);
    Header("Location: ../../adminUser.php");
} else {
    echo json_encode(['STATUS' => 'ERROR', 'MESSAGE' => $res]);
    Header("Location: ../../adminUser.php");
}
?>