<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $query = "SELECT peliculas.titulo AS pelicula, proveedores.nombre AS proveedor FROM peliculas
    INNER JOIN proveedores_peliculas ON peliculas.id = proveedores_peliculas.id_pelicula
    INNER JOIN proveedores ON proveedores_peliculas.id_proveedor = proveedores.id
    WHERE proveedores_peliculas.precio IS NULL;";
    $tableHeaders = array("pelicula", "proveedor");

    try {
        require_once "../config/dbh.inc.php";
        $stmt = $pdo->prepare($query);
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
