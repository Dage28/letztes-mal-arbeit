<?php
// sql code: UPDATE `liste` SET `id`='[value-1]',`aufgabe`='[value-2]',`datum`='[value-3]',`wichtigkeit`='[value-4]',`status`='[value-5]' WHERE 1
include "db_conn.php";

// ID der zu bearbeitenden Aufgabe aus der URL holen
$id = $_GET["id"];

// Prüfen, ob das Formular abgeschickt wurde
if (isset($_POST["submit"])) {
    // POST-Daten holen
    $aufgabe = $_POST['aufgabe'];
    $tag = $_POST['tag'];
    $monat = $_POST['monat'];
    $jahr = $_POST['jahr'];
    $wichtigkeit = $_POST['wichtigkeit'];

    // Datum als einen String zusammenfügen
    $datum = "$tag-$monat-$jahr";

    // SQL-Statement zum Aktualisieren der Aufgabe
    $sql = "UPDATE `liste` SET `aufgabe`='$aufgabe', `datum`='$datum', `wichtigkeit`='$wichtigkeit' WHERE id = $id";

    // SQL-Query ausführen
    $result = mysqli_query($conn, $sql);

    // Erfolgs- oder Fehlermeldung ausgeben
    if ($result) {
        header("Location: index.php?msg=Aufgabe erfolgreich bearbeitet");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap CSS einbinden -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    
    <!-- Font Awesome einbinden -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer">
    
    <title>Aufgabe bearbeiten</title>
</head>
<body>
    </nav>

    <div class="container">
        <div class="text-center mb-4">
            <h3>Aufgaben bearbeiten</h3>
            <p class="text-muted">Den Button drücken nach dem Bearbeiten</p>
        </div>

        <?php
        // SQL-Query zum Abrufen der aktuellen Daten der Aufgabe
        $sql = "SELECT * FROM `liste` WHERE id = $id LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);


        ?>

        <!-- Formular zur Bearbeitung der Aufgabe -->
        <div class="container d-flex justify-content-center">
            <form action="" method="post" style="width:50vw; min-width:300px;">
                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label">Aufgabe:</label>
                        <!-- (htmlspecialchars um dem inhalt der reihe nicht zu verlieren) -->
                        <input type="text" class="form-control" name="aufgabe" value="<?php echo htmlspecialchars($row['aufgabe']); ?>" required>
                    </div>

                    <div class="col">
                        <label class="form-label">Datum:</label>
                        <div class="d-flex">
                            <select name="tag" class="form-select" required>
                                <?php
                                for ($i = 1; $i <= 31; $i++) {
                                    $selected = ($i == $tag) ? "selected" : "";
                                    echo "<option value='$i' $selected>$i</option>";
                                }
                                ?>
                            </select>

                            <select name="monat" class="form-select mx-2" required>
                                <?php
                                for ($i = 1; $i <= 12; $i++) {
                                    $selected = ($i == $monat) ? "selected" : "";
                                    echo "<option value='$i' $selected>$i</option>";
                                }
                                ?>
                            </select>

                            <select name="jahr" class="form-select" required>
                                <?php
                                for ($i = 2024; $i <= 2034; $i++) {
                                    $selected = ($i == $jahr) ? "selected" : "";
                                    echo "<option value='$i' $selected>$i</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Wichtigkeit:</label>
                    <!-- Buttons zur Auswahl der Wichtigkeit -->

                        <input type="radio" class="form-check-input" name="wichtigkeit" id="sehr wichtig" value="sehr wichtig" <?php echo ($row["wichtigkeit"] == 'sehr wichtig') ? "checked" : ""; ?>>
                        <label for="sehr wichtig" class="form-check-label">Sehr wichtig</label>
                   

                        <input type="radio" class="form-check-input" name="wichtigkeit" id="wichtig" value="wichtig" <?php echo ($row["wichtigkeit"] == 'wichtig') ? "checked" : ""; ?>>
                        <label for="wichtig" class="form-check-label">Wichtig</label>

                        <input type="radio" class="form-check-input" name="wichtigkeit" id="normal" value="normal" <?php echo ($row["wichtigkeit"] == 'normal') ? "checked" : ""; ?>>
                        <label for="normal" class="form-check-label">Normal</label>

                    
                        <input type="radio" class="form-check-input" name="wichtigkeit" id="unwichtig" value="unwichtig" <?php echo ($row["wichtigkeit"] == 'unwichtig') ? "checked" : ""; ?>>
                        <label for="unwichtig" class="form-check-label">Unwichtig</label>
                        </div>

                <!-- Update-Button und Cancel-Button -->
                    <button type="submit" class="btn btn-success" name="submit">Update</button>
                    <a href="index.php" class="btn btn-danger">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JavaScript einbinden -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>