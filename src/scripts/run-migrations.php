<?php

$hostname = getenv('DB_HOST');
$database = getenv('DB_NAME');
$username = getenv('DB_USER');
$password = getenv('DB_PASSWORD');

if (!$hostname || !$database || !$username) {
    throw new RuntimeException("Variables de entorno DB_HOST, DB_NAME, DB_USER (y DB_PASSWORD) deben estar definidas.");
}

$hostParts = explode(':', $hostname, 2);
$hostOnly = $hostParts[0];
$port = isset($hostParts[1]) ? (int)$hostParts[1] : 3306;

$mysqliRoot = new mysqli($hostOnly, $username, $password, null, $port);
if ($mysqliRoot->connect_errno) {
    throw new RuntimeException("Error de conexión MySQL: " . $mysqliRoot->connect_error);
}
$mysqliRoot->set_charset('utf8mb4');

$createDbSql = "CREATE DATABASE IF NOT EXISTS `" . $mysqliRoot->real_escape_string($database) . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
if (!$mysqliRoot->query($createDbSql)) {
    throw new RuntimeException("Error creando base de datos: " . $mysqliRoot->error);
}
$mysqliRoot->close();

$mysqli = new mysqli($hostOnly, $username, $password, $database, $port);
if ($mysqli->connect_errno) {
    throw new RuntimeException("Error conectando a la BD específica: " . $mysqli->connect_error);
}
$mysqli->set_charset('utf8mb4');

function tableExists(mysqli $mysqli, string $table): bool {
    $safe = $mysqli->real_escape_string($table);
    $res = $mysqli->query("SHOW TABLES LIKE '$safe'");
    return $res && $res->num_rows > 0;
}

$tablesSql = [
    'users' => <<<SQL
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
SQL,
    'movies' => <<<SQL
CREATE TABLE IF NOT EXISTS `movies` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `year` INT UNSIGNED DEFAULT NULL,
  `genre` VARCHAR(100) DEFAULT NULL,
  `duration` INT UNSIGNED DEFAULT NULL,
  `director` VARCHAR(150) DEFAULT NULL,
  `actor1` VARCHAR(150) DEFAULT NULL,
  `actor2` VARCHAR(150) DEFAULT NULL,
  `actor3` VARCHAR(150) DEFAULT NULL,
  `actor4` VARCHAR(150) DEFAULT NULL,
  `actor5` VARCHAR(150) DEFAULT NULL,
  `country` VARCHAR(100) DEFAULT NULL,
  `age` TINYINT UNSIGNED DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `photo` VARCHAR(255) DEFAULT NULL,
  `link` VARCHAR(100) DEFAULT NULL,
  `score` DECIMAL(3,1) DEFAULT 0.0,
  `up_vote` INT UNSIGNED NOT NULL DEFAULT 0,
  `down_vote` INT UNSIGNED NOT NULL DEFAULT 0,
  `FECHA INS` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `FECHA ACT` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_genre` (`genre`),
  KEY `idx_year` (`year`),
  KEY `idx_country` (`country`),
  KEY `idx_director` (`director`),
  KEY `idx_score` (`score`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
SQL,
    'ads' => <<<SQL
CREATE TABLE IF NOT EXISTS `ads` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `adname` VARCHAR(150) NOT NULL,
  `url` VARCHAR(255) NOT NULL,
  `clicks` INT UNSIGNED NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_clicks` (`clicks`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
SQL,
    'views' => <<<SQL
CREATE TABLE IF NOT EXISTS `views` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `number` BIGINT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
SQL,
];

foreach ($tablesSql as $name => $sql) {
    if (!tableExists($mysqli, $name)) {
        if (!$mysqli->query($sql)) {
            throw new RuntimeException("Error creando tabla $name: " . $mysqli->error);
        }
    }
}

$res = $mysqli->query("SELECT id FROM users WHERE username='admin' LIMIT 1");
if ($res && $res->num_rows === 0) {
    $mysqli->query("INSERT INTO users (username,password) VALUES ('admin','admin')"); // TODO: cambiar a hash seguro
}

$res = $mysqli->query("SELECT id FROM views WHERE id=1");
if ($res && $res->num_rows === 0) {
    $mysqli->query("INSERT INTO views (id,number) VALUES (1,0)");
}

$res = $mysqli->query("SELECT id FROM ads LIMIT 1");
if ($res && $res->num_rows === 0) {
    $mysqli->query("INSERT INTO ads (adname,url,clicks) VALUES ('Patrocinado Ejemplo','example.jpg',0)");
}

$res = $mysqli->query("SELECT id FROM movies LIMIT 1");
if ($res && $res->num_rows === 0) {
    $title = $mysqli->real_escape_string('Película Ejemplo');
    $year = 2023; $genre = $mysqli->real_escape_string('Acción'); $duration = 120; $director = $mysqli->real_escape_string('Director Ejemplo');
    $actor1 = $mysqli->real_escape_string('Actor Uno');
    $actor2 = $mysqli->real_escape_string('Actor Dos');
    $actor3 = $mysqli->real_escape_string('Actor Tres');
    $actor4 = $mysqli->real_escape_string('Actor Cuatro');
    $actor5 = $mysqli->real_escape_string('Actor Cinco');
    $country = $mysqli->real_escape_string('España'); $age = 12; $description = $mysqli->real_escape_string('Descripción de ejemplo para la primera película.');
    $photo = $mysqli->real_escape_string('placeholder.svg'); $link = $mysqli->real_escape_string('dQw4w9WgXcQ');
    $score = 5.0; $upVote = 0; $downVote = 0;
    $insertSql = "INSERT INTO movies (title,year,genre,duration,director,actor1,actor2,actor3,actor4,actor5,country,age,description,photo,link,score,up_vote,down_vote,`FECHA INS`,`FECHA ACT`) VALUES ('$title',$year,'$genre',$duration,'$director','$actor1','$actor2','$actor3','$actor4','$actor5','$country',$age,'$description','$photo','$link',$score,$upVote,$downVote,NOW(),NOW())";
    if (!$mysqli->query($insertSql)) {
        throw new RuntimeException('Error insertando película seed: ' . $mysqli->error);
    }
}

$mysqli->close();

echo "Migraciones ejecutadas correctamente.\n";
