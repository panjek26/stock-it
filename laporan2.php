<?php
include ("koneksi/koneksi.php");
session_start();
if(!isset($_SESSION['username'])) 
{
	include("login.php");
	exit;
}
$pengguna=$_SESSION['username'];

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Aplikasi Stok Barang</title>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="icon" href="favicon.ico" type="image/x-icon">

<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/datepicker3.css" rel="stylesheet">
<link href="css/bootstrap-table.css" rel="stylesheet">
<link href="css/styles.css" rel="stylesheet">

<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

</head>

<body>
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#"><span class="glyphicon glyphicon-signal"></span> E-Stock<span></span></a>
				<ul class="user-menu">
					<li class="dropdown pull-right">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span>
						<!-- ====================================================LOGIN -->
						<?php
						echo " $pengguna";
						?>
						<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="ganti-password.php"><span class="glyphicon glyphicon-user"></span> Ganti password</a></li>
							<!--<li><a href="#"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>-->
							<li><a href="login/aksilogout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>
							
		</div><!-- /.container-fluid -->
	</nav>
		
	<!--	
	==================================================== MENU
	-->
	<?php
	include("menu.php");
	?>	
	
	<!--	
	==================================================== MENU
	-->
		
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
				<li class="active">Laporan</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Out of Stock</h1>
			</div>
		</div><!--/.row-->
				
		
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<!--<div class="panel-heading"><a href="">Download Excel</a></div>-->
					<div class="panel-body">
						<table data-toggle="table" data-url="tables/data1.json"  data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="false" data-sort-name="name" data-sort-order="asc">
						    <thead>
						    <tr>
						        <!--<th data-field="no" data-sortable="true">No.</th>-->
								<th data-field="no" data-sortable="true">No</th>
						        <th data-field="idbarang"  data-sortable="true">ID Barang</th>
								<th data-field="namabarang"  data-sortable="true">Nama Barang</th>
						        <th data-field="satuan" data-sortable="true">Satuan</th>
								<!--<th data-field="gudang" data-sortable="true">Gudang</th>-->
								<th data-field="stok" data-sortable="true">Jumlah Stok</th>
							</tr>
							</thead>
							<tbody>
							
							<?php
//---------------------------------------------- INSERT TABLE ------------------------------------------------------
													
							if(substr($_SESSION['level'],0,6)=='gudang')
							{
								$sqlcari=mysqli_query($con,"select * from gudang where kode_gudang='$_SESSION[level]'");
								$dtcari=mysqli_fetch_array($sqlcari);
								$idgudang=$dtcari['id_gudang'];
								$sqlbarang="select b.id_barang, b.nama_barang,b.satuan, g.id_gudang, g.nama_gudang,sum(p.stok) as jumlah from barang b left join posisi p on b.id_barang=p.id_barang
								group by b.id_barang 
								having sum(p.stok) is null 
								and (p.id_gudang='$idgudang') 
								order by b.nama_barang asc";				
							
							}
							else
							{
								$sqlbarang="select b.id_barang, b.nama_barang,b.satuan, sum(p.stok) as jumlah from barang b left join posisi p on b.id_barang=p.id_barang
								group by b.id_barang 
								having sum(p.stok) is null
								order by b.nama_barang asc";				
											
							}
																					
							$querybarang=mysqli_query($con,$sqlbarang);
							$urut=1;
							while ($databarang=mysqli_fetch_array($querybarang))
							{
							$idbrg=$databarang['id_barang'];
							$namabrg=$databarang['nama_barang'];
							$satuan=$databarang['satuan'];														
							//$gudang=$databarang['nama_gudang'];														
							$stok=$databarang['jumlah'];
							echo '
							<tr>
						        <td data-field="no"  data-sortable="true">'.$urut.'</td>
								<td data-field="idbarang"  data-sortable="true">'.$idbrg.'</td>
								<td data-field="namabarang"  data-sortable="true">'.$namabrg.'</td>
						        <td data-field="satuan" data-sortable="true">'.$satuan.'</td>
								<!--<td data-field="gudang" data-sortable="true">'.$gudang.'</td>-->
								<td data-field="stok" data-sortable="true">'.$stok.'</td>
						    </tr>';
							
							$urut++;
							}
//---------------------------------------------- INSERT TABLE ------------------------------------------------------							
							?>
							
						    </tbody>
						</table>
					</div><!--
					<div class="panel-body"><span class="glyphicon glyphicon-download-alt"></span> <a href="download-stok.php">Download Excel</a></div>-->
				</div>
			</div>
		</div><!--/.row-->	
		<!--
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">Basic Table</div>
					<div class="panel-body">
						<table data-toggle="table" data-url="tables/data2.json" >
						    <thead>
						    <tr>
						        <th data-field="id" data-align="right">Item ID</th>
						        <th data-field="name">Item Name</th>
						        <th data-field="price">Item Price</th>
						    </tr>
						    </thead>
						</table>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">Styled Table</div>
					<div class="panel-body">
						<table data-toggle="table" id="table-style" data-url="tables/data2.json" data-row-style="rowStyle">
						    <thead>
						    <tr>
						        <th data-field="id" data-align="right" >Item ID</th>
						        <th data-field="name" >Item Name</th>
						        <th data-field="price" >Item Price</th>
						    </tr>
						    </thead>
						</table>
						<script>
						    $(function () {
						        $('#hover, #striped, #condensed').click(function () {
						            var classes = 'table';
						
						            if ($('#hover').prop('checked')) {
						                classes += ' table-hover';
						            }
						            if ($('#condensed').prop('checked')) {
						                classes += ' table-condensed';
						            }
						            $('#table-style').bootstrapTable('destroy')
						                .bootstrapTable({
						                    classes: classes,
						                    striped: $('#striped').prop('checked')
						                });
						        });
						    });
						
						    function rowStyle(row, index) {
						        var classes = ['active', 'success', 'info', 'warning', 'danger'];
						
						        if (index % 2 === 0 && index / 2 < classes.length) {
						            return {
						                classes: classes[index / 2]
						            };
						        }
						        return {};
						    }
						</script>
					</div>
				</div>
			</div>
		</div>--><!--/.row-->	
		
		
	</div><!--/.main-->

	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/chart.min.js"></script>
	<script src="js/chart-data.js"></script>
	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="js/bootstrap-table.js"></script>
	<script>
		!function ($) {
			$(document).on("click","ul.nav li.parent > a > span.icon", function(){		  
				$(this).find('em:first').toggleClass("glyphicon-minus");	  
			}); 
			$(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
		}(window.jQuery);

		$(window).on('resize', function () {
		  if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
		})
		$(window).on('resize', function () {
		  if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
		})
	</script>	
</body>

</html>
