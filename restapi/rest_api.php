<?php
error_reporting(0);
require 'koneksi.php';

if(!empty(isset($_GET['do'])))
{
	$do = $_GET['do'];

	if($do == "view")
	{
		$view = $conn->prepare("SELECT * FROM data ORDER BY id DESC");
		$view->execute();

		if($view->rowCount() <= 0)
		{
			header('HTTP/1.1 200 OK');
			header('Content-Type: application/json; charset=UTF-8');
			$json = json_encode(array(
					'result'=>false,
					'data'=>'Data kosong'
					));
			echo $json;
			exit();
		}

		if($view->rowCount() > 0)
		{
			$dataView = array();
			foreach($view as $row1)
			{
				$idbarang = $row1['id'];
				$namabarang = $row1['namabarang'];
				$jumlah = $row1['jumlah'];
				$hargaperunit = $row1['hargaperunit'];

				$dataView2 = [
						'idbarang'=>$idbarang,
						'namabarang'=>$namabarang,
						'jumlah'=>$jumlah,
						'hargaperunit'=>$hargaperunit
						];

				array_push($dataView, $dataView2);
			}

			header('HTTP/1.1 200 OK');
			header('Content-Type: application/json; charset=UTF-8');
			$json = json_encode(array(
					'result'=>true,
					'data'=>'Data ditemukan',
					'barang'=>$dataView
					));
			echo $json;
			exit();
		}
	}

	else if($do == "insert")
	{
		if(!empty(isset($_POST['namabarang'])) && !empty(isset($_POST['jumlah'])) && !empty(isset($_POST['hargaperunit'])))
		{
		$namabarang = $_POST['namabarang'];
		$jumlah = $_POST['jumlah'];
		$hargaperunit = $_POST['hargaperunit'];

		$insert = $conn->prepare("INSERT INTO data(namabarang, jumlah, hargaperunit) VALUES(:namabarang, :jumlah, :hargaperunit)");
		$insert->bindParam(':namabarang', $namabarang);
		$insert->bindParam(':jumlah', $jumlah);
		$insert->bindParam(':hargaperunit', $hargaperunit);
		$insert->execute();

		if($insert)
		{
			header('HTTP/1.1 200 OK');
			header('Content-Type: application/json; charset=UTF-8');
			$json = json_encode(array(
					'result'=>true,
					'data'=>'Data sukses ditambahkan'
					));
			echo $json;
			exit();
		}

		else
		{
			header('HTTP/1.1 200 OK');
			header('Content-Type: application/json; charset=UTF-8');
			$json = json_encode(array(
					'result'=>false,
					'data'=>'Data gagal ditambahkan'
					));
			echo $json;
			exit();
		}
		}

		else
		{
			header('HTTP/1.1 200 OK');
			header('Content-Type: application/json; charset=UTF-8');
			$json = json_encode(array(
					'result'=>false,
					'data'=>'Invalid Request'
					));
			echo $json;
			exit();
		}
	}

	else if($do == "delete")
	{
		if(!empty(isset($_GET['id'])))
		{
		$idbarang = $_GET['id'];

		$delete = $conn->prepare("DELETE FROM data WHERE id=:id");
		$delete->bindParam(':id', $idbarang);
		$delete->execute();

		if($delete)
		{
			header('HTTP/1.1 200 OK');
			header('Content-Type: application/json; charset=UTF-8');
			$json = json_encode(array(
					'result'=>true,
					'data'=>'Data sukses dihapus'
					));
			echo $json;
			exit();
		}

		else
		{
			header('HTTP/1.1 200 OK');
			header('Content-Type: application/json; charset=UTF-8');
			$json = json_encode(array(
					'result'=>false,
					'data'=>'Data gagal dihapus'
					));
			echo $json;
			exit();
		}
		}

		else
		{
			header('HTTP/1.1 200 OK');
			header('Content-Type: application/json; charset=UTF-8');
			$json = json_encode(array(
					'result'=>false,
					'data'=>'Invalid Request'
					));
			echo $json;
			exit();
		}
	}
}

else
{
	header('HTTP/1.1 200 OK');
	header('Content-Type: application/json; charset=UTF-8');
	$json = json_encode(array(
			'result'=>false,
			'data'=>'Invalid Request'
			));
	echo $json;
	exit();
}
?>