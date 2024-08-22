<?php
// Datenbankverbindung einbinden
include "db_conn.php";

// Prüfen, ob eine Anfrage zur Statusänderung gemacht wurde
if (isset($_GET['status']) & isset($_GET['id'])) {
    // Status und ID aus der URL holen
    $status = $_GET['status'];
    $id = $_GET['id'];

    // SQL-Abfrage zum Ändern des Status
    $sql = "UPDATE `liste` SET `status` = $status WHERE `id` = $id";
    // Abfrage in der Datenbank ausführen
    mysqli_query($conn, $sql);
    // Nach der Statusänderung zurück zur Hauptseite
    header("Location: index.php");
    exit();
}

// SQL-Abfrage, um alle Aufgaben aus der Datenbank zu holen
// Sortierung nach Wichtigkeit, Datum und Alphabetischer Reihenfolge der Aufgaben absteigend
$sql = "SELECT * FROM `liste` ORDER BY 
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
    <title>To-Do Liste</title>
</head>

<body>
    <div class="container mt-4">
        <!-- Überschrift -->
        <h2 class="text-center">To-Do Liste</h2>
        
        <!-- Button zum Erstellen eines neuen Eintrags -->
        <div class="text-end mb-3">
            <a href="add-new.php" class="btn btn-success">Neue Aufgabe erstellen</a>
        </div>
        <div class="text-end mb-3">
            <a href="overview.php" class="btn btn-success">Liste der erledigten Aufgaben</a>
        </div>

        <!-- Tabelle zur Anzeige der Aufgaben -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Aufgabe</th>
                    <th>Datum</th>
                    <th>Wichtigkeit</th>
                    <th>Status</th> <!-- Status-Spalte hinzufügen -->
                    <th>Action</th> <!-- Action-Spalte für Buttons -->
                </tr>
            </thead>
            <tbody>
                <?php
                // Jede Zeile aus dem Ergebnis durchlaufen
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>"; // ID der Aufgabe
                    echo "<td>" . $row['aufgabe'] . "</td>"; // Aufgabenbeschreibung
                    echo "<td>" . $row['datum'] . "</td>"; // Datum der Aufgabe
                    echo "<td>" . $row['wichtigkeit'] . "</td>"; // Wichtigkeit der Aufgabe
                    echo "<td>" . ($row['status'] ? 'Erledigt' : 'Noch zu erledigen') . "</td>"; // Status der Aufgabe

                    echo "<td>";
                    // Button zum Bearbeiten der Aufgabe
                    echo "<a href='edit.php?id=" . $row['id'] . "' class='btn btn-primary btn-sm'>Bearbeiten</a> ";
                    
                    // Button zum Löschen der Aufgabe mit Bestätigungsdialog
                    echo "<a href='delete.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Möchten Sie diesen Eintrag wirklich löschen?\");'>Löschen</a> ";

                    // Button zum Ändern des Status (erledigt oder unerledigt)
                    if ($row['status']) {
                        // Wenn erledigt, Button zum Zurücksetzen
                        echo "<a href='index.php?status=0&id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Als unerledigt markieren</a>";
                    } else {
                        // Wenn noch zu erledigen, Button zum Erledigen
                        echo "<a href='index.php?status=1&id=" . $row['id'] . "' class='btn btn-success btn-sm'>Als erledigt markieren</a>";
                    }
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