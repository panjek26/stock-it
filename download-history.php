<?php
session_start();
include "koneksi/koneksi.php";

function mysqli_field_name($result, $field_offset)
{
    $properties = mysqli_fetch_field_direct($result, $field_offset);
    return is_object($properties) ? $properties->name : null;
}

if (isset($_POST['submit'])) {
	$date1 = $_POST['date1'];
	$date2 = $_POST['date2'];
	$barang = $_POST['barang'];


if (!empty($date1) && !empty($date2) && $barang=="ALL") {
									$sql="select 
									SUBSTRING_INDEX(t.kd_toko,'-',1) as kd_toko,
									SUBSTRING_INDEX(SUBSTRING_INDEX(t.kd_toko,'-',2), '-',-1) as nama_toko,

									t.id_transaksi,t.tgl_transaksi,t.tanggal_do,t.jenis_transaksi,t.id_barang,t.id_gudang,t.no_do,t.jumlah,t.keterangan,b.nama_barang,b.satuan,g.nama_gudang from transaksi t, barang b, gudang g where (t.id_barang=b.id_barang) and (t.id_gudang=g.id_gudang) 
									and t.tgl_transaksi >= '$date1' and t.tgl_transaksi <= '$date2 23:59:59'
   									order by t.id_transaksi desc limit 0,100";

							}else{
								$sql="select 
									SUBSTRING_INDEX(t.kd_toko,'-',1) as kd_toko,
									SUBSTRING_INDEX(SUBSTRING_INDEX(t.kd_toko,'-',2), '-',-1) as nama_toko,

									t.id_transaksi,t.tgl_transaksi,t.tanggal_do,t.jenis_transaksi,t.id_barang,t.id_gudang,t.no_do,t.jumlah,t.keterangan,b.nama_barang,b.satuan,g.nama_gudang from transaksi t, barang b, gudang g where (t.id_barang=b.id_barang) and (t.id_gudang=g.id_gudang) 
									and t.tgl_transaksi >= '$date1' and t.tgl_transaksi <= '$date2 23:59:59'
									and b.nama_barang='$barang'
   									order by t.id_transaksi desc limit 0,100";				
							}

						}elseif (substr($_SESSION['level'],0,6)=='gudang') {
						$sqlcari=mysqli_query($con,"select * from gudang where kode_gudang='$_SESSION[level]'");
						$dtcari=mysqli_fetch_array($sqlcari);
						$idgudang=$dtcari['id_gudang'];
						$sql="select t.tanggal_do,t.tgl_transaksi,b.nama_barang,b.satuan,t.jenis_transaksi, SUBSTRING_INDEX(t.kd_toko,'-',1) as kd_toko,
									SUBSTRING_INDEX(SUBSTRING_INDEX(t.kd_toko,'-',2), '-',-1) as nama_toko,g.nama_gudang,t.no_do,t.jumlah,t.keterangan from transaksi t, barang b, gudang g where (t.id_barang=b.id_barang) and (t.id_gudang=g.id_gudang) and (t.id_gudang=$idgudang) order by t.id_transaksi desc limit 0,100";
							
						}else{
							$sql="select t.id_transaksi,t.tanggal_do,t.tgl_transaksi,t.jenis_transaksi,t.id_barang, SUBSTRING_INDEX(t.kd_toko,'-',1) as kd_toko,
									SUBSTRING_INDEX(SUBSTRING_INDEX(t.kd_toko,'-',2), '-',-1) as nama_toko,t.id_gudang,t.no_do,t.jumlah,t.keterangan,b.nama_barang,b.satuan,g.nama_gudang from transaksi t, barang b, gudang g where (t.id_barang=b.id_barang) and (t.id_gudang=g.id_gudang) order by t.id_transaksi desc limit 0,100";	
						}

//$sql="select nama_barang,satuan,stok from barang order by nama_barang asc";				

$Use_Title = 1;
$now_date = date('d-m-Y H:i');
$title = "LAPORAN HISTORY TRANSAKSI";

//execute query

$result = mysqli_query($con,$sql);

$w=2;
if (isset($w) && ($w==1))
{
	$file_type = "msword";
	$file_ending = "doc";
}else {
	$file_type = "vnd.ms-excel";
	$file_ending = "xls";
}


header("Content-Type: application/$file_type");
header("Content-Disposition: attachment; filename=history-transaksi.$file_ending");
header("Pragma: no-cache");
header("Expires: 0");

/*	Start of Formatting for Word or Excel	*/

if (isset($w) && ($w==1)) //check for $w again
{
	/*	FORMATTING FOR WORD DOCUMENTS ('.doc')   */
	//create title with timestamp:
	if ($Use_Title == 1)
	{
		echo("$title\n\n");
	}
	//define separator (defines columns in excel & tabs in word)
	$sep = "\n"; //new line character

	while($row = mysqli_fetch_row($result))
	{
		//set_time_limit(60); // HaRa
		$schema_insert = "";
		for($j=0; $j<mysqli_num_fields($result);$j++)
		{
		//define field names
		$field_name = mysqli_field_name($result,$j);
		//will show name of fields
		$schema_insert .= "$field_name:\t";
			if(!isset($row[$j])) {
				$schema_insert .= "NULL".$sep;
				}
			elseif ($row[$j] != "") {
				$schema_insert .= "$row[$j]".$sep;
				}
			else {
				$schema_insert .= "".$sep;
				}
		}
		$schema_insert = str_replace($sep."$", "", $schema_insert);
		$schema_insert .= "\t";
		print(trim($schema_insert));
		//end of each mysqli row
		//creates line to separate data from each mysqli table row
		print "\n----------------------------------------------------\n";
	}
}else{
	/*	FORMATTING FOR EXCEL DOCUMENTS ('.xls')   */
	//create title with timestamp:
	if ($Use_Title == 1)
	{
		echo("$title\n");
	}
	//define separator (defines columns in excel & tabs in word)
	$sep = "\t"; //tabbed character

	//start of printing column names as names of mysqli fields
	for ($i = 0; $i < mysqli_num_fields($result); $i++)
	{
		echo mysqli_field_name($result,$i) . "\t";
	}
	print("\n");
	//end of printing column names

	//start while loop to get data
	while($row = mysqli_fetch_row($result))
	{
		//set_time_limit(60); // HaRa
		$schema_insert = "";
		for($j=0; $j<mysqli_num_fields($result);$j++)
		{
			if(!isset($row[$j]))
				$schema_insert .= "NULL".$sep;
			elseif ($row[$j] != "")
				$schema_insert .= "$row[$j]".$sep;
			else
				$schema_insert .= "".$sep;
		}
		$schema_insert = str_replace($sep."$", "", $schema_insert);
		$schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
		$schema_insert .= "\t";
		print(trim($schema_insert));
		print "\n";
	}
}

?>
