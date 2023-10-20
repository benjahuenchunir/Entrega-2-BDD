<?php
$rowCount = $stmt->rowCount();
echo "Cantidad de resultados: $rowCount<br>";

if ($stmt->rowCount() > 0) {
    echo "<div style='height: 500px; overflow-y: scroll;'>";
    echo "<table class='table table-bordered table-hover' id='result-table'>
                <thead class='thead-light sticky-top' style='position: sticky; top: -1px; background-color: #fff;'>
                    <tr>";
    foreach ($tableHeaders as $header) {
        echo "<th>" . ucfirst($header) . " <button class='btn btn-secondary btn-sm' id=$header onclick='onSortButtonClicked(this.id)'>▲</button></th>";
    }
    echo "</tr>
                </thead>
                <tbody>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        foreach ($tableHeaders as $header) {
            echo "<td class='$header'>" . $row[$header] . "</td>";
        }
        echo "</tr>";
    }

    echo "</tbody></table>";
} else {
    echo "No se encontraro resultados";
}
echo "</div>";
