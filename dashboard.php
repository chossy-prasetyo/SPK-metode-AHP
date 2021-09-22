<?php include 'nav.php'; ?>

<div class="container">
  <div class="card mt-3">
    <div class="card-header bg-success text-light"><h4>Beranda</h4></div>
      <div class="card-body">
        <div class="row justify-content-center">

          <!-- kartu kriteria -->
          <div class="col-md-3">
            <div class="card card-kriteria">
              <a href="kriteria.php" class="text-white" style="text-decoration: none;">
                <h4 class="card-header text-light text-center bg-dark">Kriteria</h4>
                <div class="card-body text-center pb-5">
                  <i class="fas fa-user-cog fa-5x text-dark"></i>
                </div>                
              </a>
            </div>
          </div>

          <!-- kartu karyawan -->
          <div class="col-md-3">
            <div class="card card-karyawan">
              <a href="karyawan.php" class="text-white" style="text-decoration: none;">
                <h4 class="card-header text-center bg-primary text-light">Karyawan</h4>
                <div class="card-body text-center pb-5">
                  <i class="fas fa-users fa-5x text-primary"></i>
                </div>                
              </a>
            </div>
          </div>

          <!-- kartu laporan -->
          <div class="col-md-3">
            <div class="card card-laporan">
              <a href="laporan.php" class="text-white" style="text-decoration: none;">
                <h4 class="card-header text-center bg-warning text-light">Laporan</h4>
                <div class="card-body text-center pb-5">
                  <i class="fas fa-clipboard-list fa-5x text-warning"></i>
                </div>                
              </a>
            </div>
          </div>

        </div>
      </div>
      <div class="card-footer bg-success text-light">Programmed By : Elsi Handika</div>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>
