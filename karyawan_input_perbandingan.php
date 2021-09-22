<?php
include 'nav.php';

$id_kriteria = $_GET['id_kriteria'];

// query kriteria yg dirujuk
$result   = mysqli_query($kon,"SELECT kriteria FROM kriteria WHERE id = $id_kriteria");
$row      = mysqli_fetch_assoc($result);
$kriteria = $row['kriteria'];

// query karyawan dan hitung jumlahnya
$result = mysqli_query($kon,"SELECT * FROM karyawan");

$karyawan = [];

while($row = mysqli_fetch_assoc($result)){
  $karyawan[] = $row;
}

$n = count($karyawan);

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
  <div class="card mt-3">
    <div class="card-header bg-success text-light"><h5>Kriteria : <?php echo $kriteria; ?></h5></div>
    <div class="card-body">

      <h5>Input Perbandingan <?php echo $kriteria; ?> Karyawan</h5>

      <table class="table table-bordered table-hover mt-4">
        <thead align="center">
          <tr>
            <th scope="col" colspan="2">pilih yang lebih penting</th>
            <th scope="col">nilai perbandingan</th>
          </tr>
        </thead>
        <tbody>
          <form action="karyawan_proses_perbandingan.php" method="post">
            <input type="hidden" value="<?php echo $id_kriteria; ?>" name="id_kriteria">
            <input type="hidden" value="<?php echo $kriteria; ?>" name="kriteria">

            <!-- looping input perbandingan berdasarkan jumlah karyawan yg dibandingkan -->
            <?php
            $urut = 0;

            for($x = 0; $x <= ($n - 2); $x++){
              for($y = ($x + 1); $y <= ($n - 1); $y++){
                $urut++;

                // query nilai perbandingan dari dua karyawan yg dilooping
                $query = "SELECT nilai FROM karyawan_perbandingan WHERE
                            id_karyawan1 = ".$karyawan[$x]['id']." AND
                            id_karyawan2 = ".$karyawan[$y]['id']." AND
                            id_kriteria  = ".$id_kriteria."";
                $result = mysqli_query($kon,$query);

                if(mysqli_num_rows($result) == 0){
                  $nilai = 1;
                } else{
                  $row = mysqli_fetch_assoc($result);
                  $nilai = $row['nilai'];
                }

                // jika nilai perbandingan < 1, pilih radio karyawan ke 2
                if($nilai < 1){
                  $nilai = round(1 / $nilai);
            ?>
                  <tr>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="perbandingan<?php echo $urut; ?>" id="karyawan<?php echo $urut.$x; ?>" value="1">
                        <label class="form-check-label" for="karyawan<?php echo $urut.$x; ?>"><?php echo $karyawan[$x]['nama']; ?></label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="perbandingan<?php echo $urut; ?>" id="karyawan<?php echo $urut.$y; ?>" value="2" checked>
                        <label class="form-check-label" for="karyawan<?php echo $urut.$y; ?>"><?php echo $karyawan[$y]['nama']; ?></label>
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
                // jika nilai perbandingan > 1, pilih radio karyawan ke 1
                } else{
                ?>
                  <tr>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="perbandingan<?php echo $urut; ?>" id="karyawan<?php echo $urut.$x; ?>" value="1" checked>
                        <label class="form-check-label" for="karyawan<?php echo $urut.$x; ?>"><?php echo $karyawan[$x]['nama']; ?></label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="perbandingan<?php echo $urut; ?>" id="karyawan<?php echo $urut.$y; ?>" value="2">
                        <label class="form-check-label" for="karyawan<?php echo $urut.$y; ?>"><?php echo $karyawan[$y]['nama']; ?></label>
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
            <!-- akhir looping input perbandingan berdasarkan jumlah karyawan yg dibandingkan -->

        </tbody>
      </table>
            <!-- tombol eksekusi menghitung nilai bobot karyawan -->
            <div class="row justify-content-center">
              <div class="col-auto">
                <button type="submit" class="btn btn-lg btn-info shadow">
                  <i class="fas fa-sync-alt"></i>
                  Hitung
                </button>
              </div>
            </div>
          </form>

    </div>
    <div class="card-footer bg-success text-light">Programmed By : Elsi Handika</div>
  </div>
</div>