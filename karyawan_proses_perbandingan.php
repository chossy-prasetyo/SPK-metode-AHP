<?php
error_reporting(0);

$id_kriteria	= $_POST['id_kriteria'];
$kriteria 		= $_POST['kriteria'];

include 'koneksi.php';

// query id semua kriteria
$result = mysqli_query($kon,"SELECT id FROM kriteria");

$id_semua_kriteria = [];

while($row = mysqli_fetch_assoc($result)){
  $id_semua_kriteria[] = $row['id'];
}

// dapatkan index dari id kriteria sekarang
$index_id_kriteria_sekarang = array_keys($id_semua_kriteria,$id_kriteria);

// query karyawan dan hitung jumlahnya
$result = mysqli_query($kon,"SELECT * FROM karyawan");

$karyawan = [];

while($row = mysqli_fetch_assoc($result)){
	$karyawan[] = $row;
}

$n = count($karyawan);

// ambil nama panggilan semua karyawan
$panggilan = [];

foreach($karyawan as $k){
	$panggilan[] = explode(' ',$k['nama']);
}

// buat matriks nilai perbandingan karyawan yang diinputkan
$urut = 0;
$matriks = [];

for($x = 0; $x <= ($n - 2); $x++){
	for($y = ($x + 1); $y <= ($n - 1); $y++){

		$urut++;
		$perbandingan = "perbandingan".$urut;
		$nilai = "nilai".$urut;

		if($_POST[$perbandingan] == 1){
			$matriks[$x][$y] = $_POST[$nilai];
			$matriks[$y][$x] = 1 / $_POST[$nilai];
		} else{
			$matriks[$x][$y] = 1 / $_POST[$nilai];
			$matriks[$y][$x] = $_POST[$nilai];
		}

		$id_karyawan1 = $karyawan[$x]['id'];
		$id_karyawan2 = $karyawan[$y]['id'];

		// apakah nilai perbandingan dari dua karyawan yg diinputkan sudah ada di database ?
			// jika belum, maka input baris baru
			// jika sudah, maka update nilainya

		$query = "SELECT * FROM karyawan_perbandingan WHERE
								id_karyawan1 = $id_karyawan1 AND
								id_karyawan2 = $id_karyawan2 AND
								id_kriteria  = $id_kriteria";
		$result = mysqli_query($kon,$query);

		if(mysqli_num_rows($result) == 0){	
			$query = "INSERT INTO karyawan_perbandingan VALUES
									('','$id_karyawan1','$id_karyawan2','$id_kriteria','".$matriks[$x][$y]."')";
		} else{
			$query = "UPDATE karyawan_perbandingan SET
									nilai = '".$matriks[$x][$y]."' WHERE
									id_karyawan1 = $id_karyawan1 AND
									id_karyawan2 = $id_karyawan2 AND
									id_kriteria  = $id_kriteria";
		}

		mysqli_query($kon,$query);
	}
}

// isi diagonal matriks dg nilai 1
for($i = 0; $i <= ($n - 1); $i++){
	$matriks[$i][$i] = 1;
}

// jumlahkan nilai setiap kolom
$jumlah_kolom = [];

for($x = 0; $x <= ($n - 1); $x++){
	for($y = 0; $y <= ($n - 1); $y++){
		$jumlah_kolom[$x] += $matriks[$y][$x];
	}
}

// buat matriks eigen vektor dg menjumlahkan setiap nilai matriks dg jumlah kolomnya
$matriks_eigen_vektor = [];

for($x = 0; $x <= ($n - 1); $x++){
	for($y = 0; $y <= ($n - 1); $y++){
		$matriks_eigen_vektor[$y][$x] = $matriks[$y][$x] / $jumlah_kolom[$x];
	}
}

// jumlahkan nilai setiap kolom matriks eigen vektor
$jumlah_baris = [];

for($x = 0; $x <= ($n - 1); $x++){
	for($y = 0; $y <= ($n - 1); $y++){
		$jumlah_baris[$x] += $matriks_eigen_vektor[$x][$y];
	}
}

// hitung jumlah dari jumlah baris matriks eigen vektor
$jb = 0;

foreach($jumlah_baris as $a){
	$jb += $a;
}

// hitung nilai bobot karyawan
$bobot_karyawan = [];

for($x = 0; $x <= ($n - 1); $x++){
	$bobot_karyawan[$x] = $jumlah_baris[$x] / $jb;
}

// input nilai bobot karyawan ke database
for($x = 0; $x <= ($n - 1); $x++){

	$id_karyawan = $karyawan[$x]['id'];

	// apakah nilai bobot dari setiap karyawan yang dihitung sudah ada di database ?
		// jika belum, maka input baris baru
		// jika sudah, maka update nilainya

	$result = mysqli_query($kon,"SELECT * FROM karyawan_bobot WHERE id_karyawan = $id_karyawan AND id_kriteria = $id_kriteria");

	if(mysqli_num_rows($result) == 0){
		$query = "INSERT INTO karyawan_bobot VALUES
								('','$id_karyawan','$id_kriteria','".$bobot_karyawan[$x]."')";
	} else{
		$query = "UPDATE karyawan_bobot SET nilai = '".$bobot_karyawan[$x]."' WHERE
								id_karyawan = $id_karyawan
								id_kriteria = $id_kriteria";
	}

	mysqli_query($kon,$query);
}

// Cek Konsistensi Nilai Perbandingan

// hitung jumlah dari nilai bobot karyawan
$bk = 0;

foreach($bobot_karyawan as $a){
	$bk += $a;
}

// hitung lambda max
$lambda_max = ($jb + $bk) / $n;

// hitung index konsistensi
$ci = ($lambda_max - $n) / ($n - 1);

// ambil rasio index
$result = mysqli_query($kon,"SELECT nilai FROM index_rasio WHERE jumlah = $n");
$row = mysqli_fetch_assoc($result);
$ir = $row['nilai'];

// hitung nilai rasio konsitensi
$cr = $ci / $ir;

include 'karyawan_hasil.php';
?>