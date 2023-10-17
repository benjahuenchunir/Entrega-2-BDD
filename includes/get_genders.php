<?php

try {
    require_once "dbh.inc.php";
    $query = "SELECT * FROM generos;";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    $response = array();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $response[] = array(
            "id" => $row['id'],
            "nombre" => $row['nombre']
        );
    }

    echo json_encode($response);
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}

?>