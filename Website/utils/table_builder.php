<?php
$rowCount = $stmt->rowCount();
echo "Cantidad de resultados: $rowCount<br>";
 
if ($stmt->rowCount() > 0) {
            echo "<table class='table' id='result-table'>
                <thead>
                    <tr>";
            foreach ($tableHeaders as $header) {
                echo "<th>".ucfirst($header)." <button class='btn btn-secondary btn-sm' id=$header onclick='onSortButtonClicked(this.id)'>▲</button></th>";
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