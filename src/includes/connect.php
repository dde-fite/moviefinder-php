<?php
$hostname	= getenv('DB_HOST');
$port		= getenv('DB_PORT') ?: 3306;
$database	= getenv('DB_NAME');
$username	= getenv('DB_USER');
$password	= getenv('DB_PASSWORD');

$enlace = @mysqli_connect($hostname, $username, $password, $database, $port);

if (!$enlace) {
	require_once __DIR__ . '/../scripts/run-migrations.php';
	$enlace = mysqli_connect($hostname, $username, $password, $database, $port);
}

if ($enlace) {
	$enlace->query("SET NAMES 'utf8'");
	$requiredTables = ['users','movies','ads','views'];
	$missing = [];
	foreach ($requiredTables as $tbl) {
		$safe = mysqli_real_escape_string($enlace,$tbl);
		$res = mysqli_query($enlace,"SHOW TABLES LIKE '$safe'");
		if (!$res || $res->num_rows === 0) {
			$missing[] = $tbl;
		}
	}
	if (!empty($missing)) {
		require_once __DIR__ . '/../scripts/run-migrations.php';
		$enlace = mysqli_connect($hostname, $username, $password, $database, $port);
		$enlace->query("SET NAMES 'utf8'");
	}
} else {
	echo "No se ha podido conectar y migraciones no resolvieron el problema.";
}

if (mysqli_connect_errno()) {
	echo "No se ha podido conectar: " . mysqli_connect_error();
}
?>