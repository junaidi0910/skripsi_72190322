<?php if($_SESSION[md5('level')] == 3 || $_SESSION[md5('level')] == 2 ): ?>
<style >
	.jumbotron {
    	background: rgba(204, 204, 204, 0.5);
		padding: 20px;
	}
	.img-logo{
		width: 100px;
	}

</style>

<div class="jumbotron" >
  	<div class="container text-center">
  		<img src="assets/img/LOGO UKDW WARNA PNG.png" class="img-logo" >
    	<h3>Penilaian Kinerja DP3 UKDW</h3>
  	</div>
</div>

<?php

echo "<script>";
// tertinggi
$id_periode = get_tahun_ajar_id();
$sql = "SELECT
			d.nip,
			d.nama_ppa,
			SUM(a.hasil_nilai) as nilai,
			COUNT(a.id_nilai) as jml
		FROM penilaian a
		JOIN penilai_detail b ON a.id_penilai_detail = b.id_penilai_detail
		JOIN penilai c ON b.id_penilai = c.id_penilai
		JOIN user d ON c.nip = d.nip
		WHERE c.id_periode = $id_periode
		GROUP BY d.nip
		HAVING COUNT(a.id_nilai) = (
										SELECT 
										(
											(SELECT COUNT(*) FROM penilai p
											JOIN penilai_detail pd ON p.id_penilai = pd.id_penilai
											WHERE p.nip = d.nip)
											*
											(SELECT COUNT(*) FROM isi_kompetensi)
										) as tot
										FROM dual
									)
		ORDER BY nilai DESC
		";
$q = mysql_query($sql);
$i = 0;
echo "var data_tertinggi = [";
while($b = mysql_fetch_array($q)){
	$a[] = array('nilai' => get_tot_nilai($b['nip'], get_tahun_ajar_id()), 'nama_ppa' => $b['nama_ppa']);;
}
arsort($a);
//while($row = mysql_fetch_array($q)){
foreach ($a as $key => $row) {
	if($i<5){
		if($i==0){
			echo "{nama:'$row[nama_ppa]', nilai:$row[nilai]}";
		}else{
			echo ", {nama:'$row[nama_ppa]', nilai:$row[nilai]}";
		}
	}
	$i++;
}
echo "];";

echo "\n";
// terendah
$sql = "SELECT
			d.nip,
			d.nama_ppa,
			SUM(a.hasil_nilai) as nilai,
			COUNT(a.id_nilai) as jml
		FROM penilaian a
		JOIN penilai_detail b ON a.id_penilai_detail = b.id_penilai_detail
		JOIN penilai c ON b.id_penilai = c.id_penilai
		JOIN user d ON c.nip = d.nip
		WHERE c.id_periode = $id_periode
		GROUP BY d.nip
		HAVING COUNT(a.id_nilai) = (
										SELECT 
										(
											(SELECT COUNT(*) FROM penilai p
											JOIN penilai_detail pd ON p.id_penilai = pd.id_penilai
											WHERE p.nip = d.nip)
											*
											(SELECT COUNT(*) FROM isi_kompetensi)
										) as tot
										FROM dual
									)
		ORDER BY nilai ASC";
$q = mysql_query($sql);
$i = 0;
echo "var data_terendah = [";
$a = [];
while($b = mysql_fetch_array($q)){
	$a[] = array('nilai' => get_tot_nilai($b['nip'], get_tahun_ajar_id()), 'nama_ppa' => $b['nama_ppa']);;
}
asort($a);
foreach ($a as $key => $row) {
	if($i<5){
		if($i==0){
			echo "{nama:'$row[nama_ppa]', nilai:$row[nilai]}";
		}else{
			echo ", {nama:'$row[nama_ppa]', nilai:$row[nilai]}";
		}
	}
	$i++;
}
echo "];";
echo "\n";
echo "</script>";
?>

<script type="text/javascript" src="assets/plugins/canvas/canvasjs.min.js"></script>
<script type="text/javascript" src="assets/js/home.js"></script>


<script>
	var data_periode = [];
        var chart = new CanvasJS.Chart("chart-nilai-periode", {
            theme:"light2",
            animationEnabled: true,
            title:{
                text: "Nilai Per-periode"
            },
            axisY :{
                includeZero: false,
            	title: "Nilai",
            	valueFormatString: "###.##"
            },
            toolTip: {
                shared: "true"
            },
            legend:{
                cursor:"pointer",
                itemclick : toggleDataSeries
            },
            data: data_periode
        });

        chart.render();

        function toggleDataSeries(e) {
            if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible ){
            	e.dataSeries.visible = false;
            } else {
            	e.dataSeries.visible = true;
            }
            chart.render();
        }

        function ren(){
        	console.log("rem");
            chart.render();
        }
    
</script>

<script type="text/javascript">
	$(document).ready(function(){
		$(".cb_guru").change(function(){
    		var va = $(this).val();
			var url = "pages/chart_periode.php";
    		if(va!=""){
    			url = "pages/chart_periode.php?nip="+va;
    		}
    		console.log(url);
    		//data_periode = [{}];
    		$.getJSON(url, function(data) {  
			    $.each(data, function(key, value){
			        
			        var a = {
		    			type: value.type,
				      	visible: value.visible,
				      	showInLegend: value.showInLegend,
				      	yValueFormatString: value.yValueFormatString, 
						name: value.name, 
						dataPoints: value.dataPoints 
					}
		    		data_periode.push(a);
		    		//data_periode = a;
			    });
			    data_periode.splice(0,1);
				ren();
			});
			console.log(data_periode);
			
		});
	});
	$.getJSON("pages/chart_periode.php", function(data) {  
	    $.each(data, function(key, value){
	        
	        var a = {
    			type: value.type,
		      	visible: value.visible,
		      	showInLegend: value.showInLegend,
		      	yValueFormatString: value.yValueFormatString, 
				name: value.name, 
				dataPoints: value.dataPoints 
			}
    		data_periode.push(a);
	    });
	    ren();
	});

</script>
<?php else: ?>

<style >
	.jumbotron {
    background: rgba(204, 204, 204, 0.5);
}
</style>
<div class="jumbotron" >
  	<div class="container text-center">
  		<img width='100px' src="assets/img/LOGO UKDW WARNA PNG.png" >
    	<h1 class="display-4">Penilaian Kinerja DP3</h1>
  	</div>
</div>

<?php endif; ?>