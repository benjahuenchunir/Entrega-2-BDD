<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userInput = $_POST["userInput"];
    $query = "SELECT series.titulo AS serie, COUNT(DISTINCT capitulos.numero_temporada) AS cantidad_temporadas FROM series
    INNER JOIN capitulos ON series.id = capitulos.id_serie
    GROUP BY series.id, series.titulo
    HAVING COUNT(DISTINCT capitulos.numero_temporada) >= :userInput;";
    $tableHeaders = array("serie", "cantidad_temporadas");

    try {
        require_once "../config/dbh.inc.php";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':userInput', $userInput, PDO::PARAM_INT);
        $stmt->execute();
        require_once "../utils/table_builder.php";
        $pdo = null;
        $stmt = null;
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../index.php");
}
