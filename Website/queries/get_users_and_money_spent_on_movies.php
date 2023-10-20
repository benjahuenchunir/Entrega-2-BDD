<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $query = "SELECT usuarios.nombre AS usuario, SUM(arriendos_peliculas.monto) AS total FROM arriendos_peliculas
    INNER JOIN usuarios ON arriendos_peliculas.id_usuario = usuarios.id
    GROUP BY usuarios.id, usuarios.nombre;";
    $tableHeaders = array("usuario", "total");

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
