<?php 

global $dbo;

$info['dbhost_name'] = "localhost"; ///////////
$info['database']    = "pulpmag"; //////
$info['username']    = "root"; // userid//////
$info['password']    = "vy"; // passwordid/////
$dbConnString        = "mysql:host=" . $info['dbhost_name'] . "; dbname=" . $info['database'];

try {
    $dbo = new PDO($dbConnString, $info['username'], $info['password']);
    $dbo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);

}
catch (PDOException $e) {
    echo $e->getMessage();
}

$query = "SELECT * FROM `title` ORDER BY `title_uid` ASC";

foreach ($dbo->query($query) as $row) {
	echo $row['title_title_j'];
}