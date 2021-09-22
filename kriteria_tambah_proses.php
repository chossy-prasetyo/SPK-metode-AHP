<?php 
include 'koneksi.php';

// tangkap input
$kriteria = htmlspecialchars($_POST['kriteria']);

// tambahkan data kriteria
$query = "INSERT INTO kriteria VALUES ('','$kriteria')";
mysqli_query($kon,$query);

header('Location: kriteria.php');
?>