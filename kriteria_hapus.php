<?php
include 'koneksi.php';

$id = $_GET['id'];

// query terlebih dahulu jumlah kriteria
$result = mysqli_query($kon,"SELECT * FROM kriteria");

// hapus dari kriteria_perbandingan
// hapus dari karyawan_perbandingan
// hapus dari karyawan_bobot
		// jika sudah 3 atau lebih kecil, hapus semua saja

if(mysqli_num_rows($result) <= 3){
	$query1 = "DELETE FROM kriteria_perbandingan";
	$query2 = "DELETE FROM karyawan_perbandingan";
	$query3 = "DELETE FROM karyawan_bobot";
} else{
	$query1 = "DELETE FROM kriteria_perbandingan WHERE
							id_kriteria1 = $id OR
							id_kriteria2 = $id";
	$query2 = "DELETE FROM karyawan_perbandingan WHERE
							id_kriteria = $id";
	$query3 = "DELETE FROM karyawan_bobot WHERE
							id_kriteria = $id";
}

mysqli_query($kon,$query1);
mysqli_query($kon,$query2);
mysqli_query($kon,$query3);

// hapus semua kriteria_bobot
mysqli_query($kon,"DELETE FROM kriteria_bobot");

// hapus semua karyawan_ranking
mysqli_query($kon,"DELETE FROM karyawan_ranking");

// hapus dari kriteria
mysqli_query($kon,"DELETE FROM kriteria WHERE id = $id");

header('Location: kriteria.php');
?>