<?php
include 'nav.php';

// query id semua kriteria
$result = mysqli_query($kon,"SELECT id FROM kriteria");

$id_semua_kriteria = [];

while($row = mysqli_fetch_assoc($result)){
  $id_semua_kriteria[] = $row['id'];
}

$id_kriteria_terakhir = max($id_semua_kriteria);
?>

<div class="container">
  <div class="card mt-3">
    <div class="card-header bg-success text-light"><h4>Kriteria : <?php echo $kriteria; ?></h4></div>
    <div class="card-body">

      <!-- matriks perbandingan Karyawan -->
      <h5>Matriks Perbandingan <?php echo $kriteria; ?> Karyawan</h5>
      <div class="row mt-3">
        <div class="col-auto">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th scope="col">Karyawan</th>
                <?php for($i = 0; $i <= ($n - 1); $i++){ ?>
                  <td><?php echo $karyawan[$i]['nama']; ?></td>
                <?php } ?>
              </tr>
            </thead>
            <tbody>
              <?php for($i = 0; $i <= ($n - 1); $i++){ ?>
                <tr>
                  <td><?php echo $karyawan[$i]['nama']; ?></td>
                  <?php for($j = 0; $j <= ($n - 1); $j++){ ?>
                    <td align="center"><?php echo round($matriks[$i][$j],2); ?></td>
                  <?php } ?>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- matriks bobot karyawan -->
      <h5 class="mt-4">Matriks Bobot <?php echo $kriteria; ?> Karyawan</h5>
      <table class="table table-bordered table-striped mt-3">
        <thead>
          <tr align="center">
            <th scope="col">Karyawan</th>
            <?php for($i = 0; $i <= ($n - 1); $i++){ ?>
              <td><?php echo $panggilan[$i][0]; ?></td>
            <?php } ?>
            <th>Jumlah</th>
            <th>Bobot</th>
          </tr>
        </thead>
        <tbody>
          <?php for($i = 0; $i <= ($n - 1); $i++){ ?>
            <tr align="center">
              <td align="left"><?php echo $panggilan[$i][0]; ?></td>
              <?php for($j = 0; $j <= ($n - 1); $j++){ ?>
                <td><?php echo round($matriks_eigen_vektor[$i][$j],6); ?></td>
              <?php } ?>
              <td><?php echo round($jumlah_baris[$i],6); ?></td>
              <td><?php echo round($bobot_karyawan[$i],6); ?></td>
            </tr>
          <?php } ?>
          <tr>
            <th colspan="<?php echo $n + 2; ?>">Eigen Vektor (λ max)</th>
            <td align="center"><?php echo round($lambda_max,6); ?></td>
          </tr>
          <tr>
            <th colspan="<?php echo $n + 2; ?>">Index Konsistensi (CI)</th>
            <td align="center"><?php echo round($ci,6); ?></td>
          </tr>
          <tr>
            <th colspan="<?php echo $n + 2; ?>">Rasio Konsistensi (CR)</th>
            <td align="center"><?php echo round($cr*100,2); ?>%</td>
          </tr>
        </tbody>
      </table>

      <!-- jika nilai CR > 10%, beri peringatan dan suruh input lagi -->
      <?php if($cr > 0.1){ ?>
        <div class="alert alert-danger" role="alert" style="display: flex; align-items: center;">
          <i class="fas fa-exclamation-circle fa-3x mr-3"></i>
          Nilai Rasio Konsistensi melebihi 10%, input kembali nilai perbandingan!
        </div>

        <a href="karyawan_input_perbandingan.php?id_kriteria=<?php echo $id_kriteria; ?>" class="btn btn-secondary float-right shadow mb-2">
          <i class="fas fa-arrow-left"></i>
          Input Perbandingan
        </a>

      <!-- jika nilai CR bagus, lanjutkan ke halaman kriteria selanjutnya  -->
      <?php } else{ ?>
        <?php if($id_kriteria == $id_kriteria_terakhir){ ?>
          <a href="laporan.php" class="btn btn-info float-right shadow mb-2 ml-1">
            <i class="fas fa-award"></i>
            Hasil
          </a>
        <?php } else{ ?>
          <a href="karyawan_input_perbandingan.php?id_kriteria=<?php echo $id_semua_kriteria[$index_id_kriteria_sekarang[0]+1]; ?>" class="btn btn-info float-right shadow mb-2 ml-1">
            Next
            <i class="fas fa-arrow-right"></i>
          </a>
        <?php } ?>
        <a href="karyawan_input_perbandingan.php?id_kriteria=<?php echo $id_kriteria; ?>" class="btn btn-secondary float-right shadow mb-2">
          <i class="fas fa-arrow-left"></i>
          kembali
        </a>            
      <?php } ?>

    </div>
    <div class="card-footer bg-success text-light">Programmed By : Elsi Handika</div>
  </div>
</div>

<?php include 'footer.php'; ?>