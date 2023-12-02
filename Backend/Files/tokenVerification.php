<?php
include("../config/conexion.php");
$conn = conectar();
$dataPost = file_get_contents('php://input');
$body = json_decode($dataPost, true);

if ($body !== null && isset($body['token'])) {
    $userToken = $body['token'];

    // Buscar todos los tokens almacenados en la base de datos
    $queryTokens = "SELECT * FROM tokenActual";
    $stmt = $conn->prepare($queryTokens);
    $stmt->execute();
    $allTokens = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $tokenMatched = false;

    if ($allTokens !== false) {
        // Iterar sobre todos los tokens y verificar si alguno coincide con el token proporcionado por el usuario
        foreach ($allTokens as $storedToken) {
            if (password_verify($userToken, $storedToken['token'])) {
                $tokenMatched = true;
                $userId = $storedToken['ta_id_user'];
                $currentDate = date('Y-m-d'); // Obtener la fecha actual
                // Insertar a la bitacora
                $insertQuery = "INSERT INTO usedToken VALUES (null, :userId, :userToken, :currentDate)";
                $insertStmt = $conn->prepare($insertQuery);
                $insertStmt->bindParam(":userId", $userId, PDO::PARAM_INT);
                $insertStmt->bindParam(":userToken", $userToken, PDO::PARAM_STR);
                $insertStmt->bindParam(":currentDate", $currentDate, PDO::PARAM_STR);
                $insertStmt->execute();
            }
        }
    }

    // Comprobar si se encontró una coincidencia o no
    if ($tokenMatched) {
        echo json_encode(['STATUS' => 'SUCCESS', 'MESSAGE' => 'Token válido']);
    } else {
        echo json_encode(['STATUS' => 'ERROR', 'MESSAGE' => 'Token inválido']);
    }
} else {
    http_response_code(400);
    echo json_encode(['STATUS' => 'ERROR', 'MESSAGE' => 'Datos inválidos']);
}
?>