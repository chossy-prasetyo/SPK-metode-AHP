<?php
include 'nav.php';

// query kriteria dan hitung jumlahnya
$result = mysqli_query($kon,"SELECT * FROM kriteria");

$kriteria = [];

while($row = mysqli_fetch_assoc($result)){
  $kriteria[] = $row;
}

$n = count($kriteria);

// buat nilai perbandingan yg akan dilooping
$perbandingan = [
                  '1. Sama penting',
                  '2. Mendekati sedikit lebih penting',
                  '3. Sedikit lebih penting',
                  '4. Mendekati lebih penting',
                  '5. Lebih penting',
                  '6. Mendekati jelas lebih penting',
                  '7. Jelas lebih penting',
                  '8. Mendekati mutlak penting',
                  '9. Mutlak penting'
                ];
?>

<div class="container">
  <div class="row">
    <div class="col-8">
      <div class="card mt-3">
        <div class="card-header bg-success text-light"><h4>Kriteria</h4></div>
        <div class="card-body">

          <!-- tombol tambah kriteria, hanya muncul selama jumlah kriteria < 15 -->
          <?php if($n < 15){ ?>
            <button type="button" class="btn btn-info mb-3 shadow" data-toggle="modal" data-target="#tambahKriteria">
              <i class="fas fa-user-cog"></i>
              Tambah Kriteria
            </button>
          <?php } ?>

          <!-- judul tab halaman kriteria -->
          <ul class="nav nav-tabs mt-2" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"><h6>Daftar Kriteria</h6></a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><h6>Input Perbandingan</h6></a>
            </li>
          </ul>
          <!-- akhir judul tab halaman kriteria -->

          <!-- body tab halaman kriteria -->
          <div class="tab-content" id="myTabContent">

            <!-- tab daftar kriteria -->
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
              <ul class="list-group mt-4">

                <!-- tampilkan list kriteria jika ada, beri notif jika tidak ada -->
                <?php
                if($n > 0){
                  $i = 1;
                  foreach($kriteria as $k){
                ?>
                    <li class="list-group-item">
                      <?php echo $i.". ".$k['kriteria']; ?>
                      <a onclick="return confirm('hapus kriteria <?php echo $k["kriteria"]; ?> ?')" href="kriteria_hapus.php?id=<?php echo $k['id']; ?>" class="btn btn-danger btn-sm float-right ml-1">
                        <i class="fas fa-times"></i>
                        Hapus
                      </a>
                      <a href="kriteria_edit.php?id=<?php echo $k['id']; ?>" class="btn btn-warning btn-sm float-right">
                        <i class="fas fa-pen"></i>
                        Edit
                      </a>  
                    </li>
                <?php
                  $i++;
                  }
                } else{
                ?>
                  <div class="alert alert-danger mt-4" role="alert">
                    Tidak ada kriteria!
                  </div>
                <?php 
                }
                ?>

              </ul>
            </div>
            <!-- akhir tab daftar kriteria -->

            <!-- tab input perbandingan kriteria -->
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

            <?php
            // jika jumlah kriteria > 2, tampilkan input nilai perbandingan
            if($n > 2){
            ?>
              <table class="table table-bordered table-hover mt-4">
                <thead align="center">
                  <tr>
                    <th scope="col" colspan="2">pilih yang lebih penting</th>
                    <th scope="col">nilai perbandingan</th>
                  </tr>
                </thead>
                <tbody>
                  <form action="kriteria_input_perbandingan.php" method="post">

                    <!-- looping input perbandingan berdasarkan jumlah kriteria yg dibandingkan -->
                    <?php
                    $urut = 0;

                    for($x = 0; $x <= ($n - 2); $x++){
                      for($y = ($x + 1); $y <= ($n - 1); $y++){
                        $urut++;

                        // query nilai perbandingan dari dua kriteria yg dilooping
                        $query = "SELECT nilai FROM kriteria_perbandingan WHERE
                                    id_kriteria1 = ".$kriteria[$x]['id']." AND
                                    id_kriteria2 = ".$kriteria[$y]['id']."";
                        $result = mysqli_query($kon,$query);

                        if(mysqli_num_rows($result) == 0){
                          $nilai = 1;
                        } else{
                          $row = mysqli_fetch_assoc($result);
                          $nilai = $row['nilai'];
                        }

                        // jika nilai perbandingan < 1, pilih radio kriteria ke 2
                        if($nilai < 1){
                          $nilai = round(1 / $nilai);
                    ?>
                          <tr>
                            <td>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="perbandingan<?php echo $urut; ?>" id="kriteria<?php echo $urut.$x; ?>" value="1">
                                <label class="form-check-label" for="kriteria<?php echo $urut.$x; ?>"><?php echo $kriteria[$x]['kriteria']; ?></label>
                              </div>
                            </td>
                            <td>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="perbandingan<?php echo $urut; ?>" id="kriteria<?php echo $urut.$y; ?>" value="2" checked>
                                <label class="form-check-label" for="kriteria<?php echo $urut.$y; ?>"><?php echo $kriteria[$y]['kriteria']; ?></label>
                              </div>
                            </td>
                            <td>
                              <div class="form-group">
                                <select class="form-control" name="nilai<?php echo $urut; ?>">

                                  <!-- looping nilai perbandingan dan pilih yg sudah ada di database -->
                                  <?php for($i = 1; $i <= 9; $i++){ ?>
                                    <option value="<?php echo $i; ?>" <?php if($i == $nilai){ echo 'selected'; } ?>><?php echo $perbandingan[$i-1]; ?></option>
                                  <?php } ?>

                                </select>
                              </div>
                            </td>
                          </tr>
                    <?php
                        // jika nilai perbandingan > 1, pilih radio kriteria ke 1
                        } else{
                    ?>
                          <tr>
                            <td>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="perbandingan<?php echo $urut; ?>" id="kriteria<?php echo $urut.$x; ?>" value="1" checked>
                                <label class="form-check-label" for="kriteria<?php echo $urut.$x; ?>"><?php echo $kriteria[$x]['kriteria']; ?></label>
                              </div>
                            </td>
                            <td>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="perbandingan<?php echo $urut; ?>" id="kriteria<?php echo $urut.$y; ?>" value="2">
                                <label class="form-check-label" for="kriteria<?php echo $urut.$y; ?>"><?php echo $kriteria[$y]['kriteria']; ?></label>
                              </div>
                            </td>
                            <td>
                              <div class="form-group">
                                <select class="form-control" name="nilai<?php echo $urut; ?>">

                                  <!-- looping nilai perbandingan dan pilih yg sudah ada di database -->
                                  <?php for($i = 1; $i <= 9; $i++){ ?>
                                    <option value="<?php echo $i; ?>" <?php if($i == $nilai){ echo 'selected'; } ?>><?php echo $perbandingan[$i-1]; ?></option>
                                  <?php } ?>

                                </select>
                              </div>
                            </td>
                          </tr>
                    <?php
                        }
                      }
                    }
                    ?>
                    <!-- akhir looping input perbandingan berdasarkan jumlah kriteria yg dibandingkan -->

                </tbody>
              </table>
                    <!-- tombol eksekusi menghitung nilai bobot kriteria -->
                    <div class="row justify-content-center">
                      <div class="col-auto">
                        <button type="submit" class="btn btn-lg btn-info shadow">
                          <i class="fas fa-sync-alt"></i>
                          Hitung
                        </button>
                      </div>
                    </div>
                  </form>

            <?php
            // jika jumlah kriteria <= 2, jangan tampilkan input perbandingan dan beri notif
            } else{
            ?>
              <div class="alert alert-danger mt-4" role="alert">
                Tidak dapat input perbandingan, kriteria tidak boleh kurang dari 3!
              </div>
            <?php
            }
            ?>

            </div>
            <!-- akhir tab input perbandingan kriteria -->

          </div>
          <!-- akhir body tab halaman kriteria -->

        </div>
        <div class="card-footer bg-success text-light">Programmed By : Elsi Handika</div>
      </div>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>

<!-- modal tambah kriteria -->
<div class="modal fade" id="tambahKriteria" tabindex="-1" aria-labelledby="judulModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="judulModal">Tambah Kriteria</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="kriteria_tambah_proses.php" method="post">
          <div class="form-group">
            <input type="text" class="form-control" name="kriteria" id="kriteria" placeholder="Input Kriteria" required autocomplete="off">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-info">
          <i class="fas fa-save"></i>
          Tambah
        </button>
        </form>
      </div>
    </div>
  </div>
</div>