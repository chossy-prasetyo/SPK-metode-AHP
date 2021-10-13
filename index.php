<?php
session_start();
if(isset($_SESSION['login'])){
	header('Location: dashboard.php');
	exit;
}

include 'koneksi.php';

if(isset($_POST['login'])){

	$email = $_POST['email'];

	$result = mysqli_query($kon,"SELECT * FROM user WHERE email='$email'");
	if(mysqli_num_rows($result) === 1){
		$password = $_POST['password'];
		$account = mysqli_fetch_assoc($result);

		if(password_verify($password,$account['password'])){
			$_SESSION['login'] = true;
			header('Location: dashboard.php');
			exit;
		}	else{
			$error = 'password salah!';
		}
	} else{
		$error = "email tidak terdaftar, registrasi terlebih dahulu, klik link di bawah!";
	}
}
?>

<DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">

    <title>Login</title>
  </head>

  <body>
  	<div class="container">
      <div class="row justify-content-center">
        <div class="col-4">
          <div class="card mt-5 shadow-lg">
            <h5 class="card-header bg-success text-light text-center" style="padding: 24px 15px 24px 15px;">Halaman Login</h5>
            <div class="card-body p-4">
          		<form method="post">

                <!-- Notifikasi Login -->
                <?php if(isset($error)): ?>
                  <p class="text-center font-italic text-danger"><?= $error; ?></p>
                <?php endif; ?>

                <!-- Input Userame -->
								<div class="input-group mb-4">
								  <div class="input-group-prepend">
								    <span class="input-group-text" id="basic-addon1">
								    	<i class="fas fa-envelope"></i>
								    </span>
								  </div>
								  <input type="email" name="email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1" autocomplete="off" required>
								</div>

                <!-- Input Password -->
								<div class="input-group mb-4">
								  <div class="input-group-prepend">
								    <span class="input-group-text" id="basic-addon1">
								    	<i class="fas fa-key"></i>
								    </span>
								  </div>
								  <input type="password" name="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" required>
								</div>

                <!-- Tombol Login -->
            		<button class="btn btn-block btn-success mt-3" type="submit" name="login">Login</button>

            	</form>

							<p class="text-center font-weight-light">belum ada account ? klik link di bawah untuk registrasi</p>
							<div class="row justify-content-center">
								<div class="col-auto">
									<a href="registrasi.php" class="btn btn-sm btn-outline-success">Registrasi</a>
								</div>
							</div>
            </div>
          </div>          
        </div>
      </div>
    </div>
  </body>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</html>