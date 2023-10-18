<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userInput = $_POST["userInput"];
    $query = "SELECT series.titulo AS Serie FROM series
    INNER JOIN capitulos ON series.id = capitulos.id_serie
    GROUP BY series.id, series.titulo
    HAVING COUNT(DISTINCT capitulos.numero_temporada) >= :userInput;";
    $tableHeaders = array("Serie");

    try {
        require_once "../includes/dbh.inc.php";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':userInput', $userInput, PDO::PARAM_INT);
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
