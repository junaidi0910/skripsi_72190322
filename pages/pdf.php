<?php

require '../vendor/autoload.php';
require '../config/koneksi.php';
use iio\libmergepdf\Merger;
use Dompdf\Dompdf;
use Dompdf\Options;
$root = "http://".$_SERVER['HTTP_HOST'];
$root .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
    
    if(isset($_POST['unduh'])){
        
        $sql = "SELECT c.nama_ppa, c.nip, c.golongan, c.jabatan, c.unit_organisasi, d.jabatan as level, ROUND(AVG(a.hasil_nilai),2) as rata2, b.status, b.id_penilai, b.id_penilai_detail, b.status FROM penilaian a JOIN penilai_detail b ON b.id_penilai_detail = a.id_penilai_detail JOIN user c ON c.nip = b.nip JOIN jenis_user d ON d.id_jenis_user = c.id_jenis_user JOIN penilai e ON e.id_penilai = b.id_penilai WHERE b.id_penilai_detail = '". $_POST["nip_penilai"]."' AND e.nip = '". $_POST["nip_dinilai"]."' GROUP BY a.id_penilai_detail";
        $q = mysql_query($sql);
        $row = mysql_fetch_assoc($q);

        if($row["status"] != 3) {
			header("location:../index.php?p=home");
        }

        $id_penilaian_detail = $row['id_penilai_detail'];

        echo $id_penilaian_detail;

        $sqlz = "SELECT * FROM kelompok_penilaian WHERE nama_kelpenilaian != 'Rekan Kerja'";
        $qz = mysql_query($sqlz);
        $data_kompetensi = [];
        $no4 = 0;
        $i = 0;
        while($rowz = mysql_fetch_array($qz)){
            $data_kompetensi[$i]['id_kelpenilaian'] = $rowz['id_kelpenilaian'];
            $data_kompetensi[$i]['nama_kelpenilaian'] = $rowz['nama_kelpenilaian'];
            $i++;
        }

        foreach ($data_kompetensi as $k => $v) {
            $sql5 = "SELECT * FROM isi_penilaian a JOIN penilaian b ON b.id_isi = a.id_isi WHERE a.id_kelpenilaian = $v[id_kelpenilaian] AND b.id_penilai_detail = '$id_penilaian_detail'";
                                // echo $sq;
            $q5 = mysql_query($sql5);
            $banyak = mysqli_num_rows($q5);
            $no4 += $banyak;
        }
        $a = $no4 + 5;
        $b = $a-1;
        $idu="?nip_penilai=".$_POST["nip_penilai"]. "&nip_dinilai=".$_POST["nip_dinilai"];
        $data = file_get_contents($root."cetak_laporan.php".$idu);
        $data = str_replace('id="no4"','id="no4" rowspan="'. $a .'"',$data);
        $data = str_replace('id="keterangan"','id="keterangan" rowspan="'. $b .'"',$data);
        try{

            $options = new Options();
            $options->set('isJavascriptEnabled', TRUE);
            $options->set('isRemoteEnabled', TRUE);
            $dompdf = new Dompdf($options);
        $dompdf->load_html($data);

        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $tgl = date("dmy");
    
        $dompdf->stream("laporan_kinerja_".$tgl.".pdf", array("Attachment" => false));
        
    }catch(Exception $e){
        echo '<pre>',print_r($e),'</pre>';
    }
    }else{

        $m = new Merger();

        $data = file_get_contents($root."cetak_laporan.php");
        
        $dompdf = new Dompdf();
        $dompdf->loadHtml($data);

        $dompdf->setPaper('A4', 'potrait');
        $dompdf->render();
        $tgl = date("dmy");

        $pdf_arr = [];
        $pdf_arr[] = "laporan_kinerja_".$tgl.'.pdf';
        //file_put_contents($dompdf->output(), "laporan_kinerja_".$tgl.'pdf');
        
        $m->addRaw($dompdf->output());
        unset($dompdf);

        $sql = "SELECT
                    d.nip,
                    d.nama_ppa,
                    SUM(a.hasil_nilai) as nilai,
                    COUNT(a.id_nilai) as jml
                FROM penilaian a
                JOIN penilai_detail b ON a.id_penilai_detail = b.id_penilai_detail
                JOIN penilai c ON b.id_penilai = c.id_penilai
                JOIN user d ON c.nip = d.nip
                GROUP BY d.nip
                HAVING COUNT(a.id_nilai) = (
                                                SELECT 
                                                (
                                                    (SELECT COUNT(*) FROM penilai p
                                                    JOIN penilai_detail pd ON p.id_penilai = pd.id_penilai
                                                    WHERE p.nip = d.nip)
                                                    *
                                                    (SELECT COUNT(*) FROM isi_penilaian)
                                                ) as tot
                                                FROM dual
                                            )
                ORDER BY nilai DESC";
        $q = mysql_query($sql);
        while($row = mysql_fetch_array($q)){
            $idu="?detail=".$row['nip'];
            $data = file_get_contents($root."cetak_laporan.php".$idu);
        
            $dompdf = new Dompdf();
            $dompdf->loadHtml($data);

            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            $tgl = date("dmy");

            $pdf_arr[] = "laporan_kinerja_".$idu.'_'.$tgl.'pdf';
            //file_put_contents($dompdf->output(), "laporan_kinerja_".$idu.'_'.$tgl.'pdf');
            $m->addRaw($dompdf->output());
        
            unset($dompdf);
        }

        $pdf = file_put_contents("../laporan/laporan_kinerja_".$tgl.'.pdf', $m->merge());


        $file = "../laporan/laporan_kinerja_".$tgl.'.pdf';
        $filename = "laporan_kinerja_".$tgl.'.pdf';
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="' . $filename . '"');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($file));
        header('Accept-Ranges: bytes');
        @readfile($file);
       // exec('pdftk A=pdf1.pdf B=pdf2.pdf cat A1 B2 output combined.pdf');

    }
    
 /*   //echo $data;
    $dompdf = new Dompdf();
    $dompdf->loadHtml($data);

    // (Optional) Setup the paper size and orientation
    if(isset($_GET['detail'])){
        $dompdf->setPaper('A4', 'landscape');
    }else{
        $dompdf->setPaper('A4', 'potrait');
    }
    // Render the HTML as PDF
    $dompdf->render();
*/
    // Output the generated PDF to Browser
    
    
    /*$dompdf->stream("laporan_kinerja_".$tgl.'pdf', array("Attachment" => false));

    exit(0);*/
?>