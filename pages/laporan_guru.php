<?php
			$id_periode = get_tahun_ajar_id();
			if(isset($_GET['idta'])){
				$id_periode = mysql_real_escape_string(htmlspecialchars($_GET['idta']));
			}

			$nip_user = $_SESSION[md5('user')];//'2012091200113504';
			

			$sql = "SELECT * FROM kelompok_penilaian";
			$q = mysql_query($sql);
			
			$sql = "SELECT * FROM penilai a JOIN penilai_detail b ON a.id_penilai = b.id_penilai WHERE a.nip = '$nip_user' ";
			$q = mysql_query($sql);
			$id_penilai_detail = '';
			$i=0;
			$id_penilai_detail = 0;
			while($row = mysql_fetch_array($q)){
				if($i==0){
					$id_penilai_detail .= $row['id_penilai_detail'];
				}else{
					$id_penilai_detail .= ", ".$row['id_penilai_detail'];
				}
				$i++;
			}
			$sql = "SELECT 
						tbnilai.nip_penilai,
						tbnilai.penilai,
						tbnilai.level,
						tbnilai.jabatan,
						SUM( IF(tbnilai.nama_kelpenilaian = 'Pedagogik', tbnilai.nilai, 0) ) AS 'Pedagogik',
						SUM( IF(tbnilai.nama_kelpenilaian = 'Kepribadian', tbnilai.nilai, 0) ) AS 'Kepribadian',
						SUM( IF(tbnilai.nama_kelpenilaian = 'Sosial', tbnilai.nilai, 0) ) AS 'Sosial',
						SUM( IF(tbnilai.nama_kelpenilaian = 'Profesional', tbnilai.nilai, 0) ) AS 'Profesional'
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
					WHERE 
					a.id_penilai_detail IN ($id_penilai_detail) 
					AND g.id_periode = $id_periode
					GROUP BY a.id_penilai_detail, c.id_kelpenilaian
					ORDER BY 4) as tbnilai
					GROUP BY tbnilai.penilai";
			//echo $sql;
			$q = mysql_query($sql);
			$nno = 0;
			echo "<br>";
			$tot_arr['atasan'] = 0;
			$tot_arr['guru'] = 0;
			$tot_arr['sendiri'] = 0;
			$tot_pedagodik = 0;
			$tot_kepribadian = 0;
			$tot_sosial = 0;
			$tot_profesional = 0;
			// while($row = mysql_fetch_array($q)){
			// 	$tot = 0;
			// 	$pg = ($row['Pedagogik']/10)*100;
			// 	$kp = ($row['Kepribadian']/5)*100;
			// 	$ss = ($row['Sosial']/4)*100;
			// 	$pr = ($row['Profesional']/5)*100;


			// 	$tot_pedagodik += $pg;
			// 	$tot_kepribadian += $kp;
			// 	$tot_sosial += $ss;
			// 	$tot_profesional += $pr;
			// 	/* prestasi kinerja individu */
			// 	$tot = ($pg*($tot_pedagodik/100)) + ($kp*($tot_kepribadian/100)) + ($ss*($tot_sosial/100)) + ($pr*($tot_profesional/100));

			// 	if($row['level']==2 || $row['level']==3){
			// 		$tot_arr['atasan'] += $tot;
			// 	}else if($row['level']==1 && $row['nip_penilai']!= $nip_user){
			// 		$tot_arr['guru'] += $tot;
			// 	}else{
			// 		$tot_arr['sendiri'] += $tot;
			// 	}
			// }
	
			$sql = "SELECT * FROM periode WHERE id_periode = $id_periode";
			$q = mysql_query($sql);
			$row = mysql_fetch_array($q);
			// if($row['setting']!=''){
			// 	$set = explode(";", $row['setting']);
				
			// 	$set[0] = $set[0]/100;
			// 	$set[1] = $set[1]/100;
			// 	$set[2] = $set[2]/100;
			// }else{
			// 	$set[0] = 0.5;
			// 	$set[1] = 0.3;
			// 	$set[2] = 0.2;
			// }

			// $ak = ($tot_arr['atasan']*$set[0]) + ($tot_arr['guru']*$set[1]) + ($tot_arr['sendiri']*$set[2]);
			//$ak = ($tot_arr['atasan']*0.5) + ($tot_arr['guru']*0.3) + ($tot_arr['sendiri']*0.2);			
		?>
		<script>
			<?php
				echo "var data_bar = [";
				echo "{oleh: 'Atasan', nilai: $tot_arr[atasan] },";
				echo "{oleh: 'Rekan Kerja', nilai: $tot_arr[guru] },";
				echo "{oleh: 'Diri Sendiri', nilai: $tot_arr[sendiri] }";
				echo "];";


				echo "var data_kompetensi = [";
				echo "{oleh: 'Pedagogik', nilai: ".number_format($tot_pedagodik / 6, 2)." },";
				echo "{oleh: 'Kepribadian', nilai: ".number_format($tot_kepribadian / 6, 2)." },";
				echo "{oleh: 'Sosial', nilai: ".number_format($tot_sosial / 6, 2)." },";
				echo "{oleh: 'Profesional', nilai: ".number_format($tot_profesional / 6, 2)." }";
				echo "];";
			?>
		</script>

<div class="container">
	<div class="row">
		<div class="col-8">
			<h1>Laporan Penilaian Kinerja DP3</h1>
			<h3>Periode <?= get_tahun_ajar($id_periode); ?></h3>
		</div>
		<div class="col-4">
			<br><br>
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
			  Rentang Nilai Akhir dan Keterangan
			</button>

			<!-- Modal -->
			<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			  <div class="modal-dialog modal-dialog-centered" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalCenterTitle">Rentang Nilai Akhir dan Keterangan</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			        <table class="table table-striped">
			        	  <thead class="thead-dark">
						    <tr>
						      <th scope="col">No</th>
						      <th scope="col">Rentang Nilai</th>
						      <th scope="col">Keterangan</th>
						    </tr>
						  </thead>
						  <tbody>
						    <tr>
						      <th scope="row">1</th>
						      <td>682 - 840</td>
						      <td>(A) Sangat Baik</td>
						    </tr>
						    <tr>
						      <th scope="row">2</th>
						      <td>525 - 681</td>
						      <td>(B) Baik</td>
						    </tr>
						    <tr>
						      <th scope="row">3</th>
						      <td>366 - 524</td>
						      <td>(C) Kurang</td>
						    </tr>
						    <tr>
						      <th scope="row">4</th>
						      <td>210 - 365</td>
						      <td>(D) Sangat Kurang</td>
						    </tr>
						  </tbody>
			        </table>
			      </div>
			    </div>
			  </div>
			</div>

		</div>
	</div>
	<hr/>
<!-- 	<div class="row">
		<div class="col">
			<table class="table">
			  <thead class="thead-dark">
			    <tr>
			      <th scope="col">#</th>
			      <th scope="col">First</th>
			      <th scope="col">Last</th>
			      <th scope="col">Handle</th>
			    </tr>
			  </thead>
			  <tbody>
			    <tr>
			      <th scope="row">1</th>
			      <td>Mark</td>
			      <td>Otto</td>
			      <td>@mdo</td>
			    </tr>
			</table>
		</div>
	</div> -->
	<div class="row">
		<div class="col-12">
			<form action="index.php?p=laporanpen" method="get" id="frm_ta">
				<div class="form-group">
					<select class="form-control cb_periode" name="idta">
	  					<?php
	  						$sql = "SELECT * FROM periode";
	  						$q = mysql_query($sql);
	  						while($row = mysql_fetch_array($q)){
	  							$sel = '';
	  							if(isset($_GET['idta'])){
	  								if($_GET['idta']==$row['id_periode']){
	  									$sel = 'selected';
	  								}
	  							}else{
	  								if($row['status_periode']==1){
	  									$sel = 'selected';
	  								}
	  							} 
	  							if($row['status_periode']==1){
	  								echo "<option value='$row[id_periode]' $sel >$row[tahun_ajar] $row[semester] (Aktif)</option>";
	  							}else{
	  								echo "<option value='$row[id_periode]' $sel >$row[tahun_ajar] $row[semester]</option>";
	  							}
	  						}
	  					?>
	  				</select>
				</div>
			</form>
			<hr>
		</div>
	</div>
	<div class="row">
		<div class="col-6">
			<div class="card">
			  	<div class="card-header bg-success">
			    	<p class="card-title text-white"><strong>Nilai Akhir</strong></p>
			  	</div>
			  	<div class="card-body">
			    	<div id="chart-nilai-akhir"></div>
			  	</div>
			</div>
		</div>
		<div class="col-6">
			<div class="card">
			  	<div class="card-header bg-primary">
			    	<p class="card-title text-white"><strong>Nilai Perwakilan</strong></p>
			  	</div>
			  	<div class="card-body">
			    	<div id="chart-nilai-perwakilan"></div>
			  	</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12" style="margin-top:20px">
			<div class="card">
			  	<div class="card-header bg-danger">
			    	<p class="card-title text-white"><strong>Nilai Perkompetensi</strong></p>
			  	</div>
			  	<div class="card-body">
			    	<div id="chart-nilai-perkompetensi"></div>
			  	</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" >
	var size = $("#chart-nilai-akhir").width()/2;//150,
    thickness = 60;

	//console.log(size);
	var color = d3.scaleLinear()
	    //.domain([0, 50, 100])
	    //.range(['#db2828', '#fbbd08', '#21ba45']);
	    .domain([0, 365, 524, 681, 840])
	    .range(['#db4639', '#FFCD42', '#48ba17', '#12ab24', '#0f9f59']);

	var arc = d3.arc()
	    .innerRadius(size - thickness)
	    .outerRadius(size)
	    .startAngle(-Math.PI / 2);

	var svg = d3.select('#chart-nilai-akhir').append('svg')
	    .attr('width', size * 2)
	    .attr('height', size + 20)
	    .attr('class', 'gauge');


	var chart = svg.append('g')
	    .attr('transform', 'translate(' + size + ',' + size + ')')

	var background = chart.append('path')
	    .datum({
	        endAngle: Math.PI / 2
	    })
	    .attr('class', 'background')
	    .attr('d', arc);

	var foreground = chart.append('path')
	    .datum({
	        endAngle: -Math.PI / 2
	    })
	    .style('fill', '#db2828')
	    .attr('d', arc);

	var value = svg.append('g')
	    .attr('transform', 'translate(' + size + ',' + (size * .9) + ')')
	    .append('text')
	    .text(0)
	    .attr('text-anchor', 'middle')
	    .attr('class', 'value');


	var kete = svg.append('g')
	    .attr('transform', 'translate(' + size + ',' + (size * 1.05) + ')')
	    .append('text')
	    .text(0)
	    .attr('text-anchor', 'middle')
	    .attr('class', 'nhuruf');

	var scale = svg.append('g')
	    .attr('transform', 'translate(' + size + ',' + (size + 15) + ')')
	    .attr('class', 'scale');

	scale.append('text')
	    .text(840)
	    .attr('text-anchor', 'middle')
	    .attr('x', (size - thickness / 2));

	scale.append('text')
	    .text(0)
	    .attr('text-anchor', 'middle')
	    .attr('x', -(size - thickness / 2));
	/*
	setInterval(function() {
	    update(Math.random() * 840);
	}, 1500);*/
	//update_gauge(500);
	update_gauge(<?= $ak; ?>);

	function update_gauge(v) {
	    v = d3.format('.1f')(v);
	    //console.log("update", v);
	    foreground.transition()
	        .duration(750)
	        .style('fill', function() {
	            return color(v);
	        })
	        .call(arcTween, v);

	    value.transition()
	        .duration(750)
	        .call(textTween, v);

	    kete.transition()
	        .duration(750)
	        .call(textKet, rentang(v));
	}

	function arcTween(transition, v) {
	    var newAngle = v / 840 * Math.PI - Math.PI / 2;
	    transition.attrTween('d', function(d) {
	        var interpolate = d3.interpolate(d.endAngle, newAngle);
	        return function(t) {
	            d.endAngle = interpolate(t);
	            return arc(d);
	        };
	    });
	}

	function textTween(transition, v) {
		//console.log(v);
	    transition.tween('text', function() {
	        var interpolate = d3.interpolate(this.innerHTML, v),
	            split = (v + '').split('.'),
	            round = (split.length > 1) ? Math.pow(10, split[1].length) : 1;
	        return function(t) {
	            this.innerHTML = d3.format('.1f')(Math.round(interpolate(t) * round) / round);
	        };
	    });
	}

	function textKet(transition, v) {
		//console.log(v);
	    transition.tween('text', function() {
	        var interpolate = d3.interpolate(this.innerHTML, v),
	            split = (v + '').split('.'),
	            round = (split.length > 1) ? Math.pow(10, split[1].length) : 1;
	        return function(t) {
	            this.innerHTML = v//d3.format('.1f')(Math.round(interpolate(t) * round) / round);
	        };
	    });
	}

	function rentang(v){
		v = Number(v);
		
		if(v<=840 && v>=682){
			return "Sangat Baik";
		}else if(v<=681 && v>=525){
			return "Baik";
		}else if(v<=524 && v>=366){
			return "Kurang";
		}else if(v<=365){
			return "Sangat Kurang";
		}else{
			return "#";
		}
	}
</script>

<script>

	var size_bar = $("#chart-nilai-perwakilan").width()/2;//150,
    thickness_bar = 60;
    margin = 10;
    bar_width = (size_bar * 2) - 2 * margin;
    bar_height = (size_bar + 2) - 1 * margin;

	var svg_bar = d3.select('#chart-nilai-perwakilan').append('svg')
	    .attr('width', size_bar * 2)
	    .attr('height', size_bar + 20)
	    .attr('class', 'bar');

    var chart_bar = svg_bar.append('g')
	    .attr('transform', 'translate(' + (margin+25) + ',' + margin + ')')

    var xScale = d3.scaleBand()
      	.range([0, bar_width])
      	.domain(data_bar.map((s) => s.oleh))
      	.padding(0.4)
    
    var yScale = d3.scaleLinear()
      	.range([bar_height, 0])
      	.domain([0, 1200]);


    var makeYLines = () => d3.axisLeft()
      	.scale(yScale)

    chart_bar.append('g')
      	.attr('transform', 'translate(0, '+bar_height+')')
      	.call(d3.axisBottom(xScale));

    chart_bar.append('g')
      	.call(d3.axisLeft(yScale));

    chart_bar.append('g')
      	.attr('class', 'grid')
      	.call(makeYLines()
        	.tickSize(-bar_width, 0, 0)
        	.tickFormat('')
      	)


    var barGroups = chart_bar.selectAll()
    	.data(data_bar)
      	.enter()
      	.append('g')

    barGroups
      	.append('rect')
      	.attr('class', 'bar_red')
      	.attr('x', function(g) { return xScale(g.oleh)})
      	.attr('width', xScale.bandwidth())
      	.on('mouseenter', mouseOver)
      	.on('mouseleave', mouseLeave)
      	.attr('y', function(g) { return yScale(0)})
      	.attr('height', function (g) { return bar_height - yScale(0)})
      	.transition()
         	.ease(d3.easeExp)
         	.duration(750)
         	.delay(function (g, i) {
         		//console.log(i+" "+yScale(g.nilai));
            	return i * 50;
         	})
      	.attr('y', function(g) { return yScale(g.nilai)})
      	.attr('height', function (g) { return bar_height - yScale(g.nilai)})
      	.attr("fill", function(g) {
          //['#db4639', '#FFCD42', '#48ba17', '#12ab24', '#0f9f59']
          var v = g.nilai;
          if(v>=682){
            return "#0f9f59";
          }else if(v>=525){
            return "#12ab24";
          }else if(v>=366){
            return "#48ba17";
          }else if(v>=201){
            return "#FFCD42";
          }else{
            return "#db4639";
          }  
        })

    barGroups 
      	.append('text')
      	.attr('class', 'value_bar')
      	.attr('x', (a) => xScale(a.oleh) + xScale.bandwidth() / 2)
       	.attr('y', (a) => yScale(a.nilai) + 30)
        .attr('fill', 'white')
      	.attr('text-anchor', 'middle')
      	.attr('opacity', 1)
      	.text((a) => a.nilai)


    function mouseOver(actual, i){
  		/*d3.selectAll('.value_bar')
          .attr('opacity', 0)*/

       /* d3.select(this)
          .transition()
          .duration(300)
          .attr('opacity', 0.6)
          .attr('x', (a) => xScale(a.oleh) - 5)
          .attr('width', xScale.bandwidth() + 10)
*/
       /* var y = yScale(actual.nilai)

        line = chart_bar.append('line')
          .attr('id', 'limit')
          .attr('x1', 0)
          .attr('y1', y)
          .attr('x2', bar_width)
          .attr('y2', y)

        barGroups.append('text')
          .attr('class', 'divergence')
          .attr('x', (a) => xScale(a.oleh) + xScale.bandwidth() / 2)
          .attr('y', (a) => yScale(a.nilai) + 30)
          .attr('fill', 'white')
          .attr('text-anchor', 'middle')
          .text((a, idx) => {
            var divergence = (a.nilai - actual.nilai).toFixed(1)
            
            var text = ''
            if (divergence > 0) text += '+'
            	text += ' '+divergence+' '
            text = a.nilai;
            return idx !== i ? text : '';
          })*/
    }

    function mouseLeave () {
    	/*d3.selectAll('.value_bar')
          .attr('opacity', 1)

        d3.select(this)
          .transition()
          .duration(300)
          .attr('opacity', 1)
          .attr('x', (a) => xScale(a.oleh))
          .attr('width', xScale.bandwidth())

        chart.selectAll('#limit').remove()
        chart.selectAll('.divergence').remove()*/
    }
</script>

<script>


	var size_bar = $("#chart-nilai-perkompetensi").width()/2;//150,
    thickness_bar = 60;
    margin = 30;
    bar_width = (size_bar * 2) - 2 * margin;
    bar_height = (size_bar + 2) - 1 * margin;

	var svg_bar = d3.select('#chart-nilai-perkompetensi').append('svg')
	    .attr('width', size_bar * 2)
	    .attr('height', size_bar + 20)
	    .attr('class', 'bar');

    var chart_bar = svg_bar.append('g')
	    .attr('transform', 'translate(' + margin + ',' + margin + ')')

    var xScale = d3.scaleBand()
      	.range([0, bar_width])
      	.domain(data_kompetensi.map((s) => s.oleh))
      	.padding(0.4)
    
    var yScale = d3.scaleLinear()
      	.range([bar_height, 0])
      	.domain([0, 400]);


    var makeYLines = () => d3.axisLeft()
      	.scale(yScale)

    chart_bar.append('g')
      	.attr('transform', 'translate(0, '+bar_height+')')
      	.call(d3.axisBottom(xScale));

    chart_bar.append('g')
      	.call(d3.axisLeft(yScale));

    chart_bar.append('g')
      	.attr('class', 'grid')
      	.call(makeYLines()
        	.tickSize(-bar_width, 0, 0)
        	.tickFormat('')
      	)


    var barGroups = chart_bar.selectAll()
    	.data(data_kompetensi)
      	.enter()
      	.append('g')


    barGroups
      	.append('rect')
      	.attr('class', 'bar')
      	//.attr('fill', 'red')
      	.attr('x', function(g) { return xScale(g.oleh)})
      	.attr('width', xScale.bandwidth())
      	.on('mouseenter', mouseOver)
      	.on('mouseleave', mouseLeave)
      	.attr('y', function(g) { return yScale(0)})
      	.attr('height', function (g) { return bar_height - yScale(0)})
      	.transition()
         	.ease(d3.easeExp)
         	.duration(750)
         	.delay(function (g, i) {
         		//console.log(i+" "+yScale(g.nilai));
            	return i * 50;
         	})
      	.attr('y', function(g) { return yScale(g.nilai)})
      	.attr('height', function (g) { return bar_height - yScale(g.nilai)})
      	.attr("fill", function(g) {
          //['#db4639', '#FFCD42', '#48ba17', '#12ab24', '#0f9f59']
          var v = g.nilai;
          if(v>=300){
            return "#0f9f59";
          }else if(v>=200){
            return "#12ab24";
          }else if(v>=100){
            return "#48ba17";
          }else if(v>=50){
            return "#FFCD42";
          }else{
            return "#db4639";
          }  
        })

    barGroups 
      	.append('text')
      	.attr('class', 'value_bar')
      	.attr('x', (a) => xScale(a.oleh) + xScale.bandwidth() / 2)
       	.attr('y', (a) => yScale(a.nilai) + 30)
        .attr('fill', 'white')
      	.attr('text-anchor', 'middle')
      	.attr('opacity', 1)
      	.text((a) => a.nilai)


    function mouseOver(actual, i){
  		/*d3.selectAll('.value_bar')
          .attr('opacity', 0)*/

       /* d3.select(this)
          .transition()
          .duration(300)
          .attr('opacity', 0.6)
          .attr('x', (a) => xScale(a.oleh) - 5)
          .attr('width', xScale.bandwidth() + 10)
*/
       /* var y = yScale(actual.nilai)

        line = chart_bar.append('line')
          .attr('id', 'limit')
          .attr('x1', 0)
          .attr('y1', y)
          .attr('x2', bar_width)
          .attr('y2', y)

        barGroups.append('text')
          .attr('class', 'divergence')
          .attr('x', (a) => xScale(a.oleh) + xScale.bandwidth() / 2)
          .attr('y', (a) => yScale(a.nilai) + 30)
          .attr('fill', 'white')
          .attr('text-anchor', 'middle')
          .text((a, idx) => {
            var divergence = (a.nilai - actual.nilai).toFixed(1)
            
            var text = ''
            if (divergence > 0) text += '+'
            	text += ' '+divergence+' '
            text = a.nilai;
            return idx !== i ? text : '';
          })*/
    }

    function mouseLeave () {
    	/*d3.selectAll('.value_bar')
          .attr('opacity', 1)

        d3.select(this)
          .transition()
          .duration(300)
          .attr('opacity', 1)
          .attr('x', (a) => xScale(a.oleh))
          .attr('width', xScale.bandwidth())

        chart.selectAll('#limit').remove()
        chart.selectAll('.divergence').remove()*/
    }	



</script>

<script type="text/javascript">
	$(document).ready(function(){
		$(".cb_periode").change(function(){
			//console.log("COKK");
			//$("#frm_ta").submit();	
			var idta = $(this).val();
			document.location="index.php?p=laporanpen&idta="+idta;
		});
    });
</script>	