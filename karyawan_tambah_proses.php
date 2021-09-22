<?php 
include 'koneksi.php';

// tangkap semua input
$nama 							= htmlspecialchars($_POST['nama']);
$gender							= htmlspecialchars($_POST['gender']);
$jabatan						= htmlspecialchars($_POST['jabatan']);
$status							= htmlspecialchars($_POST['status']);
$tanggal_bergabung	= htmlspecialchars($_POST['tanggal_bergabung']);

// tambahkan data karyawan
$query = "INSERT INTO karyawan VALUES
					('','$nama','$gender','$jabatan','$status','$tanggal_bergabung')";
mysqli_query($kon,$query);

header('Location: karyawan.php');
?>