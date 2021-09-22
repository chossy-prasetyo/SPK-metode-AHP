<?php
include 'nav.php';

// query kriteria dan hitung jumlahnya
$result = mysqli_query($kon,"SELECT * FROM kriteria");

$kriteria = [];

while($row = mysqli_fetch_assoc($result)){
  $kriteria[] = $row;
}

$n_kriteria = count($kriteria);

// beri notif jika jumlah kriteria < 3
if($n_kriteria < 3){
	include 'laporan_notif_kriteria.php';
	include 'footer.php';
	die;
}

// cek ketersedian kriteria_bobot
$result = mysqli_query($kon,"SELECT * FROM kriteria_bobot");

// beri notif jika kriteria_bobot belum dihitung
if(mysqli_num_rows($result) == 0){
	include 'laporan_notif_kriteria_bobot.php';
	include 'footer.php';
	die;
}

// query karyawan dan hitung jumlahnya
$result = mysqli_query($kon,"SELECT * FROM karyawan");

$karyawan = [];

while($row = mysqli_fetch_assoc($result)){
  $karyawan[] = $row;
}

$n_karyawan = count($karyawan);

// beri notif jika jumlah karyawan < 3
if($n_karyawan < 3){
	include 'laporan_notif_karyawan.php';
	include 'footer.php';
	die;
}

// cek ketersedian karyawan_bobot untuk setiap kriteria
$jumlah_karyawan_bobot = $n_karyawan * $n_kriteria;

$result = mysqli_query($kon,"SELECT * FROM karyawan_bobot");

// beri notif jika karyawan_bobot belum dihitung untuk setiap kriteria
if(mysqli_num_rows($result) != $jumlah_karyawan_bobot){
	include 'laporan_notif_karyawan_bobot.php';
	include 'footer.php';
	die;
}

// menghitung nilai karyawan
$nilai = [];

for($x = 0; $x <= ($n_karyawan - 1); $x++){

	$nilai[$x] = 0;

	for($y = 0; $y <= ($n_kriteria - 1); $y++){

		$id_karyawan = $karyawan[$x]['id'];
		$id_kriteria = $kriteria[$y]['id'];

		// query bobot karyawan
		$query = "SELECT nilai FROM karyawan_bobot WHERE
								id_karyawan = $id_karyawan AND
								id_kriteria = $id_kriteria";
		$result = mysqli_query($kon,$query);
		$row 		= mysqli_fetch_assoc($result);
		$bobot_karyawan = $row['nilai'];

		// query bobot kriteria
		$query = "SELECT nilai FROM kriteria_bobot WHERE id_kriteria = $id_kriteria";
		$result = mysqli_query($kon,$query);
		$row		= mysqli_fetch_assoc($result);
		$bobot_kriteria = $row['nilai'];

		// jumlahkan nilai karyawan di setiap kriteria
		$nilai[$x] += ($bobot_karyawan * $bobot_kriteria);
	}
}

// insert / update karyawan_ranking
for($i = 0; $i <= ($n_karyawan - 1); $i++){

	$id_karyawan = $karyawan[$i]['id'];

	$result = mysqli_query($kon,"SELECT * FROM karyawan_ranking WHERE id_karyawan = $id_karyawan");

	if(mysqli_num_rows($result) == 0){
		$query = "INSERT INTO karyawan_ranking VALUES ('$id_karyawan','".$nilai[$i]."')";
	} else{
		$query = "UPDATE karyawan_ranking SET nilai = '".$nilai[$i]."' WHERE id_karyawan = $id_karyawan";
	}

	mysqli_query($kon,$query);
}

// query kriteria
$bbt_kriteria = [];

$result = mysqli_query($kon,"SELECT nilai FROM kriteria_bobot");

while($row = mysqli_fetch_assoc($result)){
	$bbt_kriteria[] = $row;
}

// query karyawan_bobot
$bbt_karyawan = [];

for($x = 0; $x <= ($n_kriteria - 1); $x++){
	for($y = 0; $y <= ($n_karyawan - 1); $y++){

		$id_kriteria = $kriteria[$x]['id'];
		$id_karyawan = $karyawan[$y]['id'];

		$query = "SELECT nilai FROM karyawan_bobot WHERE
								id_kriteria = $id_kriteria AND
								id_karyawan = $id_karyawan";
		$result = mysqli_query($kon,$query);
		$row 		= mysqli_fetch_assoc($result);
		$bbt_karyawan[$x][$y] = $row['nilai'];
	}
}

// query karywan_ranking
$ranking = [];

$result = mysqli_query($kon,"SELECT nilai FROM karyawan_ranking");

while($row = mysqli_fetch_assoc($result)){
	$ranking[] = $row;
}

// siapkan bahan perangkingan
$bahan = [];

foreach($ranking as $r){
	$bahan[] = $r['nilai'];
}

// menentukan peringkat karyawan
$peringkat = [];

for($i = 0; $i < $n_karyawan; $i++){
  $max    = max($bahan);
  $index  = array_keys($bahan,$max);
  $peringkat[$index[0]] = $i+1;
  unset($bahan[$index[0]]);
}

$array = array_keys($peringkat);
?>

<div class="container">
	<div class="row">
		<div class="col-auto">
		  <div class="card mt-3">
		    <div class="card-header bg-success text-light"><h4>Laporan</h4></div>
		    <div class="card-body">

		    	<!-- peringkat karyawan -->
		    	<h5>Peringkat</h5>
		    	<div class="row">
		    		<div class="col-auto">
		    			<table class="table table-bordered table-striped mt-2">
		    				<thead>
		    					<tr align="center">
		    						<th scope="col">Peringkat</th>
		    						<th scope="col">Karyawan</th>
		    						<th scope="col">Nilai</th>
		    					</tr>
		    				</thead>
		    				<tbody>
			            <?php for($i = 0; $i < $n_karyawan; $i++){ ?>
			              <tr align="center">
			                <td>
			                  <?php if($i+1 == 1){ ?>
			                    <img src="img/crown2-gold.png" width="60">
			                  <?php } elseif($i+1 == 2){ ?>
			                    <img src="img/crown2-silver.png" width="50">
			                  <?php } elseif($i+1 == 3){ ?>
			                    <img src="img/crown2-bronze.png" width="40">
			                  <?php } else{ ?>
			                    <?php echo $i+1; ?>
			                  <?php } ?>
			                </td>
			                <td align="left"><?php echo $karyawan[$array[$i]]['nama']; ?></td>
			                <td><?php echo round($ranking[$array[$i]]['nilai'],6); ?></td>
			              </tr>
			            <?php } ?>
		    				</tbody>
		    			</table>
		    		</div>
		    	</div>

		    	<!-- hasil perhitungan -->
		    	<h5 class="mt-4">Hasil Perhitungan</h5>
		    	<div class="row">
		    		<div class="col-auto">
				      <table class="table table-bordered table-striped mt-2">
				        <thead>
				          <tr align="center">
				            <th scope="col">Kriteria</th>
				            <th scope="col">Bobot</th>
				            <?php for($i = 0; $i <= ($n_karyawan - 1); $i++){ ?>
				              <td><?php echo $karyawan[$i]['nama']; ?></td>
				            <?php } ?>
				          </tr>
				        </thead>
				        <tbody>
				          <?php for($i = 0; $i <= ($n_kriteria - 1); $i++){ ?>
				            <tr>
				              <td><?php echo $kriteria[$i]['kriteria']; ?></td>
				              <td align="center"><?php echo round($bbt_kriteria[$i]['nilai'],6); ?></td>
				              <?php for($j = 0; $j <= ($n_karyawan - 1); $j++){ ?>
				              	<td align="center"><?php echo round($bbt_karyawan[$i][$j],6); ?></td>
				              <?php } ?>
				            </tr>
				          <?php } ?>
				          <tr align="center">
				          	<th colspan="2">Jumlah Perkalian Bobot</th>
					          <?php for($i = 0; $i <= ($n_karyawan - 1); $i++){ ?>
					          	<th><?php echo round($ranking[$i]['nilai'],6); ?></th>
					          <?php } ?>
				          </tr>
				          <tr align="center">
				          	<th colspan="2">Peringkat</th>
					          <?php for($i = 0; $i <= ($n_karyawan - 1); $i++){ ?>
					          	<th><?php echo $peringkat[$i]; ?></th>
					          <?php } ?>
				          </tr>
				        </tbody>
				      </table>
		    		</div>
		    	</div>

		    </div>
		    <div class="card-footer bg-success text-light">Programmed By : Elsi Handika</div>
		  </div>
		</div>
	</div>
</div>

<?php include 'footer.php'; ?>