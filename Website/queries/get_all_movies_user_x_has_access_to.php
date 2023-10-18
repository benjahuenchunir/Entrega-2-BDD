<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userInput = $_POST["userInput"];
    $query = "SELECT DISTINCT peliculas.titulo AS Pelicula FROM peliculas
    INNER JOIN proovedores_peliculas ON peliculas.id = proovedores_peliculas.id_pelicula
    INNER JOIN subscripciones ON proovedores_peliculas.id_proovedor = subscripciones.id_proovedor
    INNER JOIN usuarios ON subscripciones.id_usuario = usuarios.id
    LEFT JOIN arriendos_peliculas ON peliculas.id = arriendos_peliculas.id_pelicula AND arriendos_peliculas.id_proovedor = proovedores_peliculas.id_proovedor AND arriendos_peliculas.id_usuario = usuarios.id
    WHERE UPPER(usuarios.nombre) = UPPER(:userInput)
    AND (
        (precio IS NULL AND subscripciones.fecha_termino IS NULL)
        OR
        (precio IS NOT NULL AND arriendos_peliculas.id IS NOT NULL AND DATE_ADD(arriendos_peliculas.fecha, INTERVAL proovedores_peliculas.disponibilidad DAY) >= CURDATE())
    );";
    $tableHeaders = array("Pelicula");

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