<?php
include 'nav.php';

$id = $_GET['id'];

// query dulu data yg akan diedit
$hasil		= mysqli_query($kon,"SELECT * FROM karyawan WHERE id = $id");
$karyawan = mysqli_fetch_assoc($hasil);
?>

<div class ="container">
	<div class="row">
		<div class="col-md-6">
			<div class ="card mt-3 shadow-lg">
				<div class ="card-header bg-success text-light">
					<h5>Edit Data Karyawan</h5>
				</div>
				<div class="card-body">
					<form method="post" action="karyawan_edit_proses.php">

						<!-- input nama -->
					  <div class="form-group row">
					    <label for="nama" class="col-sm-4 col-form-label">Nama</label>
					    <div class="col-sm-8">
					    	<input type="hidden" name="id" value="<?php echo $karyawan['id']; ?>">
					      <input type="text" name="nama" class="form-control" id="nama" required autocomplete="off" value="<?php echo $karyawan['nama']; ?>">
					    </div>
					  </div>

						<!-- pilihan gender -->
					  <div class="form-group row">
					    <label for="gender" class="col-sm-4 col-form-label">Gender</label>
					    <div class="col-sm-8">
						    <select name="gender" class="form-control">
									<option value="Laki-laki" <?php if($karyawan['gender']=='Laki-laki'){ echo 'selected'; }; ?>>Laki-laki</option>
									<option value="Perempuan" <?php if($karyawan['gender']=='Perempuan'){ echo 'selected'; }; ?>>Perempuan</option>
								</select>
					    </div>
					  </div>

						<!-- input jabatan -->
					  <div class="form-group row">
					    <label for="jabatan" class="col-sm-4 col-form-label">Jabatan</label>
					    <div class="col-sm-8">
					      <input type="text" name="jabatan" class="form-control" id="jabatan" required autocomplete="off" value="<?php echo $karyawan['jabatan']; ?>">
					    </div>
					  </div>

						<!-- pilihan status -->
					  <div class="form-group row">
					    <label for="status" class="col-sm-4 col-form-label">Status</label>
					    <div class="col-sm-8">
						    <select name="status" class="form-control">
									<option value="Kontrak" <?php if($karyawan['status']=='Kontrak'){ echo 'selected'; }; ?>>Kontrak</option>
									<option value="Tetap" <?php if($karyawan['status']=='Tetap'){ echo 'selected'; }; ?>>Tetap</option>
								</select>
					    </div>
					  </div>

						<!-- input tanggal bergabung -->
					  <div class="form-group row">
					    <label for="tanggal_bergabung" class="col-sm-4 col-form-label">Tanggal Bergabung</label>
					    <div class="col-sm-8">
					      <input type="date" name="tanggal_bergabung" class="form-control" id="tanggal_bergabung" required value="<?php echo $karyawan['tanggal_bergabung']; ?>">
					    </div>
					  </div>

						<!-- tombol eksekusi -->
						<button class="btn btn-sm btn-info float-right ml-1" name="simpan" onclick="return confirm('ubah data ?')">
							<i class="fas fa-save"></i>
							Simpan
						</button>
						<a href="karyawan.php" class="btn btn-sm btn-secondary float-right">Batal</a>

					</form>
				</div>
				<div class="card-footer bg-success text-light">
					Programed By : Elsi Handika
				</div>
			</div>			
		</div>
	</div>
</div>

<?php include 'footer.php'; ?>
