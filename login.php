<!DOCTYPE html>
<html>
<head>
	<title>
		Unit PSDM
	</title>
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/login.css" rel="stylesheet">
</head>
<body >
<?php
    require_once('config/koneksi.php'); 
    if(isset($_POST['nip'])){
      $nip = isset($_POST['nip'])?mysql_real_escape_string(htmlspecialchars($_POST['nip'])):"";
      $password = isset($_POST['password'])?enkripsiPassword(mysql_real_escape_string(htmlspecialchars($_POST['password']))):"";

      $sql = "SELECT * FROM user a JOIN jenis_user b ON a.id_jenis_user = b.id_jenis_user WHERE a.nip = '$nip' AND a.password = '$password'";
      $q = mysql_query($sql);
      $nr = mysql_num_rows($q);
      if($nr>0){
         $row = mysql_fetch_array($q);
         $nama = $row['nama_ppa'];
         $level = $row['level'];

         $_SESSION["flash"]["type"] = "success";
         $_SESSION["flash"]["head"] = "Login Berhasil";
         $_SESSION["flash"]["msg"] = "Selamat Datang $nama!";
         $_SESSION[md5('user')] = $row['nip']; 
         $_SESSION[md5('nama')] = $nama; 
         $_SESSION[md5('level')] = $level;
         if($level == 0){
            echo "<script>document.location='admin/index.php';</script>";
         }else{
            echo "<script>document.location='index.php';</script>";
         }
      }else{
         $_SESSION["flash"]["type"] = "danger";
         $_SESSION["flash"]["head"] = "Login Gagal";
         $_SESSION["flash"]["msg"] = "NIP/Password Salah!";
         echo "<script>document.location='login.php';</script>";
      }
   }
?>
	<div>
		<div class="sidenav">
         <div class="login-main-text">
            <img width="80%" height="80%" src="assets/img/LOGO UKDW WARNA PNG.png" >
            <h2>Unit Pengembangan Sumber Daya Manusia</h2>
         </div>
      </div>
      
      <div class="main">
         <div class="col-md-6 col-sm-12">
            <div class="card">
               <div class="card-body">
            <h3 class="card-title">DAFTAR PENILAIAN PELAKSANAAN PEKERJAAN (DP3)</h3>
            <form method="post">
               <div class="form-group">
                  <label for="nip">Nomor Induk Pegawai</label>
                  <input type="text" class="form-control" id="nip" name="nip" required placeholder="NIP">
               </div>
               <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" class="form-control" id="password" name="password" required placeholder="Password">
               </div>
               <button type="submit" class="btn btn-lg btn-primary">Login</button>
            </form>
         </div>
      </div>

   </div>
</div>

	</div>
   <?php if(isset($_SESSION["flash"])){ ?>
    <div class="alert alert-<?= $_SESSION["flash"]["type"]; ?> alert-dismissible alert_model" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <strong><?= $_SESSION["flash"]["head"]; ?></strong> <?= $_SESSION["flash"]["msg"]; ?>
    </div>
    <?php $_SESSION['tmp_count']+=1; } else{$_SESSION['tmp_count'] = 1;}
      if($_SESSION['tmp_count']>2){
        unset($_SESSION['flash']);
      }
     ?>

    <script type="text/javascript" src="assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.js"></script>

    <script type="text/javascript">
        setTimeout(function(){
            $(".alert").hide(500);
        }, 3000);
    </script>  
</body>
</html>