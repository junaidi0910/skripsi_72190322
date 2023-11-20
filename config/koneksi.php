<?php
require_once "parser-php-version.php";
	session_start();
	date_default_timezone_set('Asia/Jakarta');
	$host	= 'localhost';
	$user	= 'root';
	$pass	= '';
	$db		= '72190322_skripsi';
	
	if(mysql_connect($host, $user, $pass)){
		if(!mysql_select_db($db)){
			echo 'kesalahan koneksi database '.mysql_error();
		}
	}else{
		echo 'kesalahan server '.mysql_error();
	}

	$con=mysqli_connect($host, $user, $pass, $db);
	// Check connection
	if (mysqli_connect_errno()){
  		echo "Failed to connect to MySQL: " . mysqli_connect_error();
  	}

	function base_url($value='')
	{
		/*$root = "http://".$_SERVER['HTTP_HOST'];
        $root .= $_SERVER['REQUEST_URI'];*/
		$root = "http://".$_SERVER['HTTP_HOST'];
		$root .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
		$ve = explode("/", $value);
		if($ve=="." || $ve==".."){
			$re = explode("/", $root);
		}
        $root .= $value;
        return  $root;
	}


	function get_tahun_ajar($id="")
	{
		if($id!=''){
			$sql = "SELECT * FROM periode WHERE id_periode = $id";
		}else{
			$sql = "SELECT * FROM periode WHERE status_periode = 1";
		}
		$q = mysql_query($sql);
		$row = mysql_fetch_array($q);
		return $row['tahun_ajar']." ".$row['semester'];
	}


	function get_tahun_ajar_id()
	{
		$sql = "SELECT * FROM periode WHERE status_periode = 1";
		$q = mysql_query($sql);
		$row = mysql_fetch_array($q);
		return $row['id_periode'];
	}

	function get_tot_nilai($nip_user='', $id_periode='')
	{
		$sql = "SELECT 
					a.id_kelpenilaian,
					a.nama_kelpenilaian,
					a.bobot_kelpenilaian,
					COUNT(b.id_isi) as jml
				FROM kelompok_penilaian a
				JOIN isi_penilaian b ON a.id_kelpenilaian = b.id_kelpenilaian
				GROUP BY a.id_kelpenilaian";
		$q = mysql_query($sql);
		
		$data_kompetensi = [];

		while($row = mysql_fetch_array($q)){
			${"b_".$row['nama_kelpenilaian']} = $row['bobot_kelpenilaian'];
			${"jml_".$row['nama_kelpenilaian']} = $row['bobot_kelpenilaian'];
			$data_kompetensi[] = $row;
		}

		$sql = "SELECT * FROM penilai a JOIN penilai_detail b ON a.id_penilai = b.id_penilai WHERE a.nip = '$nip_user' ";
		$q = mysql_query($sql);
		$id_penilai_detail = '0';
		$i=0;
		while($row = mysql_fetch_array($q)){
			if($i==0){
				$id_penilai_detail = $row['id_penilai_detail'];
			}else{
				$id_penilai_detail .= ", ".$row['id_penilai_detail'];
			}
			$i++;
		}
		//$id_periode = get_tahun_ajar_id();
		$komp = '';
		foreach ($data_kompetensi as $key => $value) {
			$komp .= "SUM( IF(tbnilai.nama_kelpenilaian = '$value[nama_kelpenilaian]', tbnilai.nilai, 0) ) AS '$value[nama_kelpenilaian]', ";
		} 

		$sql = "SELECT 
					tbnilai.nip_penilai,
					tbnilai.penilai,
					tbnilai.level,
					tbnilai.jabatan,
					$komp
					1
				FROM 
				(SELECT 
					a.id_nilai, 
					h.nip as nip_dinilai,
					h.nama_ppa as 'dinilai',
					e.nip as nip_penilai, 
					e.nama_ppa as 'penilai',
					f.jabatan,
					f.level,
					c.id_kelpenilaian,
					c.nama_kelpenilaian,
					c.bobot_kelpenilaian,
					SUM(a.hasil_nilai) as nilai
				FROM penilaian a 
				JOIN isi_penilaian b ON a.id_isi = b.id_isi
				JOIN kelompok_penilaian c ON b.id_kelpenilaian = c.id_kelpenilaian
				JOIN (penilai_detail d JOIN user e ON d.nip = e.nip JOIN jenis_user f ON f.id_jenis_user = e.id_jenis_user) ON d.id_penilai_detail = a.id_penilai_detail 
				JOIN (penilai g JOIN user h ON g.nip = h.nip ) ON d.id_penilai = g.id_penilai
				WHERE a.id_penilai_detail IN ($id_penilai_detail) AND g.id_periode = $id_periode
				GROUP BY a.id_penilai_detail, c.id_kelpenilaian
				ORDER BY 4) as tbnilai
				GROUP BY tbnilai.penilai";
		//echo $sql;
		$q = mysql_query($sql);
		$nno = 0;
		$tot_arr['atasan'] = 0;
		$tot_arr['guru'] = 0;
		$tot_arr['sendiri'] = 0;
		while($row = mysql_fetch_array($q)){						
			$tot = 0;
			foreach ($data_kompetensi as $key => $value) {
				$nil = ($row[$value['nama_kelpenilaian']]/$value['jml'])*100; 
				
				$tot += $nil * ($value['bobot_kelpenilaian']/100);
			}

			if($row['level']==2 || $row['level']==3){
				$tot_arr['atasan'] += $tot;
			}else if($row['level']==1 && $row['nip_penilai']!= $nip_user){
				$tot_arr['guru'] += $tot;
			}else{
				$tot_arr['sendiri'] += $tot;
			}
		}

		$sql = "SELECT * FROM periode WHERE id_periode = $id_periode";
		$q = mysql_query($sql);
		$row = mysql_fetch_array($q);
		if($row['setting']!=''){
			$set = explode(";", $row['setting']);
			
			$set[0] = $set[0]/100;
			$set[1] = $set[1]/100;
			$set[2] = $set[2]/100;
		}else{
			$set[0] = 0.5;
			$set[1] = 0.3;
			$set[2] = 0.2;
		}


		$ak = ($tot_arr['atasan']*$set[0]) + ($tot_arr['guru']*$set[1]) + ($tot_arr['sendiri']*$set[2]);
		return number_format($ak, 2);		
	}

	// Cipher method
	global $ciphering, $iv_length, $options, $encryption_iv, $encryption_key;
	$ciphering = "AES-128-CTR";
	// Pakai OpenSSl Encryption method
	$iv_length = openssl_cipher_iv_length($ciphering);
	$options = 0;
	// Non-NULL Initialization Vector untuk enkripsi
	$encryption_iv = '1234567891011121';
	// Encryption key
	$encryption_key = "72190322";

	function enkripsiPassword($password) {
		global $ciphering, $iv_length, $options, $encryption_iv, $encryption_key;
		$password = openssl_encrypt($password, $ciphering, $encryption_key, $options, $encryption_iv);
		return $password;
	}

	function dekripsiPassword($password) {
		global $ciphering, $iv_length, $options, $encryption_iv, $encryption_key;
		$password = openssl_decrypt($password, $ciphering, $encryption_key, $options, $encryption_iv);
		return $password;
	}

?>