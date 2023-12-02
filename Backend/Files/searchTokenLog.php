<?php
include("../config/conexion.php");
$conn = conectar();

$dataPost = file_get_contents('php://input');
$body = json_decode($dataPost, true);
$state = $body['state'];

if ($state == 0) {
    $user = $body['user'];
    $dateInit = $body['dateInit'];
    $dateEnd = $body['dateEnd'];

    $queryver = "SELECT usedToken.id, users.user AS userName, usedToken.token, usedToken.useDate FROM usedToken JOIN users ON usedToken.ut_id_user = users.id WHERE usedToken.useDate BETWEEN :dateInit AND :dateEnd AND users.user LIKE '%:user%';";
    $stmt = $conn->prepare($queryver);
    $stmt->bindParam(":user", $user, PDO::PARAM_STR);
    $stmt->bindParam(":dateInit", $dateInit, PDO::PARAM_STR);
    $stmt->bindParam(":dateEnd", $dateEnd, PDO::PARAM_STR);
    $stmt->execute();
    $tokens = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($stmt) {
        echo json_encode(['STATUS' => 'SUCCESS', 'TOKENS' => $tokens]);
    } else {
        echo json_encode(['STATUS' => 'ERROR', 'MESSAGE' => 'Error al obtener usuarios']);
    }
} else if ($state == 1) {
    $user = $body['user'];

    $queryver = "SELECT usedToken.id, users.user AS userName, usedToken.token, usedToken.useDate FROM usedToken JOIN users ON usedToken.ut_id_user = users.id WHERE users.user LIKE '%:user%';";
    $stmt = $conn->prepare($queryver);
    $stmt->bindParam(":user", $user, PDO::PARAM_STR);
    $stmt->execute();
    $tokens = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($stmt) {
        echo json_encode(['STATUS' => 'SUCCESS', 'TOKENS' => $tokens]);
    } else {
        echo json_encode(['STATUS' => 'ERROR', 'MESSAGE' => 'Error al obtener usuarios']);
    }
} else if ($state == 2) {
    $dateInit = $body['dateInit'];
    $dateEnd = $body['dateEnd'];

    $queryver = "SELECT usedToken.id, users.user AS userName, usedToken.token, usedToken.useDate FROM usedToken JOIN users ON usedToken.ut_id_user = users.id WHERE usedToken.useDate BETWEEN :dateInit AND :dateEnd";
    $stmt = $conn->prepare($queryver);
    $stmt->bindParam(":user", $user, PDO::PARAM_STR);
    $stmt->bindParam(":dateInit", $dateInit, PDO::PARAM_STR);
    $stmt->bindParam(":dateEnd", $dateEnd, PDO::PARAM_STR);
    $stmt->execute();
    $tokens = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($stmt) {
        echo json_encode(['STATUS' => 'SUCCESS', 'TOKENS' => $tokens]);
    } else {
        echo json_encode(['STATUS' => 'ERROR', 'MESSAGE' => 'Error al obtener usuarios']);
    }
}
?>