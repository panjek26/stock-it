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
	$date1_trans = date('Y-m', strtotime($date1. ' + 1 months'))."-01";
	$date2_trans = date('Y-m', strtotime($date1. ' + 1 months'))."-31";


if(substr($_SESSION['level'],0,6)=='gudang')
{
		$sqlcari=mysqli_query($con,"select * from gudang where kode_gudang='$_SESSION[level]'");
		$dtcari=mysqli_fetch_array($sqlcari);
		$idgudang=$dtcari['id_gudang'];
		$sql="";				
							
}
else
{
								$sql="select distinct a.id_barang,a.nama_barang,coalesce(a.stock_awal,0) as stock_awal,coalesce(b.stock_in,0) as stock_in,coalesce(c.stock_out,0) as stock_out,coalesce(a.stock_awal,0)+ coalesce(b.stock_in,0) - coalesce(c.stock_out,0)  as stock_akhir from (

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
}
#echo $sql;

//$sql="select nama_barang,satuan,stok from barang order by nama_barang asc";				

$Use_Title = 1;
$now_date = date('d-m-Y H:i');
$title = "LAPORAN LPP BARANG";

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
header("Content-Disposition: attachment; filename=laporan-LPP.$file_ending");
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
