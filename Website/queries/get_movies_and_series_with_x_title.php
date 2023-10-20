<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userInput = $_POST["userInput"];
    $query = "SELECT * FROM (
        SELECT peliculas.titulo AS titulo, proveedores.nombre AS proveedor FROM peliculas
        INNER JOIN proveedores_peliculas ON peliculas.id = proveedores_peliculas.id_pelicula
        INNER JOIN proveedores ON proveedores_peliculas.id_proveedor = proveedores.id
        UNION
        SELECT series.titulo AS titulo, proveedores.nombre AS proveedor FROM series
        INNER JOIN proveedores_series ON series.id = proveedores_series.id_serie
        INNER JOIN proveedores ON proveedores_series.id_proveedor = proveedores.id
    ) AS U WHERE UPPER(titulo) = UPPER(:userInput);";
    $tableHeaders = array("titulo", "proveedor");

    try {
        require_once "../config/dbh.inc.php";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':userInput', $userInput, PDO::PARAM_STR);
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
