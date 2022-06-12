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
				<h1 class="page-header">Stock In</h1>
			</div>
		</div><!--/.row-->
				
		
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Stok masuk bulan <?php echo date("M Y"); ?></div>
					<div class="panel-body">
						<table data-toggle="table" data-url="tables/data1.json"  data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="tgl" data-sort-order="desc">
						    <thead>
						    <tr>
						        <th data-field="tgl" data-sortable="true">Tanggal</th>
						        <th data-field="nama"  data-sortable="true">Nama Barang</th>
								<th data-field="seater"  data-sortable="true">Satuan</th>
								<th data-field="kd_toko"  data-sortable="true">Kode Toko</th>
						        <th data-field="jenis" data-sortable="true">Alur</th>
								<th data-field="qty" data-sortable="true">Jumlah</th>
								<th data-field="ket" data-sortable="true">Keterangan</th>
								<th data-field="action">Action</th>
							</tr>
							</thead>
							<tbody>
							<?php
//---------------------------------------------- INSERT TABLE ------------------------------------------------------
							$sqltrx="select t.id_transaksi,t.tanggal_do,t.jenis_transaksi,t.id_barang,t.jumlah,t.keterangan,b.nama_barang,b.satuan,t.kd_toko from transaksi t, barang b where (t.id_barang=b.id_barang) and (month(t.tanggal_do)=month(now())) and (t.jenis_transaksi='Masuk') order by t.id_transaksi desc";				
							$querytrx=mysqli_query($con,$sqltrx);
							while ($datatrx=mysqli_fetch_array($querytrx))
							{
							echo '
							<tr>
						        <td data-field="tgl" data-sortable="true">'.$datatrx['tanggal_do'].'</td>
						        <td data-field="nama"  data-sortable="true">'.$datatrx['nama_barang'].'</td>
								 <td data-field="satuan"  data-sortable="true">'.$datatrx['satuan'].'</td>
								 <td data-field="kd_toko"  data-sortable="true">'.$datatrx['kd_toko'].'</td>
								<td data-field="jenis"  data-sortable="true">'.$datatrx['jenis_transaksi'].'</td>
						        <td data-field="qty" data-sortable="true">'.$datatrx['jumlah'].'</td>
								<td data-field="ket" data-sortable="true">'.$datatrx['keterangan'].'</td>
								<td data-field="action"><a href="edit-transaksi.php?idt='.$datatrx['id_transaksi'].'&idb='.$datatrx['id_barang'].'"><span class="glyphicon glyphicon-pencil" title="Edit keterangan"></a></td>
						    </tr>';
							}
//---------------------------------------------- INSERT TABLE ------------------------------------------------------							
							?>
							
							
						    </tbody>
						</table>
					</div>
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
