<?php

use function PHPSTORM_META\type;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $queryIndex = $_POST["queryIndex"];
    if (isset($_POST["userInput"])) {
        $userInput = $_POST["userInput"];
    } else {
        $userInput = null;
    }
    if (isset($_POST["userSelection"])) {
        $userSelection = $_POST["userSelection"];
    } else {
        $userSelection = null;
    }
    
    switch ($queryIndex) {
        case 0:
            $query = "SELECT peliculas.titulo AS pelicula, proovedores.nombre AS proovedor FROM peliculas
            INNER JOIN proovedores_peliculas ON peliculas.id = proovedores_peliculas.id_pelicula
            INNER JOIN proovedores ON proovedores_peliculas.id_proovedor = proovedores.id
            WHERE proovedores_peliculas.precio IS NULL;";
            $tableHeaders = array("pelicula", "proovedor");
            break;
        case 1:
            $query = "SELECT series.titulo AS Serie FROM series
            INNER JOIN capitulos ON series.id = capitulos.id_serie
            GROUP BY series.id, series.titulo
            HAVING COUNT(DISTINCT capitulos.numero_temporada) >= :userInput;";
            $tableHeaders = array("Serie");
            break;
        case 2:
            $query = "SELECT * FROM pelicula JOIN proveedor ON pelicula.id_pelicula = proveedor.id_pelicula WHERE pelicula.titulo = $userInput";
            break;
        case 3:
            $query = "SELECT * FROM pelicula JOIN genero ON pelicula.id_genero = genero.id_genero WHERE genero.nombre = $userSelection OR genero.subgenero1 = $userSelection OR genero.subgenero2 = $userSelection";
            break;
        case 4:
            $query = "SELECT * FROM pelicula JOIN proveedor ON pelicula.id_pelicula = proveedor.id_pelicula JOIN usuario ON proveedor.id_proveedor = usuario.id_proveedor WHERE usuario.username = $userInput";
            break;
        case 5:
            $query = "SELECT * FROM serie JOIN usuario ON serie.id_serie = usuario.id_serie WHERE usuario.username = $userInput AND usuario.capitulos_vistos > 1 AND usuario.fecha_visto > DATE_SUB(NOW(), INTERVAL 1 YEAR)";
            break;
        case 6:
            $query = "SELECT usuario.username, SUM(pelicula.precio) FROM usuario JOIN proveedor ON usuario.id_proveedor = proveedor.id_proveedor JOIN pelicula ON proveedor.id_pelicula = pelicula.id_pelicula WHERE usuario.plan = 'free' GROUP BY usuario.username";
            break;
        default:
            echo "Invalid query index.";
            break;
    }

    try {
        require_once "dbh.inc.php";
        $stmt = $pdo->prepare($query);
        print_r($userInput);
        print_r($userSelection);
        print_r(!is_null($userInput));
        if (!is_null($userInput)) {
            $stmt->bindValue(':userInput', $userInput);
        }
        if (is_null($userSelection)) {
            $stmt->bindValue(':userSelection', $userSelection);
        }
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            echo "<table class='table'>
                <thead>
                    <tr>";
            foreach ($tableHeaders as $header) {
                echo "<th>$header</th>";
            }
            echo "</tr>
                </thead>
                <tbody>";
    
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                foreach ($tableHeaders as $header) {
                    echo "<td>" . $row[$header] . "</td>";
                }
                echo "</tr>";
            }
    
            echo "</tbody></table>";
        } else {
            echo "No data found.";
        }
        $pdo = null;
        $stmt = null;
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../index.php");
}
