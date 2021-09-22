<?php
include 'nav.php';

$id = $_GET['id'];

// query dulu data yg akan diedit
$hasil		= mysqli_query($kon,"SELECT * FROM kriteria WHERE id = $id");
$kriteria = mysqli_fetch_assoc($hasil);
?>

<div class ="container">
	<div class="row">
		<div class="col-md-4">
			<div class ="card mt-3 shadow-lg">
				<div class ="card-header bg-success text-light">
					<h5>Edit Kriteria</h5>
				</div>
				<div class="card-body">
					<form method="post" action="kriteria_edit_proses.php">

	          <div class="form-group">
					    <input type="hidden" name="id" value="<?php echo $kriteria['id']; ?>">
	            <input type="text" class="form-control" name="kriteria" id="kriteria" value="<?php echo $kriteria['kriteria']; ?>" placeholder="Input Kriteria" required autocomplete="off">
	          </div>

						<!-- tombol eksekusi -->
						<button class="btn btn-sm btn-info float-right ml-1" name="simpan" onclick="return confirm('ubah kriteria ?')">
							<i class="fas fa-save"></i>
							Simpan
						</button>
						<a href="kriteria.php" class="btn btn-sm btn-secondary float-right">Batal</a>

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
