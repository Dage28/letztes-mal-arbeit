<?php
// sql code: INSERT INTO `liste`(`id`, `aufgabe`, `datum`, `wichtigkeit`, `status`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]')
include "db_conn.php"; // Stellt die Verbindung zur Datenbank her

if (isset($_POST["submit"])) { // Überprüft, ob das Formular abgesendet wurde
    $aufgabe = $_POST['aufgabe']; // Holt die Aufgabe aus dem Formular
    $datum = $_POST['tag'] . '-' . $_POST['monat'] . '-' . $_POST['jahr']; // Formatiert das Datum als "Tag-Monat-Jahr (tt-mm-jjjj)"
    $wichtigkeit = $_POST['wichtigkeit']; // Holt die Wichtigkeit aus dem Formular

    $sql = "INSERT INTO `liste`(`id`, `aufgabe`, `datum`, `wichtigkeit`) VALUES (NULL, '$aufgabe', '$datum', '$wichtigkeit')"; // SQL-Anweisung zum Einfügen der Daten

    $result = mysqli_query($conn, $sql); // Führt die SQL Anweisung aus

    if ($result) {
        header("Location: index.php?msg=Aufgabe erfolgreich hinzugefügt"); // Leitet bei Erfolg zur Startseite weiter
    } 
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Stellt sicher, dass die Seite im neuesten Modus des Browsers angezeigt wird -->
    <meta name="viewport" content="width=device-width, initial-scale=0.5"> 

    <!-- Bootstrap CSS einbinden -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>To-Do Liste</title> 
</head>
<body>
    <div class="container"> 
        <div class="text-center mb-4"> <!-- Zentriert den Text und fügt einen unteren Abstand hinzu -->
            <h3>Neue Aufgabe hinzufügen</h3>  <!-- Hauptitel -->
            <p class="text-muted">Aufgabe hinzufügen</p> <!-- Untertitel -->
            <p class="text-muted">Bitte alle Auswahlfelder ausfüllen!</p>
        </div>

        <div class="container d-flex justify-content-center"> <!-- Container zur Zentrierung des Formulars -->
            <form action="" method="post" style="width:50vw; min-width:300px;"> <!-- Formular zur Datenübermittlung -->
                <div class="row mb-3"> <!-- Zeile mit unterem Abstand -->
                    <div class="col"> <!-- Spalte für das Eingabefeld der Aufgabe -->
                        <label class="form-label">Aufgabe:</label > <!-- Beschriftung für das Eingabefeld -->
                        <input type="text" class="form-control" name="aufgabe" placeholder="hier Aufgabe einfügen" required> <!-- Eingabefeld für die Aufgabe -->
                    </div>

                    <div class="col"> <!-- Spalte für die Datumsauswahl -->
                        <label class="form-label">Datum auswählen :</label> <!-- Beschriftung für die Datumsauswahl -->
                        <div class="row"> <!-- Zeile für die Dropdowns -->
                            <div class="col"> <!-- Spalte für das Tag-Dropdown -->
                                <select class="form-select" name="tag" required> <!-- Dropdown für den Tag -->
                                    <option value="">Tag</option> <!-- Platzhalter-Option -->
                                    <?php for ($i = 1; $i <= 31; $i++): ?> <!-- Schleife zum Erstellen der Optionen für Tage -->
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option> <!-- Option für jeden Tag -->
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="col"> <!-- Spalte für das Monat-Dropdown -->
                                <select class="form-select" name="monat" required> <!-- Dropdown für den Monat -->
                                    <option value="">Monat</option > <!-- Platzhalter-Option -->
                                    <?php for ($i = 1; $i <= 12; $i++): ?> <!-- Schleife zum Erstellen der Optionen für Monate -->
                                        <option value="<?php echo $i; ?>"><?php echo $i;?></option> <!-- Option für jeden Monat -->
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="col"> <!-- Spalte für das Jahr-Dropdown -->
                                <select class="form-select" name="jahr" required> <!-- Dropdown für das Jahr -->
                                    <option value="">Jahr</option> <!-- Platzhalter-Option -->
                                    <?php for ($i = 2024; $i <= 2034; $i++): ?> <!-- Schleife zum Erstellen der Optionen für Jahre -->
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option> <!-- Option für jedes Jahr -->
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
<!-- mit required muss eine Auswahl erbracht werden -->
                <div class="form-group mb-3"> <!-- Gruppe für die Radio-Buttons zur Auswahl der Wichtigkeit -->
                    <label>Wichtigkeit:</label> <!-- Beschriftung für die Wichtigkeit -->
                    &nbsp; <!-- Leerraum -->
                    <input type="radio" class="form-check-input" name="wichtigkeit" id="sehr wichtig" value="sehr wichtig" required> <!-- Button für sehr wichtig -->
                    <label for="sehr wichtig" class="form-check-label">sehr wichtig</label> <!-- Beschriftung für sehr wichtig -->
                    &nbsp; 
                    <input type="radio" class="form-check-input" name="wichtigkeit" id="wichtig" value="wichtig" required> <!-- Button für wichtig -->
                    <label for="wichtig" class="form-check-label">wichtig</label> <!-- Beschriftung für wichtig -->
                    &nbsp; 
                    <input type="radio" class="form-check-input" name="wichtigkeit" id="normal" value="normal" required> <!-- Button für normal -->
                    <label for="normal" class="form-check-label">normal</label> <!-- Beschriftung für normal -->
                    &nbsp; 
                    <input type="radio" class="form-check-input" name="wichtigkeit" id="unwichtig" value="unwichtig" required> <!-- Button für unwichtig -->
                    <label for="unwichtig" class="form-check-label">unwichtig</label> <!-- Beschriftung für unwichtig -->
                </div>

                <div>
                    <button type="submit" class="btn btn-success" name="submit">Speichern</button> <!-- Button zum Absenden des Formulars -->
                    <a href="index.php" class="btn btn-danger">Abbrechen</a> <!-- Link zum Abbrechen und Zurückkehren zur Startseite -->
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JavaScript einbinden -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>