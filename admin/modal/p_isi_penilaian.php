<?php
	include '../../config/koneksi.php';
	if(isset($_POST['btnSimpan'])){
		$btn = $_POST['btnSimpan'];
		
		$id_isi = isset($_POST['id_isi'])?mysql_real_escape_string(htmlspecialchars($_POST['id_isi'])):"";
		$id_kelpenilaian = isset($_POST['id_kelpenilaian'])?mysql_real_escape_string(htmlspecialchars($_POST['id_kelpenilaian'])):"";
		$isi_penilaian = isset($_POST['isi_penilaian'])?mysql_real_escape_string(htmlspecialchars($_POST['isi_penilaian'])):"";
		$ket = isset($_POST['ket'])?mysql_real_escape_string(htmlspecialchars($_POST['ket'])):"";
		$penilai = isset($_POST['penilai'])?mysql_real_escape_string(htmlspecialchars($_POST['penilai'])):"";


		if($btn=="Tambah"){
			$sql = "INSERT INTO isi_penilaian ( id_kelpenilaian, isi_penilaian, ket) VALUES('$id_kelpenilaian', '$isi_penilaian', '$penilai') ";
		}else{
			$sql = "UPDATE isi_penilaian SET id_kelpenilaian = '$id_kelpenilaian', isi_penilaian = '$isi_penilaian', ket = '$penilai' WHERE id_isi = '$id_isi'";
		}

		$query = mysql_query($sql);
		if($query){
			$_SESSION["flash"]["type"] = "success";
			$_SESSION["flash"]["head"] = "Sukses";
			$_SESSION["flash"]["msg"] = "Data berhasil disimpan!";
		}else{
			$_SESSION["flash"]["type"] = "danger";
			$_SESSION["flash"]["head"] = "Terjadi Kesalahan";
			$_SESSION["flash"]["msg"] = "Data gagal disimpan! ".mysql_error();
		}
		header("location:../index.php?p=misikom");
	}

	if(isset($_POST['btnDelete'])){
		$id_isi = isset($_POST['id_delete'])?mysql_real_escape_string(htmlspecialchars($_POST['id_delete'])):"";
		$sql = "DELETE  FROM isi_penilaian WHERE id_isi = $id_isi";
		$query = mysql_query($sql);
		if($query){
			$_SESSION["flash"]["type"] = "success";
			$_SESSION["flash"]["head"] = "Sukses";
			$_SESSION["flash"]["msg"] = "Data berhasil dihapus!";
		}else{
			$_SESSION["flash"]["type"] = "danger";
			$_SESSION["flash"]["head"] = "Terjadi Kesalahan";
			$_SESSION["flash"]["msg"] = "Data gagal dihapus! ".mysql_error();
		}
		header("location:../index.php?p=misikom");
	}

	if(isset($_GET['id_isi'])){
		$id_isi = isset($_GET['id_isi'])?mysql_real_escape_string(htmlspecialchars($_GET['id_isi'])):"";
		$sql = "SELECT * FROM isi_penilaian a JOIN kelompok_penilaian b ON a.id_kelpenilaian = b.id_kelpenilaian WHERE a.id_isi = $id_isi";
		$q = mysql_query($sql);
		$data = [];
		while ($row = mysql_fetch_assoc($q)) {
			$data = $row; 
		}
		echo json_encode($data);
	}

?>