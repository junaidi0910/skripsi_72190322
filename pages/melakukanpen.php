<style >

.container table {
  width: 100%;
  font-size: 1rem;
}

.container td, .container th {
  padding: 10px;
}

.container td:first-child, .container th:first-child {
  padding-left: 20px;
}

.container td:last-child, .container th:last-child {
  padding-right: 20px;
}

.container th {
  border-bottom: 1px solid #ddd;
  position: relative;
}

tr.bold > td{
    font-weight: bolder;
}

/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}

table, th, td {
  border: 1px solid black !important;
}

</style>

<script >

(function(document) {
    'use strict';

    var LightTableFilter = (function(Arr) {

        var _input;

        function _onInputEvent(e) {
            _input = e.target;
            var tables = document.getElementsByClassName(_input.getAttribute('data-table'));
            Arr.forEach.call(tables, function(table) {
                Arr.forEach.call(table.tBodies, function(tbody) {
                    Arr.forEach.call(tbody.rows, _filter);
                });
            });
        }

        function _filter(row) {
            var text = row.textContent.toLowerCase(), val = _input.value.toLowerCase();
            row.style.display = text.indexOf(val) === -1 ? 'none' : 'table-row';
        }

        return {
            init: function() {
                var inputs = document.getElementsByClassName('form-control');
                Arr.forEach.call(inputs, function(input) {
                    input.oninput = _onInputEvent;
                });
            }
        };
    })(Array.prototype);

    document.addEventListener('readystatechange', function() {
        if (document.readyState === 'complete') {
            LightTableFilter.init();
        }
    });

    })(document);

</script>

<div class="container">
    <div class="row">
        <?php

            if(!isset($_GET['id'])){
        ?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h2>Data PA/PPA yang dinilai</h2> <a class="float-right" title="Rubrik Penilaian" href="assets/file/rubrik.pdf"><i class="fa fa-file-pdf-o fa-2x"></i></a>
            <br>
            <table class="table">
                <thead>
                    <tr>
                        <td>No</td>
                        <td>NIP</td>
                        <td>Nama</td>
                        <td>Aksi</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i=0;
                        $nip_s = $_SESSION[md5('user')];
                        $sql = "SELECT a.id_penilai, a.nip, c.nama_ppa, b.id_penilai_detail, b.status, b.pesan FROM penilai a JOIN penilai_detail b  ON a.id_penilai = b.id_penilai
                                JOIN user c ON a.nip = c.nip WHERE b.nip = '$nip_s' ";
                                /*AND b.id_penilai_detail NOT IN(SELECT id_penilai_detail FROM penilaian)*/
                        // echo $sql;
                        $q = mysql_query($sql);
                        //if(mysql_num_rows($q)>0)
                        while($row = mysql_fetch_array($q)){
                    ?>
                    <tr class="<?= sudah($row['id_penilai_detail']); ?>">
                        <td><?= ++$i; ?></td>
                        <td><?= $row['nip']; ?></td>
                        <td><?= $row['nama_ppa']; ?></td>
                        <td>
                            <?php
                            $sql2 = "SELECT * FROM penilai a JOIN penilai_detail b ON a.id_penilai = b.id_penilai JOIN penilaian c ON b.id_penilai_detail = c.id_penilai_detail WHERE b.id_penilai_detail = ".$row['id_penilai_detail'];
                            $q2 = mysql_query($sql2);
                            if(mysql_num_rows($q2)==0 || $row['status'] == 1){  ?>
                            <a href="index.php?p=melakukanpen&id=<?= $row['id_penilai']; ?>" class="btn btn-success btn-sm">
                                <span class="fa fa-pencil fa-2x"></span> 
                            </a>
                            <?php } else { ?>
                            <button class="btn btn-secondary btn-sm" disabled>
                                <span class="fa fa-pencil fa-2x"></span> 
                            </button> 
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php }else{ ?>
        <?php
            $status = '';
            if(isset($_GET["idpenilai"])) {
                $ssql = "SELECT c.nama_ppa, c.nip, c.golongan, c.jabatan, c.unit_organisasi, d.jabatan, d.level, ROUND(AVG(a.hasil_nilai),2) as rata2, b.status, b.pesan, b.id_penilai, b.id_penilai_detail, d.id_jenis_user FROM penilaian a JOIN penilai_detail b ON b.id_penilai_detail = a.id_penilai_detail JOIN user c ON c.nip = b.nip JOIN jenis_user d ON d.id_jenis_user = c.id_jenis_user JOIN penilai e ON e.id_penilai = b.id_penilai WHERE b.id_penilai_detail = '". $_GET["idpenilai"]."' GROUP BY a.id_penilai_detail";
                $q = mysql_query($ssql);
                $rw = mysql_fetch_array($q);
                $status = $rw["status"];
                $sebagai = $rw['level']==3||$rw['level']==2?'0':($rw['level']==1?'1':($_GET["idpenilai"]==$rw['nip']?'2':''));
            } else {
                $nip_s = $_SESSION[md5('user')];
                $ssql = "SELECT * FROM user c JOIN jenis_user d ON c.id_jenis_user = d.id_jenis_user WHERE c.nip = '$nip_s'";
                $q = mysql_query($ssql);
                $rw = mysql_fetch_array($q);
                $sebagai = $rw['level']==3||$rw['level']==2?'0':($rw['level']==1?'1':($nip_s==$rw['nip']?'2':''));
            }
           
            $id_penilai = isset($_GET['id'])?mysql_real_escape_string(htmlspecialchars($_GET['id'])):"";
            $sql = "SELECT a.id_penilai, a.nip, b.id_jenis_user, b.nama_ppa, b.golongan, b.unit_organisasi, b.jabatan, d.pesan FROM penilai a JOIN user b ON a.nip = b.nip JOIN jenis_user c ON b.id_jenis_user = c.id_jenis_user JOIN penilai_detail d ON d.id_penilai = a.id_penilai AND d.nip = '".$rw["nip"]."' WHERE a.id_penilai = '$id_penilai'";
            // echo $sql;
            $q = mysql_query($sql);
            $row  = mysql_fetch_array($q);
            $pesan = $row["pesan"];
            $nama = $row['nama_ppa'];
            // echo $rw["nip"];
        ?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="row">
                <div class="col-lg-12 col-md-12 mb-4">
                    <h2>Penilaian Kinerja (DP3)</h2>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <table class="table">
                        <tr>
                            <td><strong>Nama Pemberi Nilai</strong></td>
                            <td>:</td>
                            <td> <?= $rw["nama_ppa"]; ?></td>
                        </tr>
                        <tr>
                            <td width="40%"><strong>NIP</strong></td>
                            <td width="1%">:</td>
                            <td> <?= $rw['nip']; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Pangkat, Golongan / ruang</strong></td>
                            <td>:</td>
                            <td> <?= $rw['golongan']; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Jabatan / Pekerjaan</strong></td>
                            <td>:</td>
                            <td> <?= $rw['jabatan']; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Unit Organisasi</strong></td>
                            <td>:</td>
                            <td> <?= $rw['unit_organisasi']; ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <table class="table">
                        <tr>
                            <td><strong>Nama yang Dinilai</strong></td>
                            <td>:</td>
                            <td> <?= $row['nama_ppa']; ?></td>
                        </tr>
                        <tr>
                            <td width="40%"><strong>NIP</strong></td>
                            <td width="1%">:</td>
                            <td> <?= $row['nip']; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Pangkat, Golongan / ruang</strong></td>
                            <td>:</td>
                            <td> <?= $row['golongan']; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Jabatan / Pekerjaan</strong></td>
                            <td>:</td>
                            <td> <?= $row['jabatan']; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Unit Organisasi</strong></td>
                            <td>:</td>
                            <td> <?= $row['unit_organisasi']; ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <form class="form-horizontal" method="post" action="modal/p_nilai.php">
            <div class="row mt-4">
                <div class="col-lg-7 col-sm-7">
                    <h2>UNSUR YANG DINILAI</h2>
                    <br>
                    <?php
                    $sqlx = "SELECT * FROM penilai a JOIN penilai_detail b  ON a.id_penilai = b.id_penilai WHERE a.nip = '".$row["nip"]."' AND b.nip = '".$rw["nip"]."' ";
                    // echo $row["nip"];
                    $qx = mysql_query($sqlx);
                    $rowx = mysql_fetch_array($qx);
            
                    $id_penilaian_detail = $rowx['id_penilai_detail'];
                    $sqly = "SELECT * FROM penilaian WHERE id_penilai_detail = $id_penilaian_detail ";
                    $qy = mysql_query($sqly);
                    ?>
                        <input type="hidden" name="nip_dinilai" value="<?= $row['nip']; ?>" >
                        <input type="hidden" name="nip_penilai" value="<?= $_SESSION[md5('user')]; ?>" >
                        <nav class="">
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <!-- <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Kompetensi Pedagogik</a>
                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Kompetensi Kepribadian</a>
                        <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Kompetensi Sosial</a>
                        <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contacti" role="tab" aria-controls="nav-contacti" aria-selected="false">Kompetensi Profesional</a>
                        --><?php 
                            if($row["id_jenis_user"] == $rw["id_jenis_user"]) {
                                $sql = "SELECT * FROM kelompok_penilaian WHERE nama_kelpenilaian = 'Rekan Kerja'";
                            } else {
                                $sql = "SELECT * FROM kelompok_penilaian WHERE nama_kelpenilaian != 'Rekan Kerja'";
                            }
                            $q = mysql_query($sql);
                            $i = 0;
                            $data_kompetensi = [];
                            while($row = mysql_fetch_array($q)){
                                $data_kompetensi[$i]['id_kelpenilaian'] = $row['id_kelpenilaian'];
                                $data_kompetensi[$i]['nama_kelpenilaian'] = $row['nama_kelpenilaian'];
                                if($i==0){
                        ?>
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-<?= $row['id_kelpenilaian']; ?>" role="tab" aria-controls="nav-home" aria-selected="true"><?= $row['nama_kelpenilaian']; ?></a>
                        <?php
                                }else{
                        ?>
                            <a class="nav-item nav-link" id="nav-home-tab" data-toggle="tab" href="#nav-<?= $row['id_kelpenilaian']; ?>" role="tab" aria-controls="nav-home" aria-selected="true"><?= $row['nama_kelpenilaian']; ?></a>
                        <?php 
                                }
                                $i++;
                            }
                        ?>
                        </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                        <?php
                        foreach ($data_kompetensi as $k => $v) {
                            if($k==0){
                                $ext = "show active";
                            }else{
                                $ext = "";
                            }
                        ?>
                            <div class="tab-pane fade <?= $ext;?>" id="nav-<?= $v['id_kelpenilaian']; ?>" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <table class="table table-striped mt-3">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="30%">isi penilaian</th>
                                            <th width="10%">Angka</th>
                                            <th width="10%">Sebutan</th>
                                            <!-- <th >1</th>
                                            <th >2</th>
                                            <th >3</th>
                                            <th >4</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $i=0;
                                            $tot = 0;
                                            if(isset($_GET["idpenilai"])) {
                                                $sq = "SELECT * FROM isi_penilaian a JOIN penilaian b ON b.id_isi = a.id_isi WHERE a.id_kelpenilaian = $v[id_kelpenilaian] AND b.id_penilai_detail = '". $_GET["idpenilai"] . "' AND a.ket LIKE '%$sebagai%' ";
                                            } else {
                                                $sq = "SELECT * FROM isi_penilaian WHERE id_kelpenilaian = $v[id_kelpenilaian] AND ket LIKE '%$sebagai%' ";
                                            }
                                            $sudahDinilai = mysql_num_rows($qy)>0;
                                            if($sudahDinilai){
                                                $sq = "SELECT * FROM isi_penilaian a JOIN penilaian b ON b.id_isi = a.id_isi WHERE a.id_kelpenilaian = $v[id_kelpenilaian] AND b.id_penilai_detail = '$id_penilaian_detail' AND a.ket LIKE '%$sebagai%' ";
                                            }
                                            // echo $sq;
                                            $qs = mysql_query($sq);
                                            $banyak = mysqli_num_rows($qs);
                                            while($row = mysql_fetch_array($qs)){
                                        ?>
                                        <tr>
                                            <td ><?= ++$i; ?></td>
                                            <td ><?= $row['isi_penilaian']; ?></td>
                                            <?php
                                            if(isset($_GET["idpenilai"]) || $sudahDinilai) { 
                                                if($row['hasil_nilai'] >= 91 && $row['hasil_nilai'] <= 100) {
                                                    $sebutan = 'Amat Baik';
                                                } else if ($row['hasil_nilai'] >= 76 && $row['hasil_nilai'] <= 90) {
                                                    $sebutan = 'Baik';
                                                } else if ($row['hasil_nilai'] >= 61 && $row['hasil_nilai'] <= 75) {
                                                $sebutan = 'Cukup Baik';
                                            } else if ($row['hasil_nilai'] >= 51 && $row['hasil_nilai'] <= 60) {
                                                $sebutan = 'Sedang';
                                            } else if ($row['hasil_nilai'] <= 50) {
                                                $sebutan = 'Kurang';
                                            } else {
                                                $sebutan = '';
                                            }    
                                            $tot += $row['hasil_nilai'];
                                        } 
                                        if(isset($_GET["idpenilai"])) { 
                                            ?>
                                                <td ><?= $row['hasil_nilai']; ?></td>
                                                <td id="kompetensi_<?= $row['id_isi']; ?>"><?= $sebutan; ?></td>
                                                <?php } else { ?>
                                                    <td><input type="number" name="nilai_kompetensi_<?= $row['id_isi']; ?>" id="nilai_kompetensi_<?= $row['id_isi']; ?>" style="width:50px;" class="angka angka_<?= $v['id_kelpenilaian']; ?>" <?php if($sudahDinilai) { ?>value="<?= $row['hasil_nilai']; ?>"<?php } ?>/></td>
                                                <td id="kompetensi_<?= $row['id_isi']; ?>"><?php if($sudahDinilai) { ?><?= $sebutan; ?><?php } ?></td>
                                            <?php } ?>
                                            <!-- <td class="form-group">
                                                <input class="form-control form-control-lg" type="radio" name="kompetensi_<?= $row['id_isi']; ?>" id="kompetensi_<?= $row['id_isi']; ?>_1" title="Tidak Mampu" value="1" required>
                                            </td>
                                            <td class="form-group">
                                                <input class="form-control form-control-lg" type="radio" name="kompetensi_<?= $row['id_isi']; ?>" id="kompetensi_<?= $row['id_isi']; ?>_2" title="Kurang Mampu" value="2" required>
                                            </td>
                                            <td class="form-group">
                                                <input class="form-control form-control-lg" type="radio" name="kompetensi_<?= $row['id_isi']; ?>" id="kompetensi_<?= $row['id_isi']; ?>_3" title="Mampu" value="3" required>
                                            </td>
                                            <td class="form-group">
                                                <input class="form-control form-control-lg" type="radio" name="kompetensi_<?= $row['id_isi']; ?>" id="kompetensi_<?= $row['id_isi']; ?>_4" title="Sangat Mampu" value="4" required>
                                                </td> -->
                                                </tr>
                                                <?php } 
                                                if($tot > 0) {
                                                    $rata2 = $tot/$i;
                                                } else {
                                                    $rata2 = 0;
                                                }
                                                ?>
                                    </tbody>
                                    </table>
                                    <table>
                                            <tr>
                                                <td width="25%"><b>Jumlah Nilai</b></td>
                                                <td width="5%" class=""><b>:</b></td>
                                                <td id="jumlah_nilai_<?= $v['id_kelpenilaian']; ?>" class="font-weight-bold"><?= $tot; ?></td>
                                            </tr>
                                            <tr>
                                                <td width="25%"><b>Nilai Rata-rata</b></td>
                                                <td width="5%" class=""><b>:</b></td>
                                            <td id="rata2_<?= $v['id_kelpenilaian']; ?>" class="font-weight-bold"><?= $rata2; ?></td>
                                        </tr>
                                </table>
                                </div>
                                <script type="text/javascript">
                                    $(".angka").keyup(function () {
                                        var arr = $('.angka_<?= $v['id_kelpenilaian']; ?>')
                                    var tot = 0;
                                    var avg = 0;
                                    
                                    for (var i = 0; i < arr.length; i++) {
                                        if (parseInt(arr[i].value))
                                        tot += parseInt(arr[i].value);
                                }
                                
                                avg = tot/arr.length;
                                
                                if(tot) {
                                        $('#jumlah_nilai_<?= $v['id_kelpenilaian']; ?>').html(tot);
                                        $('#rata2_<?= $v['id_kelpenilaian']; ?>').html(avg);
                                    } else {
                                        $('#jumlah_nilai_<?= $v['id_kelpenilaian']; ?>').html('0');
                                        $('#rata2_<?= $v['id_kelpenilaian']; ?>').html('0');
                                    }
                                });
                                </script>
                        <?php
                        }
                        ?>
                    </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 offset-lg-1 offset-sm-1">
                        <?php
                        $nip_s = $_SESSION[md5('user')];
                        $sql = "SELECT * FROM penilai a JOIN penilai_detail b ON a.id_penilai = b.id_penilai JOIN penilaian c ON b.id_penilai_detail = c.id_penilai_detail WHERE a.id_penilai = '$id_penilai' AND b.nip = '$nip_s'";
                        $q = mysql_query($sql);
                        if(mysql_num_rows($q)>0){
                            echo '<script>';
                            while($row = mysql_fetch_array($q)){
                                echo '$("#kompetensi_'.$row['id_isi'].'_'.$row['hasil_nilai'].'").attr("checked",true);';
                            }
                            echo '</script>';
                        }
                    ?>
                    <h2 class="text-center">KETERANGAN</h2>
                    <p>Nilai rata-rata adalah jumlah dibagi dengan jumlah unsur yang dinilai.</p>
                    <h2 class="text-center mt-5">NILAI SEBUTAN</h2>
                    <table cellspacing="0" class="no-spacing">
                        <tr>
                            <td width="30%" class="">91 - 100</td>
                            <td width="5%" class="">:</td>
                            <td class="">Amat Baik</td>
                        </tr>
                        <tr>
                            <td class="">76 - 90</td>
                            <td class="">:</td>
                            <td class="">Baik</td>
                        </tr>
                        <tr>
                            <td class="">61 - 75</td>
                            <td class="">:</td>
                            <td class="">Cukup Baik</td>
                        </tr>
                        <tr>
                            <td class="">51 - 60</td>
                            <td class="">:</td>
                            <td class="">Sedang</td>
                        </tr>
                        <tr>
                            <td class="">< 50</td>
                            <td class="">:</td>
                            <td class="">Kurang</td>
                        </tr>
                    </table>
                </div>
                <div class="container">
                    <br>
                    <?php if($status == '0') { ?>
                    </form>
                        <form class="form-horizontal" method="post" action="modal/p_nilai.php">
                            <input type="hidden" name="nip_penilai" value="<?= $rw['id_penilai_detail']; ?>" >
                            <input type="hidden" name="keberatan" value="<?= $_SESSION[md5('user')]; ?>" >
                            <span>Keberatan dari PA/PPA yang dinilai</span>
                            <input type="text" name="pesan" style="width: 50%">
                            <button type="submit" class="btn btn-danger btn-md">Ajukan Keberatan</button>
                        </form>
                    <?php } else { ?>
                        <?php if($pesan !== null) { ?>
                            <span class="alert alert-danger"><b>Pesan keberatan dari <?php echo $nama; ?>:</b> <?php echo $pesan ?></span>
                        <?php } ?>
                    <div class="float-right">
                        <br>
                        <button type="submit" class="btn btn-primary btn-md">Simpan</button>
                    </div>
                    <?php } ?>
                </div>
                <?php } ?>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
$(".angka").keyup(function () {
        let that = this,
        value = $(this).val();
        let id = $(this).attr('id');
        let result = id.substring(6);

        let sebutan;

        if(value >= 91 && value <= 100) {
            sebutan = 'Amat Baik';
        } else if (value >= 76 && value <= 90) {
            sebutan = 'Baik';
        } else if (value >= 61 && value <= 75) {
            sebutan = 'Cukup Baik';
        } else if (value >= 51 && value <= 60) {
            sebutan = 'Sedang';
        } else if (value <= 50) {
            sebutan = 'Kurang';
        } else {
            $(this).val('0');
            sebutan = '';
        }
        

        if(value) {
            $('#'+result).html(sebutan);
        } else {
            $('#'+result).html('');
        }
    });
</script>


<?php

    function sudah($idpdt=''){
        $sql = "SELECT * FROM penilai a JOIN penilai_detail b ON a.id_penilai = b.id_penilai JOIN penilaian c ON b.id_penilai_detail = c.id_penilai_detail WHERE b.id_penilai_detail = $idpdt";
        //echo $sql; 
        $q = mysql_query($sql);
        if(mysql_num_rows($q)>0){
            return 'bold';
        }else{
            return '';
        }
    }
?>