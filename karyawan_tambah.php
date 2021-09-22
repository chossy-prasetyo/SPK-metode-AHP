<?php include 'nav.php'; ?>

<div class ="container">
	<div class="row">
		<div class="col-md-6">
			<div class ="card mt-3 shadow-lg">
				<div class ="card-header bg-success text-light">
					<h5>Tambah Karyawan</h5>
				</div>
				<div class="card-body">
					<form method="post" action="karyawan_tambah_proses.php">

						<!-- input nama -->
					  <div class="form-group row">
					    <label for="nama" class="col-sm-4 col-form-label">Nama</label>
					    <div class="col-sm-8">
					      <input type="text" name="nama" class="form-control" id="nama" required autocomplete="off">
					    </div>
					  </div>

						<!-- pilihan gender -->
					  <div class="form-group row">
					    <label for="gender" class="col-sm-4 col-form-label">Gender</label>
					    <div class="col-sm-8">
						    <select name="gender" id="gender" class="form-control">
									<option value="Laki-laki">Laki-laki</option>
									<option value="Perempuan">Perempuan</option>
								</select>
					    </div>
					  </div>

						<!-- input jabatan -->
					  <div class="form-group row">
					    <label for="jabatan" class="col-sm-4 col-form-label">Jabatan</label>
					    <div class="col-sm-8">
					      <input type="text" name="jabatan" class="form-control" id="jabatan" required autocomplete="off">
					    </div>
					  </div>

						<!-- pilihan status -->
					  <div class="form-group row">
					    <label for="status" class="col-sm-4 col-form-label">Status</label>
					    <div class="col-sm-8">
						    <select name="status" id="status" class="form-control">
									<option value="Kontrak">Kontrak</option>
									<option value="Tetap">Tetap</option>
								</select>
					    </div>
					  </div>

						<!-- input tanggal bergabung -->
					  <div class="form-group row">
					    <label for="tanggal_bergabung" class="col-sm-4 col-form-label">Tanggal Bergabung</label>
					    <div class="col-sm-8">
					      <input type="date" name="tanggal_bergabung" class="form-control" id="tanggal_bergabung" required>
					    </div>
					  </div>

						<!-- tombol eksekusi -->
						<button class="btn btn-sm btn-info float-right ml-1" name="tambah">
							<i class="fas fa-save"></i>
							Tambah
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