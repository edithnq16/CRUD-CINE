<?php
session_start();

require 'confing/database.php';

$id = $conn->real_escape_string($_POST['id']);
$sql = "DELETE FROM pelicula WHERE id=$id";
if($conn->query($sql)){

    $dir = "posters";
    $poster = $dir . '/' . $id . '.jpg';

    if(file_exists($poster)){
        unlink($poster);
    }
    $_SESSION['color'] ="success";
    $_SESSION['msg'] ="registro eliminado";
} else {
    $_SESSION['color'] ="danger";
    $_SESSION['msg'] ="error al eliminar registro";

}
header('location: index.php');