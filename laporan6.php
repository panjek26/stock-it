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
<title>Aplikasi Stok Barang IT</title>
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
				<a class="navbar-brand" href="#"><span class="glyphicon glyphicon-signal"></span> Web Stock<span></span></a>
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
				<h1 class="page-header">Laporan LPP </h1>
			</div>
		</div><!--/.row-->

				
		
		<div class="row">
			<div class="col-lg-12">




				<div class="panel panel-default">
				</br>

	<div class="card mt-5">
			<div class="card-body mx-auto">
				<form method="POST" action="" class="form-inline mt-3">
					<label for="date1">Tanggal mulai &nbsp;</label>
					<input type="date" name="date1" id="date1" class="form-control mr-2" required>
					<label for="date2">sampai&nbsp;</label>
					<input type="date" name="date2" id="date2" class="form-control mr-2" required>
					<button type="submit" name="submit" class="btn btn-primary">Cari</button>
				</form>

			</div>
		</div>

					<!--<div class="panel-heading"><a href="">Download Excel</a></div>-->
					<div class="panel-body">
						<table data-toggle="table" data-url="tables/data1.json"  data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="false" data-sort-name="name" data-sort-order="asc">
						    <thead>
						    <tr>
						        <!--<th data-field="no" data-sortable="true">No.</th>-->
								<th data-field="no" data-sortable="true">No</th>
						        <th data-field="idbarang"  data-sortable="true">ID Barang</th>
								<th data-field="namabarang"  data-sortable="true">Nama Barang</th>
						        <th data-field="stockawal" data-sortable="true">Stock Awal</th>
								<th data-field="stokin" data-sortable="true">Stock In</th>
								<th data-field="stokout" data-sortable="true">Stock Out</th>
								<th data-field="stokalhir" data-sortable="true">Stock Akhir</th>
							</tr>
							</thead>
							<tbody>
							
							<?php
//---------------------------------------------- INSERT TABLE ------------------------------------------------------
if (isset($_POST['submit'])) {
	$date1 = $_POST['date1'];
	$date2 = $_POST['date2'];
	$date1_trans = date('Y-m', strtotime($date1. ' + 1 months'))."-01";
	$date2_trans = date('Y-m', strtotime($date1. ' + 1 months'))."-31";

													
							if(substr($_SESSION['level'],0,6)=='gudang')
							{
								$sqlcari=mysqli_query($con,"select * from gudang where kode_gudang='$_SESSION[level]'");
								$dtcari=mysqli_fetch_array($sqlcari);
								$idgudang=$dtcari['id_gudang'];
								$sqlbarang="";				
							
							}
							else
							{
								$sqlbarang="select distinct a.id_barang,a.nama_barang,coalesce(a.stock_awal,0) as stock_awal,coalesce(b.stock_in,0) as stock_in,coalesce(c.stock_out,0) as stock_out,coalesce(a.stock_awal,0)+ coalesce(b.stock_in,0) - coalesce(c.stock_out,0)  as stock_akhir from (

									select distinct a.id_barang,a.nama_barang,b.stok as stock_awal from barang a
									left join last_stock b
									on a.id_barang=b.id_barang
									where b.date_stock >= '$date1' and b.date_stock <= '$date2'
									) a

									left join

									(select t.tgl_transaksi as tgl_masuk,t.id_barang,sum(t.jumlah) as stock_in,b.nama_barang,b.satuan
									from transaksi t left join 
									barang b
									on t.id_barang=b.id_barang where t.jenis_transaksi='Masuk'
									and t.tgl_transaksi >= '$date1_trans'
									and t.tgl_transaksi <= '$date2_trans'
									group by t.id_barang,b.nama_barang,b.satuan) b
									on a.id_barang = b.id_barang

									left join

									(select t.tgl_transaksi as tgl_keluar,t.id_barang,sum(t.jumlah) as stock_out,b.nama_barang,b.satuan
									from transaksi t
									left join barang b
									on  t.id_barang=b.id_barang 
									where t.jenis_transaksi='Keluar'
									and t.tgl_transaksi >= '$date1_trans'
									and t.tgl_transaksi <= '$date2_trans'
									group by t.id_barang,b.nama_barang,b.satuan) c
									on a.id_barang = c.id_barang";				
											
							}
								
								#echo $sqlbarang;												
							$querybarang=mysqli_query($con,$sqlbarang);
							$urut=1;
							while ($databarang=mysqli_fetch_array($querybarang))
							{
							$idbrg=$databarang['id_barang'];
							$namabrg=$databarang['nama_barang'];
							#$satuan=$databarang['satuan'];														
							$stokawal=$databarang['stock_awal'];
							$stockin=$databarang['stock_in'];
							$stockout=$databarang['stock_out'];
							$stockakhir=$databarang['stock_akhir'];

							echo '
							<tr>
						        <td data-field="no"  data-sortable="true">'.$urut.'</td>
						        <td data-field="idbarang"  data-sortable="true">'.$idbrg.'</td>
								<td data-field="namabarang"  data-sortable="true">'.$namabrg.'</td>
						       	<td data-field="stokawal" data-sortable="true">'.$stokawal.'</td>
						    	<td data-field="stokin" data-sortable="true">'.$stockin.'</td>
						    	<td data-field="stokout" data-sortable="true">'.$stockout.'</td>
						    	<td data-field="stokakhir" data-sortable="true">'.$stockakhir.'</td>
						    </tr>';
							
							$urut++;
							}

	}						
//---------------------------------------------- INSERT TABLE ------------------------------------------------------							
							?>
							
						    </tbody>
						</table>
					</div>
					<form action="download-lpp.php" method="POST" target="_blank">
						<input type="hidden" name="date1" value="<?php echo $_POST['date1'] ?>"/>
						<input type="hidden" name="date2" value="<?php echo $_POST['date2'] ?>"/>
					   <button type="submit" name="submit" class="fa fa-download"> Download Excel</button>
						</form>
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
