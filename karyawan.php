<?php
include 'nav.php';

// query karyawan dan hitung jumlahnya
$query = mysqli_query($kon,"SELECT * FROM karyawan ORDER BY nama ASC");

$karyawan = [];

while($hasil = mysqli_fetch_assoc($query)){
  $karyawan[]  = $hasil;
}

$n_karyawan = count($karyawan);

// query kriteria dan hitung jumlahnya
$query = mysqli_query($kon,"SELECT * FROM kriteria");

$kriteria = [];

while($hasil = mysqli_fetch_assoc($query)){
  $kriteria[]  = $hasil;
}

$n_kriteria = count($kriteria);
?>

<div class="container">
  <div class="card mt-3">
    <div class="card-header bg-success text-light"><h4>Karyawan</h4></div>
    <div class="card-body">

      <!-- tombol tambah karyawan, hanya muncul selama jumlah karyawan < 15 -->
      <?php if($n_karyawan < 15){ ?>
        <a class="btn btn-info shadow mb-3" href="karyawan_tambah.php">
          <i class="fas fa-user-plus"></i>
          Tambah Karyawan
        </a>
      <?php } ?>

      <!-- judul tab halaman karyawan -->
      <ul class="nav nav-tabs mt-2" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"><h6>Daftar Karyawan</h6></a>
        </li>
        <li class="nav-item" role="presentation">
          <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><h6>Input Perbandingan</h6></a>
        </li>
      </ul>
      <!-- akhir judul tab halaman karyawan -->

      <!-- body tab halaman karyawan -->
      <div class="tab-content" id="myTabContent">

        <!-- tab daftar karyawan -->
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

          <!-- beri notif jika tidak ada karyawan, tampilkan jika ada -->
          <?php if($n_karyawan == 0){ ?>
            <div class="row">
              <div class="col-5">
                <div class="alert alert-danger mt-4" role="alert">
                  Tidak ada karyawan!
                </div>
              </div>
            </div>
          <?php } else{ ?>
            <!-- tabel karyawan -->
            <table class ="table table-bordered table-striped mt-4">
              <thead align="center">
                <th>No</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Jabatan</th>
                <th>Status</th>
                <th>Tanggal Bergabung</th>
                <th colspan="2">Aksi</th>
              </thead>
              <tbody>
                <?php $no = 1; foreach($karyawan as $k): ?>
                  <tr>
                    <td align="center"><?php echo $no; ?></td>
                    <td><?php echo $k['nama']; ?></td>
                    <td align="center"><?php echo $k['gender']; ?></td>
                    <td align="center"><?php echo $k['jabatan']; ?></td>
                    <td align="center"><?php echo $k['status']; ?></td>
                    <td align="center"><?php echo $k['tanggal_bergabung']; ?></td>
                    <td align="center">
                      <a href="karyawan_hapus.php?id=<?php echo $k['id']; ?>" onclick="return confirm('hapus <?php echo $k["nama"]; ?> ?')" class="btn btn-danger btn-sm">
                        <i class ="fas fa-user-times"></i>
                        Hapus
                      </a>
                    </td>
                    <td align="center">
                      <a href="karyawan_edit.php?id=<?php echo $k['id']; ?>" class="btn btn-warning btn-sm">
                        <i class ="fas fa-user-edit"></i>
                        Edit
                      </a>
                    </td>
                  </tr>
                <?php $no++; endforeach; ?>
              </tbody>
            </table>
            <!-- akhir tabel karyawan -->
          <?php } ?>

        </div>
        <!-- akhir tab daftar karyawan -->

        <!-- tab input perbandingan karyawan -->
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

          <!-- jumlah karyawan dan kriteria tidak boleh kurang dari 3 -->
          <?php if($n_karyawan < 3){ ?>
            <div class="row">
              <div class="col-7">
                <div class="alert alert-danger mt-4" role="alert">
                  Tidak dapat input perbandingan, karyawan tidak boleh kurang dari 3!
                </div>
              </div>
            </div>
          <?php } else{ ?>
            <?php if($n_kriteria < 3){ ?>
              <div class="row">
                <div class="col-6">
                  <div class="alert alert-danger mt-4" role="alert">
                    Tidak dapat input perbandingan, kriteria tidak boleh kurang dari 3!
                  </div>
                </div>
              </div>
            <?php } else{ ?>
              <div class="row">
                <div class="col-5">
                  <h5 class="my-3 ml-3">Pilih Kriteria</h5>
                  <div class="list-group">
                    <?php foreach($kriteria as $k){ ?>
                      <a href="karyawan_input_perbandingan.php?id_kriteria=<?php echo $k['id']; ?>" class="list-group-item list-group-item-action text-primary"><h6><?php echo $k['kriteria']; ?></h6></a>
                    <?php } ?>
                  </div>
                </div>
              </div>
            <?php } ?>
          <?php } ?>

        </div>
        <!-- akhir tab input perbandingan karyawan -->

      </div>
      <!-- akhir body tab halaman karyawan -->

    </div>
    <div class="card-footer bg-success text-light">Programmed By : Elsi Handika</div>
  </div>
</div>

<?php include 'footer.php'; ?>