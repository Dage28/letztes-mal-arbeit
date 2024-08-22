<?php
//"DELETE FROM liste WHERE `liste`.`id` sql code"
include "db_conn.php";
$id = $_GET["id"];
$sql = "DELETE FROM `liste` WHERE id = $id";
$result = mysqli_query($conn, $sql);

if ($result) {
  header("Location: index.php?msg=Aufgabe erfolgreich gelöscht");
} else {
  echo "Failed: " . mysqli_error($conn);
}
?>