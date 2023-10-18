<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $query = "SELECT peliculas.titulo AS Pelicula, proovedores.nombre AS Proovedor FROM peliculas
    INNER JOIN proovedores_peliculas ON peliculas.id = proovedores_peliculas.id_pelicula
    INNER JOIN proovedores ON proovedores_peliculas.id_proovedor = proovedores.id
    WHERE proovedores_peliculas.precio IS NULL;";
    $tableHeaders = array("Pelicula", "Proovedor");

    try {
        require_once "../utils/dbh.inc.php";
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
