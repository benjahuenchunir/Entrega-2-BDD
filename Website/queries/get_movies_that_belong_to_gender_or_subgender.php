<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userSelection = $_POST["userSelection"];
    $query = "SELECT DISTINCT peliculas.titulo AS titulo, generos.nombre AS genero FROM peliculas
    INNER JOIN generos_peliculas ON peliculas.id = generos_peliculas.id_pelicula
    INNER JOIN generos ON generos_peliculas.id_genero = generos.id
    WHERE generos_peliculas.id_genero = :selectedGenre
    OR generos_peliculas.id_genero IN (
        SELECT id_subgenero FROM genero_subgeneros WHERE id_genero = :selectedGenre
    );";
    $tableHeaders = array("titulo", "genero");

    try {
        require_once "../config/dbh.inc.php";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':selectedGenre', $userSelection, PDO::PARAM_STR);
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
