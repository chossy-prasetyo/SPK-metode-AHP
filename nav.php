<?php
session_start();
if(!isset($_SESSION['login'])){
  header('Location: index.php');
  exit;
}


include "koneksi.php";

$menu = [
  [
    'nama'  => 'Beranda',
    'icon'  => 'fas fa-home',
    'link'  => 'dashboard.php'
  ],
  [
    'nama'  => 'Kriteria',
    'icon'  => 'fas fa-users-cog',
    'link'  => 'kriteria.php'
  ],
  [
    'nama'  => 'Karyawan',
    'icon'  => 'fas fa-users',
    'link'  => 'karyawan.php'
  ],
  [
    'nama'  => 'Laporan',
    'icon'  => 'fas fa-clipboard-list',
    'link'  => 'laporan.php'
  ]
];

// MENGETAHUI MENU AKTIF

// 1. ambil dan pecah url yg sedang aktif
$url = explode('/',apache_getenv("REQUEST_URI"));

// 2. pisahkan nilai method GET
$get = explode('?',$url[2]);

// 3. pisahkan ekstensi file
$ekstensi = explode('.',$get[0]);

// 4. pisahkan sub menu
$segment = explode('_',$ekstensi[0]);

// 5. rangkai menu yg aktif dg ekstensinya
$active = $segment[0].'.'.$ekstensi[1];
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

    <!-- My CSS -->
    <style>
      .card-kriteria:hover,
      .card-karyawan:hover,
      .card-laporan:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
      }
    </style>

    <title>SPK - AHP</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-md bg-success navbar-dark">
      <div class="container">
        
        <!-- Brand -->
        <a class="navbar-brand" href="dashboard.php">Skripsi</a>

        <!-- Toggler/collapsibe Button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
          <ul class="navbar-nav">

            <!-- menu -->
            <?php foreach($menu as $menu){ ?>
              <li class="nav-item <?php if($menu['link'] == $active){ echo 'active'; } ?>">
                <a class="nav-link" href="<?php echo $menu['link']; ?>">
                  <i class="<?php echo $menu['icon']; ?>"></i>
                  <?php echo $menu['nama']; ?>
                </a>
              </li>
            <?php } ?>

            <li class="nav-item">
              <a class="nav-link" href="logout.php" onclick="return confirm('Logout ?');">
                <i class="fas fa-sign-out-alt"></i>
                Logout
              </a>
            </li>

          </ul>
        </div>
      </div>
    </nav>
