<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userInput = $_POST["userInput"];
    $query = "SELECT DISTINCT peliculas.titulo AS pelicula FROM peliculas
    INNER JOIN proveedores_peliculas ON peliculas.id = proveedores_peliculas.id_pelicula
    INNER JOIN subscripciones ON proveedores_peliculas.id_proveedor = subscripciones.id_proveedor
    INNER JOIN usuarios ON subscripciones.id_usuario = usuarios.id
    LEFT JOIN arriendos_peliculas ON peliculas.id = arriendos_peliculas.id_pelicula AND arriendos_peliculas.id_usuario = usuarios.id
    WHERE UPPER(usuarios.nombre) = UPPER(:userInput)
    AND (
        (precio IS NULL AND subscripciones.fecha_termino IS NULL)
        OR
        (precio IS NOT NULL AND arriendos_peliculas.id IS NOT NULL AND DATE_ADD(arriendos_peliculas.fecha, INTERVAL arriendos_peliculas.dias_arriendo DAY) >= CURDATE())
    );";
    $tableHeaders = array("pelicula");

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
