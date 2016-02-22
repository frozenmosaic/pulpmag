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

} catch (PDOException $e) {
    echo $e->getMessage();
}

$query_view = 
    "CREATE VIEW metadata as 
        SELECT `title`.*, `persons`.`name`, `publishers`.*
        FROM title, publishers, persons
        WHERE `title`.`person_id` = `persons`.`id` AND `title`.`publishers_id` = `publishers`.`id`";
$dbo->exec($query_view);
$search_text = 'sherlock';
$query =
        "SELECT * 
        FROM metadata
        AND `title`.`title_j` = $search_text OR
            `persons`.`name` = $search_text OR
            `publishers`.`name` = $search_text OR
            `title`.`primary_genre` = $search_text OR
            `title`.`secondary_genre` = $search_text;
        ORDER BY `title`.`title_j`
    ";
try {
    $res = $dbo->query($query);
} catch (PDOException $e) {
    print_r($e->getMessage());
}
// $res = $res->fetchAll();

// foreach ($res as $row) {
//     print_r("<pre>");
//     print_r($row);
//     print_r("</pre>");
// }
