<?php
// print_r("<pre>");
// print_r($_POST);
// print_r("</pre>");
$search_type = $_POST['search_type'];
$search_text = $_POST['search_text'];
$operand     = $_POST['operand'];

$search_text = trim($search_text);
$search_terms = explode(" ", $search_text);

if ($search_type == "Search Full-text") {
    $group = "JOIN item ON page.item_id = item.item_uid
            JOIN issue ON item.issue_id = issue.issue_uid
            JOIN title ON issue.title_id = title.title_uid
            JOIN mod_stb ON page.text_uid = mod_stb.text_uid
            JOIN mod_std ON page.issue_id = mod_std.doc_uid
            JOIN mod_stg ON title.genre_p = mod_stg.mod_uid
            JOIN mod_snt ON page.text_uid = mod_snt.text_uid
            JOIN mod_tma ON page.text_uid = mod_tma.text_uid
            JOIN topic_clusters ON mod_tma.topic1 = topic_clusters.key_uid";

    if ($operand == "PHRASE") {
    	echo "Natural language search";
        // natural language mode
        $query =
            "SELECT *, substring(text, locate('sherlock', text)-450, 900) AS snippet
            FROM page $group2
            WHERE MATCH (text) AGAINST ('sherlock' IN NATURAL LANGUAGE MODE)
            AND text_charlen > 500
            LIMIT 0, 250";

    } else {
    	    	echo "boolean search";

        // boolean mode

        if ($operand == "AND") {
            $op = "+";
        } elseif ($operand == "OR") {
            $op = "";
        } elseif ($operand == "NOT") {
            $op = "-";
        }
        $search_str =
            "(MATCH(text) AGAINST (";

        foreach ($search_terms as $term) {
            $search_str .= "'" . $op . $term . "' ";
        }
        $search_str .= " IN BOOLEAN MODE)";

        $query =
            "SELECT *, " . $search_str .
            "AS relevance,
                substring(
                    text,
                    locate('$search_text', text)-440, 880
                ) AS snippet
                FROM page $group
                WHERE" . $search_str .
            "AND text_charlen > 500
                ORDER BY relevance DESC LIMIT 0, 250";
        print_r($query);
    }

    try {
        $stmt     = $dbo->query($query);
        $fulltext = $stmt->fetchAll();
    } catch (PDOException $e) {
        print_r($e->getMessage());
    }
    foreach ($fulltext as $row) {
        $search_result[] = $row;
    }

// $no = $search_result->rowCount();
    $no = 0;
    if ($no == 0) {
    	print_r("No results");
    } else {
        if ($no > 0) {

            foreach ($search_result as $row) {
            	print_r($row);
            }
        }
    }
}
