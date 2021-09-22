<?php
include 'koneksi.php';

// tangkap semua input
$id									= $_POST['id'];
$nama								= htmlspecialchars($_POST['nama']);
$gender							= htmlspecialchars($_POST['gender']);
$jabatan						= htmlspecialchars($_POST['jabatan']);
$status							= htmlspecialchars($_POST['status']);
$tanggal_bergabung	= htmlspecialchars($_POST['tanggal_bergabung']);

// update data karyawan
$query = "UPDATE karyawan SET
						nama 							= '$nama',
						gender 						= '$gender',
						jabatan						= '$jabatan',
						status						= '$status',
						tanggal_bergabung	= '$tanggal_bergabung'
					WHERE id=$id";
mysqli_query($kon,$query);

header('Location: karyawan.php');
?>