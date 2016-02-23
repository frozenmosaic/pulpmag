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
$search_text = 'western';

$query =
        "SELECT *
        FROM metadata
        WHERE `title_j` = $search_text OR
            `pers_name` = $search_text OR
            `name` = $search_text OR
            `primary_genre` = $search_text OR
            `secondary_genre` = $search_text;
        ORDER BY `title_j`
    ";

    $exact = array();
    try {
        // echo $query;
        $stmt = $dbo->query($query);

        if ($stmt != false) {
            $exact = $stmt->fetchAll();
        }
    } catch (PDOException $e) {
        print_r($e->getMessage());
    }
    foreach ($exact as $row) {
        $search_result[] = $row;
    }

    // perform match anywhere
    $any   = array();
    $terms = explode(" ", $search_text);
    foreach ($terms as $value) {
        if (!empty($value)) {
            $query =
                "SELECT *
                FROM metadata
                WHERE title_j LIKE '%$value%' OR
                        pers_name LIKE '%$value%' OR
                        name LIKE '%$value%' OR
                        primary_genre LIKE '%$value%' OR
                        secondary_genre LIKE '%$value%'";
            try {
                $stmt = $dbo->query($query);
                if ($stmt != false) {
                    $any[] = $stmt->fetchAll();
                }
            } catch (PDOException $e) {
                print_r($e->getMessage());
            }
        }
    }

    foreach ($any as $row) {
        $search_result[] = $row;
    }

foreach ($search_result as $row ) {
print_r("<pre>");
print_r($row);
print_r("</pre>");
}


