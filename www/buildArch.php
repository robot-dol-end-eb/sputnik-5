<?php 
	$host='localhost'; // имя хоста 
	$database='webtest'; // имя базы данных
	$user='root'; // имя пользователя
	$pswd=''; // пароль
	
	$dbh = mysql_connect($host, $user, $pswd) or die();
		mysql_select_db($database) or die();
		
	$dateFind = $_GET['date'];
	$elements = array();
	$pathname = "img/";
	$nameZip =  "archive.zip";

	$query = "SELECT * FROM testtable";
	$res = mysql_query($query); 
	while($row = mysql_fetch_array($res))
	{
		if($row[2]==$dateFind)
			array_push($elements,$row[1]);			
	}	
	
	function addZip($elements, $pathname, $nameZip){
		if(file_exists($pathname.$nameZip)) {
			unlink($pathname.$nameZip);
		}
		$zip = new ZipArchive();
		if($zip -> open($pathname.$nameZip,ZipArchive::CREATE)){
			foreach($elements as $element){
				$zip -> addFile($pathname.$element.".png");
			}

		}else{

		}
		$zip -> close();
	}
	addZip($elements, $pathname, $nameZip);
	
	
	function file_force_download($file) {
	if (file_exists($file)) {
		// сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
		// если этого не сделать файл будет читаться в память полностью!
		if (ob_get_level()) {
		  ob_end_clean();
		}
		// заставляем браузер показать окно сохранения файла
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename=' . basename($file));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));
		// читаем файл и отправляем его пользователю
		readfile($file);
		exit;
		}	
	}

	file_force_download($pathname. $nameZip);

?>










































