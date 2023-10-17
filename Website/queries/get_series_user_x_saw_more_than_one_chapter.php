<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $queryIndex = $_POST["queryIndex"];
    $userInput = $_POST["userInput"];
    $query = "SELECT series.titulo AS Titulo FROM historial_series
    INNER JOIN capitulos ON historial_series.id_capitulo = capitulos.id
    INNER JOIN series ON series.id = capitulos.id_serie
    INNER JOIN usuarios ON historial_series.id_usuario = usuarios.id
    WHERE UPPER(usuarios.nombre) = UPPER(:userInput)
    AND historial_series.fecha >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)
    GROUP BY series.id, series.titulo
    HAVING COUNT(*) > 1;";
    $tableHeaders = array("Titulo");

    try {
        require_once "../includes/dbh.inc.php";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':userInput', $userInput, PDO::PARAM_STR);
        $stmt->execute();
        require_once "../includes/table_builder.php";
        $pdo = null;
        $stmt = null;
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../index.php");
}
