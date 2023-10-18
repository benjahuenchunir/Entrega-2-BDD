<?php
$rowCount = $stmt->rowCount();
echo "Cantidad de resultados: $rowCount<br>";
 
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