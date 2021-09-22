<?php 
include 'koneksi.php';

// tangkap semua input
$id 			= $_POST['id'];
$kriteria = htmlspecialchars($_POST['kriteria']);

// update kriteria
$query = "UPDATE kriteria SET kriteria = '$kriteria' WHERE id=$id";
mysqli_query($kon,$query);

header('Location: kriteria.php');
?>