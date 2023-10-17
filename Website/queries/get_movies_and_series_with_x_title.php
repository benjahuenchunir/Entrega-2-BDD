<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $queryIndex = $_POST["queryIndex"];
    $userInput = $_POST["userInput"];
    $query = "SELECT * FROM (
        SELECT peliculas.titulo AS Titulo, proovedores.nombre AS Proovedor FROM peliculas
        INNER JOIN proovedores_peliculas ON peliculas.id = proovedores_peliculas.id_pelicula
        INNER JOIN proovedores ON proovedores_peliculas.id_proovedor = proovedores.id
        UNION
        SELECT series.titulo AS Titulo, proovedores.nombre AS Proovedor FROM series
        INNER JOIN proovedores_series ON series.id = proovedores_series.id_serie
        INNER JOIN proovedores ON proovedores_series.id_proovedor = proovedores.id
    ) AS U WHERE UPPER(Titulo) = UPPER(:userInput);";
    $tableHeaders = array("Titulo", "Proovedor");

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
