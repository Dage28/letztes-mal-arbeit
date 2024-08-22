<?php
// sql code: SELECT `id`, `aufgabe`, `datum`, `wichtigkeit`, `status` FROM `liste` WHERE 1
// Datenbankverbindung einbinden
include "db_conn.php";

// SQL-Abfrage, um nur erledigte Aufgaben aus der Datenbank zu holen
$sql = "SELECT * FROM `liste` WHERE `status` = 1 ORDER BY 
            CASE 
                WHEN wichtigkeit = 'sehr wichtig' THEN 1 
                WHEN wichtigkeit = 'wichtig' THEN 2
                WHEN wichtigkeit = 'normal' THEN 3
                WHEN wichtigkeit = 'unwichtig' THEN 4
                ELSE 5
            END, aufgabe, datum ASC";

// Abfrage ausführen und Ergebnis speichern
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS einbinden -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Liste der erledigten Aufgaben</title>
</head>

<body>
    <div class="container mt-4">
        <!-- Überschrift der Seite -->
        <h2 class="text-center">Liste der erledigten Aufgaben</h2>
        
        <!-- Button zur Rückkehr zur Hauptseite -->
        <div class="text-end mb-3">
            <a href="index.php" class="btn btn-primary">Zurück zur To-Do Liste</a>
        </div>

        <!-- Tabelle zur Anzeige der erledigten Aufgaben -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Aufgabe</th>
                    <th>Datum</th>
                    <th>Wichtigkeit</th>
                    <th>Action</th> <!-- Action-Spalte für Buttons -->
                </tr>
            </thead>
            <tbody>
                <?php
                // Jede Zeile aus dem Ergebnis durchlaufen
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>"; // ID der Aufgabe
                    echo "<td>" . $row['aufgabe'] . "</td>"; // Name der Aufgabe
                    echo "<td>" . $row['datum'] . "</td>"; // Datum der Aufgabe
                    echo "<td>" . $row['wichtigkeit'] . "</td>"; // Wichtigkeit der Aufgabe

                    echo "<td>";
                    // Button zum Bearbeiten der Aufgabe
                    echo "<a href='edit.php?id=" . $row['id'] . "' class='btn btn-primary btn-sm'>Bearbeiten</a> ";
                    
                    // Button zum Löschen der Aufgabe mit Bestätigungsdialog
                    echo "<a href='delete.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Möchten Sie diesen Eintrag wirklich löschen?\");'>Löschen</a> ";
                    
                    // Button zum Zurücksetzen des Status auf "noch zu erledigen"
                    echo "<a href='index.php?status=0&id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Als unerledigt markieren</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS einbinden -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>