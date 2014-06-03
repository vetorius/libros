<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>
<body>
<?php
if ((isset($_GET['del'])) and ($_GET['del']==1)) {
	//borramos el archivo de log
	unlink('access.log');
	if (!$log_file = fopen('access.log','a')) {
		echo "No se puede abrir el archivo access.log";
		exit;
	}
	fclose($log_file);

}
$log_file = file_get_contents('access.log');
echo "<pre>" . $log_file . "</pre>";
?>
</body>
</html>
