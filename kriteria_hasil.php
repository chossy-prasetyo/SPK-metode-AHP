<?php include 'nav.php'; ?>

<div class="container">
  <div class="row mt-3">
    <div class="col-auto">
      <div class="card mt-3">
        <div class="card-header bg-success text-light"><h4>Kriteria</h4></div>
        <div class="card-body">

          <!-- matriks perbandingan Kriteria -->
          <h5>Matriks Perbandingan Kriteria</h5>
          <div class="row mt-3">
            <div class="col-auto">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr align="center">
                    <th scope="col">Kriteria</th>
                    <?php for($i = 0; $i <= ($n - 1); $i++){ ?>
                      <td><?php echo $kriteria[$i]['kriteria']; ?></td>
                    <?php } ?>
                  </tr>
                </thead>
                <tbody>
                  <?php for($i = 0; $i <= ($n - 1); $i++){ ?>
                    <tr>
                      <td><?php echo $kriteria[$i]['kriteria']; ?></td>
                      <?php for($j = 0; $j <= ($n - 1); $j++){ ?>
                        <td align="center"><?php echo round($matriks[$i][$j],2); ?></td>
                      <?php } ?>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>

          <!-- matriks bobot kriteria -->
          <h5 class="mt-4">Matriks Bobot Kriteria</h5>
          <div class="row mt-3">
            <div class="col-auto">
              <table class="table table-bordered table-striped">
                <thead align="center">
                  <tr>
                    <th scope="col">Kriteria</th>
                    <?php for($i = 0; $i <= ($n - 1); $i++){ ?>
                      <td><?php echo $kriteria[$i]['kriteria']; ?></td>
                    <?php } ?>
                    <th>Jumlah</th>
                    <th>Bobot</th>
                  </tr>
                </thead>
                <tbody>
                  <?php for($i = 0; $i <= ($n - 1); $i++){ ?>
                    <tr>
                      <td><?php echo $kriteria[$i]['kriteria']; ?></td>
                      <?php for($j = 0; $j <= ($n - 1); $j++){ ?>
                        <td align="center"><?php echo round($matriks_eigen_vektor[$i][$j],6); ?></td>
                      <?php } ?>
                      <td align="center"><?php echo round($jumlah_baris[$i],6); ?></td>
                      <td align="center"><?php echo round($bobot_kriteria[$i],6); ?></td>
                    </tr>
                  <?php } ?>
                  <tr>
                    <th colspan="<?php echo $n + 2; ?>">Eigen Vektor (λ max)</th>
                    <td><?php echo round($lambda_max,6); ?></td>
                  </tr>
                  <tr>
                    <th colspan="<?php echo $n + 2; ?>">Index Konsistensi (CI)</th>
                    <td><?php echo round($ci,6); ?></td>
                  </tr>
                  <tr>
                    <th colspan="<?php echo $n + 2; ?>">Rasio Konsistensi (CR)</th>
                    <td><?php echo round($cr*100,2); ?>%</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- jika nilai CR > 10%, beri peringatan dan suruh input lagi -->
          <?php if($cr > 0.1){ ?>
            <div class="alert alert-danger" role="alert" style="display: flex; align-items: center;">
              <i class="fas fa-exclamation-circle fa-3x mr-3"></i>
              Nilai Rasio Konsistensi melebihi 10%, input kembali nilai perbandingan!
            </div>

            <a href="kriteria.php#profile" class="btn btn-secondary float-right shadow mb-2">
              <i class="fas fa-arrow-left"></i>
              Input Perbandingan
            </a>

          <!-- jika nilai CR bagus, lanjutkan ke halaman alternatif  -->
          <?php } else{ ?>
            <a href="karyawan.php" class="btn btn-info float-right shadow mb-2 ml-1">
              Karyawan
              <i class="fas fa-arrow-right"></i>
            </a>            
            <a href="kriteria.php" class="btn btn-secondary float-right shadow mb-2">
              <i class="fas fa-arrow-left"></i>
              kembali
            </a>            
          <?php } ?>

        </div>
        <div class="card-footer bg-success text-light">Programmed By : Elsi Handika</div>
      </div>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>