<?php
error_reporting(0);

// query kriteria dan hitung jumlahnya
include 'koneksi.php';
$result = mysqli_query($kon,"SELECT * FROM kriteria");

$kriteria = [];

while($row = mysqli_fetch_assoc($result)){
	$kriteria[] = $row;
}

$n = count($kriteria);

// buat matriks nilai perbandingan kriteria yang diinputkan
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

		$id_kriteria1 = $kriteria[$x]['id'];
		$id_kriteria2 = $kriteria[$y]['id'];

		// apakah nilai perbandingan dari dua kriteria yg diinputkan sudah ada di database ?
			// jika belum, maka input baris baru
			// jika sudah, maka update nilainya

		$query = "SELECT * FROM kriteria_perbandingan WHERE
								id_kriteria1 = $id_kriteria1 AND
								id_kriteria2 = $id_kriteria2";
		$result = mysqli_query($kon,$query);

		if(mysqli_num_rows($result) == 0){	
			$query = "INSERT INTO kriteria_perbandingan VALUES
									('','$id_kriteria1','$id_kriteria2','".$matriks[$x][$y]."')";
		} else{
			$query = "UPDATE kriteria_perbandingan SET
									nilai = '".$matriks[$x][$y]."' WHERE
									id_kriteria1 = $id_kriteria1 AND
									id_kriteria2 = $id_kriteria2";
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

// jumlahkan nilai setiap matriks matriks eigen vektor
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

// hitung nilai bobot kriteria
$bobot_kriteria = [];

for($x = 0; $x <= ($n - 1); $x++){
	$bobot_kriteria[$x] = $jumlah_baris[$x] / $jb;
}

// input nilai bobot kriteria ke database
for($x = 0; $x <= ($n - 1); $x++){

	$id_kriteria = $kriteria[$x]['id'];

	// apakah nilai bobot dari setiap kriteria yang dihitung sudah ada di database ?
		// jika belum, maka input baris baru
		// jika sudah, maka update nilainya

	$result = mysqli_query($kon,"SELECT * FROM kriteria_bobot WHERE id_kriteria = $id_kriteria");

	if(mysqli_num_rows($result) == 0){
		$query = "INSERT INTO kriteria_bobot VALUES ('$id_kriteria','".$bobot_kriteria[$x]."')";
	} else{
		$query = "UPDATE kriteria_bobot SET nilai = '".$bobot_kriteria[$x]."' WHERE id_kriteria = $id_kriteria[$x]";
	}

	mysqli_query($kon,$query);
}

// Cek Konsistensi Nilai Perbandingan

// hitung jumlah dari nilai bobot kriteria
$bk = 0;

foreach($bobot_kriteria as $a){
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

include 'kriteria_hasil.php';
?>