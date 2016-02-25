
<?php
$type        = $_GET['type'];
    $search_text = trim($search_text);

    if ($type == "BOOLEAN MODE") {
        $query =
            "SELECT *,
            (   (1.3 * (MATCH(text) AGAINST ('+$search_text' IN BOOLEAN MODE))) +
                (0.6 * (MATCH(text) AGAINST ('+$search_text' IN BOOLEAN MODE)))
            ) AS score,
             substring(
                text,
                locate('$search_text', text)-440, 880
            ) AS snippet
            FROM page $group2
            WHERE (
                    MATCH(text) AGAINST ('+$search_text' IN BOOLEAN MODE)
                    )
            AND text_charlen > 500
            HAVING score > 0 ORDER BY score DESC LIMIT 0, 250";

    } elseif ($type == "NATURAL LANGUAGE MODE") {
        $query =
            "SELECT *, substring(text, locate('sherlock', text)-450, 900) AS snippet
            FROM page $group2
            WHERE MATCH (text) AGAINST ('sherlock' IN NATURAL LANGUAGE MODE)
            AND text_charlen > 500
            LIMIT 0, 250";
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
        ?>
    <br /><p align=center>No records matched your search.</p>";
    <p align=justify><span class=\"style17\"> \"" . $query . "\" </span></p>
<?php
} else {
        if ($no > 0) {
            ?>

    <table width=99% border=1 align=center cellpadding=1><tr style='background-color:#ffcc66'>
            <td><span class=style46>[relevance]</span></td>
            <td width=14.3%><span class=style46>[style scores]</span></td>
            <td width=7.2%><span class=style46>[topic models]</span></td>
            <td width=6%><span class=style46>[sentiment]</span></td>
            <td><span class=style46>[strpos match]</span> + <span class="style49">strpos</span> <span class="style48">MATCH ON</span> [" . $no . "] <span class=style19>OUT OF</span> [" . $bib . "] <span class=style46> [ ITEMS ]</span> + <span class=style19>page</span> <span class="style48">COUNT</span> of [" . $tps . "] + <span class="style49">strlen</span> <span class=\"style48\">COUNT</span> of [" . $twc . "].</td>
            <td align=right><span class=style46>[charlen]</span></td>
            <td width=5% align=right><span class=style46>[text models]</span></td>
            <td align=right><span class=style46>[ @FACS ]</span></td></tr>
<?php
$rowColor = array(
                '2gw' => '#fffddd',
                'adv' => '#fffbbb',
                'ams' => '#FFFFFF',
                'bed' => '#ffcc99',
                'bm'  => '#fffbbb',
                'dsm' => '#FFFFFF',
                'ico' => '#fffddd',
                'liv' => '#FFFFFF',
                'lsm' => '#fffbbb',
                'nlt' => '#fffddd',
                'ran' => '#fffbbb',
                'sau' => '#fffddd',
                'sma' => '#FFFFFF',
                'wei' => '#fffbbb');

            foreach ($search_result as $row) {
            }
        }
    }