<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $query = "SELECT usuarios.nombre AS Usuario, SUM(arriendos_peliculas.monto) AS Total FROM arriendos_peliculas
    INNER JOIN usuarios ON arriendos_peliculas.id_usuario = usuarios.id
    GROUP BY usuarios.id, usuarios.nombre;";
    $tableHeaders = array("Usuario", "Total");

    try {
        require_once "../includes/dbh.inc.php";
        $stmt = $pdo->prepare($query);
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