<?php
include 'koneksi.php';

$id = $_GET['id'];

// query terlebih dahulu jumlah karyawan
$result = mysqli_query($kon,"SELECT * FROM karyawan");

// hapus dari karyawan_perbandingan
		// jika sudah 3 atau lebih kecil, hapus semua saja

if(mysqli_num_rows($result) <= 3){
	$query = "DELETE FROM karyawan_perbandingan";
} else{
	$query = "DELETE FROM karyawan_perbandingan WHERE
							id_karyawan1 = $id OR
							id_karyawan2 = $id";
}

mysqli_query($kon,$query);

// hapus semua karyawan_bobot
mysqli_query($kon,"DELETE FROM karyawan_bobot");

// hapus semua karyawan_ranking
mysqli_query($kon,"DELETE FROM karyawan_ranking");

// hapus karyawan
mysqli_query($kon,"DELETE FROM karyawan WHERE id=$id");

header('Location: karyawan.php');
?>