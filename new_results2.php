<?php

global $dbo;

$info['dbhost_name'] = "localhost"; ///////////
$info['database']    = "pulpmag"; //////
$info['username']    = "root"; // userid//////
$info['password']    = "vy"; // passwordid/////
$dbConnString        = "mysql:host=" . $info['dbhost_name'] . "; dbname=" . $info['database'];

$dbo = new PDO($dbConnString, $info['username'], $info['password']);
$dbo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);

?>

<!DOCTYPE>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Results</title>
        <link rel="stylesheet" type="text/css" href="page_files/search.css" />
        <style type="text/css">
            .form-submit {
                border: .25em double #EFCD38;
                color: #000000;
                background-color: #CC9900;
                font-family: Georgia, "Times New Roman", Times, serif;
                font-weight: bolder;
                }
            .formInput {
                font-family: "Courier New", Courier, monospace;
                font-weight: lighter;
                background-color: #FFFF99;
                border: 0.25em double #CC9900;
                color: #000000;}
            .formField {
                background-color: #FFCC00;
                border: 0.2em double #666666;}
            </style>
        <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-25243590-1', 'auto');
  ga('send', 'pageview', '/results.php?q=keyword');

</script>
    </head>
    <body>
        <div id="wrapper">
            <div class="header" id="header">
                <div align="left">
                    <a href="search.php" class="style46">[ SEARCH ]</a>
                    <span class="style49">[ FACSIMILE ]</span>
                    <a href="http://www.pulpmags.org/magazines.html" class="style5">[ Style ]</a>
                    <a href="http://www.pulpmags.org/cover_gallery.html" class="style5"> [ Topic ]</a>
                    <a href="http://www.pulpmags.org/archives_hub.html" class="style5">[ Sentiment ]</a>
                    <a href="http://www.pulpmags.org/contexts_page.html" class="style5">[ NETWORK ]</a>
                    <!--Open Javascript Forcefield-->
                    <div class="toolkit" id="textractor">
                        <a href="tools/extract.php" target="_blank"></a>
                        <button class="toolkit-button" onclick="openwindow()">[ANALYSIS]</button>
                        <script>function openwindow() {window.open("tools/extract.php","cursor=zoom-out","object-position=1,-0.5");}</script>
                    </div>
                    <!--Close Javascript Forcefield-->
                </div>
                <div class="blurb" id="blurb">
                    <h2 align="center" class="c3">[ Full-Text Search and Data Modeling ]</h2>
                    <p align="center" class="c4">[
                        <span class="style50">Author</span> |
                        <span class="style50">Title</span> |
                        <span class="style50">Magazine</span> |
                        <span class="style50">Publisher</span> |
                        <span class="style50">Editor</span> |
                        <span class="style50">Keyword</span> ]
                    </p>
                    <p align="justify">Funded by grants from
                        <a href="http://www.mellon.org/" target="_blank">The Andrew W. Mellon Foundation</a> and
                        <a href="http://www.dickinson.edu/" target="_blank">Dickinson College</a>, this site features searchable text and bibliographic metadata for over
                        <strong>[ 300 ]</strong> American fiction magazines from the early twentieth century. It holds 30,000,000
                        <span class="style52">words</span>, distributed across 65,824 individual
                        <span class="style52">pages</span>, 87,744
                        <span class="style52">columns</span>, 818,192
                        <span class="style52">paragraphs</span>, and 3,821,280
                        <span class="style52">column lines</span>. It catalogs 9,904
                        <span class="style53">items</span> by 4,576
                        <span class="style53">authors</span>, including 7,230
                        <span class="style51">stories</span>, 495
                        <span class="style51">poems</span>, and 1,980
                        <span class="style51">items</span> of
                        <span class="style51">editorial matter</span>. There are also 7,254
                        <span class="style51">advertisements</span>. We are developing algorithms to search within the documents, compute patterns between them, and return cross-collection comparisons to identify clusters based on
                        <span class="style46">term frequencies</span>,
                        <span class="style46">topic modeling</span>,
                        <span class="style46">sentiment analysis</span>, and combinations of terms using
                        <span class="style46">Boolean operators</span>. For now a basic
                        <span class="style46">metadata search</span> will locate
                        <span class="style53">issues</span> by
                        <span class="style50">[TITLE]</span>,
                        <span class="style50">[PUBLISHER]</span>,
                        <span class="style50">[EDITOR]</span>, or primary
                        <span class="style50">[GENRE]</span>. The
                        <span class="style46">keyword search</span> is currently set to return individual
                        <span class="style53">items</span> by
                        <span class="style50">[TITLE]</span>, i.e., the
                        <span class="style51">stories</span>,
                        <span class="style51">poems</span>, and
                        <span class="style51">essays</span> within each magazine. And still under development, but functional, a classic
                        <span class="style46">full-text search</span> will match all
                        <span class="style53">pages</span> containing your
                        <span class="style50">[SEARCH TERMS]</span>.
                    </p>

<?php

$q           = $_GET['q'];
$search_text = $_GET['search_text'];

if (strlen($search_text) === 0) {
    if (!ctype_alnum($search_text)) {
        echo "<br><p align=center>Invalid term or combination of terms. Try a different keyword search.</p>";
    } else {

        // The Keyword Search Starts Here.
        if (isset($q) and $q == "keyword") {
            $type        = $_GET['type'];
            $search_text = trim($search_text);
            $group       = "JOIN issue ON item.issue_id = issue.issue_uid JOIN title ON issue.title_id = title.title_uid";

            if ($type == "REGULAR EXPRESSION") {
                $query = "SELECT * FROM item $group WHERE MATCH (item_title_m) AGAINST ('[[:<:]]/\b%$search_text(er|ing|ed|es|s)?\b/igm[[:>:]]') ORDER BY item_uid ASC";
            } else {
                $kt = explode(" ", $search_text);
                while (list($key, $val) = each($kt)) {
                    if ($val != " " and strlen($val) > 0) {
                        $query = " MATCH (item_title_m) AGAINST ('%$val%' WITH QUERY EXPANSION) OR ";
                    }
                }
                $query = substr($query, 0, (strLen($query) - 3));
                $query = "SELECT * FROM item $group WHERE $query";

            }
        }
        $count = $dbo->prepare($query);
        $count->execute();
        $rowColor = array(
            '2gw' => '#ffdf85',
            'adv' => '#fffbbb',
            'ams' => '#ffffff',
            'bed' => '#fffbbb',
            'bm'  => '#ffdf85',
            'dsm' => '#ffffff',
            'ico' => '#ffdf85',
            'liv' => '#FFFFFF',
            'lsm' => '#ffdf85',
            'nlt' => '#fffbbb',
            'ran' => '#ffdf85',
            'sau' => '#fffddd',
            'sma' => '#ffdf85',
            'wei' => '#fffaaa');
        $no = $count->rowCount();
        if ($no == 0) {
            echo "<br /><p align=center>No [" . $q . "] records matched \"" . $search_text . "\" using [ " . $type . " ]. Try a different keyword or combination of terms.</p><br />";
            echo "<p width=99% align=center>Your query was <span class=\"style17\"> \"" . $query . "\" </span>.</p>";
        } else {
            if ($no > 0) {
                echo "<br /><p align=center>Your [" . $q . "] search for \"" . $search_text . "\" using [ " . $type . " ] returned " . $no . " result(s).</p><br />";
                echo "<p width=99% align=center>Your query was <span class=\"style17\"> \"" . $query . "\" </span>.</p>";

                echo "<table width=99% border=1 align=center cellpadding=3>
            <tr class=style51>
            <td><span class=style46>[ magazine_title ]</span></td>
            <td><span class=style46>[ genre_market ]</span></td>
            <td><span class=style46>[ cataloged_item ]</span></td>
            <td><span class=style46>[ item_pers_name ]</span></td>
            <td><span class=style46>[ genre_lit ]</span></td>
            <td><span class=style46>[ net_centrality ]</span></td>
            <td><span class=style46>[ edition_volume ]</span></td>
            <td><span class=style46>[ edition_number ]</span></td>
            <td><span class=style46>[ date of issue ]</span></td><td><span class=style46>[ starts ]</span></td><td><span class=style46>[ ends ]</span></td>
            </tr>";
                foreach ($dbo->query($query) as $row) {
                    echo "<tr style='background-color:" . $rowColor[$row['title_uid']] . "'>
            <td><a href='http://www.pulpmags.org/html/$row[issue_id].html' target='_blank'>$row[title_title_j]</span></a></td>
            <td>$row[genre_p]</td><td><a href='http://www.pulpmags.org/$row[item_url]' target='_blank'>$row[item_title_m]</span></a></td>
            <td>$row[item_pers_name]</td>
            <td>$row[genre_l]</td>
            <td>$row[item_pers_role]</td>
            <td>$row[issue_vol]</td><td>$row[issue_no]</td><td>$row[issue_date], $row[issue_year]</td><td>$row[start_pp]</td><td>$row[end_pp]</td>
            </tr>";
                }
                echo "</table>";
            }

            if (isset($q) and $q == "metadata") {
                $type        = $_GET['type'];
                $search_text = trim($search_text);
// EXACT TERM MATCH
                if ($type != "MATCH ANY WHERE") {
                    $query = "SELECT * FROM title WHERE title_title_j='$search_text' OR title_pers_name='$search_text' OR title_imprint='$search_text' OR genre_p='$search_text' OR genre_s='$search_text' ORDER BY title_title_j ASC";
                } else {
                    $kt = explode(" ", $search_text);
                    while (list($key, $val) = each($kt)) {
                        if ($val != " " and strlen($val) > 0) {
                            $query = " title_title_j LIKE '%$val%' OR
                               title_pers_name LIKE '%$val%' OR
                               title_imprint LIKE '%$val%' OR
                               genre_p LIKE '%$val%' OR
                               genre_s LIKE '%$val%' OR ";
                        }
                    }
                    $query = substr($query, 0, (strLen($query) - 3));
                    $query = "SELECT * FROM title WHERE $query";
// MATCH ANY WHERE
                }
                $count = $dbo->prepare($query);
                $count->execute();
                $rowColor = array(
                    'romance'         => '#ffcc88',
                    'western'         => '#fffbbb',
                    'adventure'       => '#ffffff',
                    'detective'       => '#fffaaa',
                    'smart fiction'   => '#ffcc66',
                    'weird fiction'   => '#ffcc77',
                    'science fiction' => '#ffffee');
                $no = $count->rowCount();
                if ($no == 0) {
                    echo "<br /><p align=center>No [" . $q . "] records matched \"" . $search_text . "\" using [ " . $type . " ]. Try a different keyword or combination of terms.</p><br />";
                    echo "<p width=99% align=center>Your query was <span class=\"style17\"> \"" . $query . "\" </span>.</p>";
                } else {
                    if ($no > 0) {
                        echo "<br /><p align=center>Your [" . $q . "] search for \"" . $search_text . "\" using [ " . $type . " ] returned " . $no . " result(s).</p><br />";
                        echo "<p width=99% align=center>Your query was <span class=\"style17\"> \"" . $query . "\" </span>.</p>";
                        // Display Results
                        echo "<table width=99% border=1 align=center cellpadding=3>
            <tr style='font-weight:bold'><td>[ journal_title ]</td><td>[ format_paper ]</td><td>[ genre_subgenre ]</td><td>[ pub_schedule ]</td><td>[ date_est ]</td><td>[ pers_editor ]</td><td>[ org_imprint ]</td>
            <td>[ loc_address ]</td><td>[ city_state ]</td><td>[ country_org ]</td><td>[ coh ]</td><td>[ ext ]</td></tr>";
                        foreach ($dbo->query($query) as $row) {
                            echo "<tr style='background-color:" . $rowColor[$row['genre_p']] . "'><td><a href='http://www.pulpmags.org/$row[title_url].html' target='_blank'><em>$row[title_title_j]</em></a></td>
            <td>$row[title_format_size], $row[title_format_paper]</td><td>$row[genre_p], $row[genre_s]</td><td>$row[title_pub_freq]</td><td>$row[date_est]</td><td>$row[title_pers_name]</td>
            <td>$row[title_imprint]</td>
            <td>$row[pub_add]</td><td>$row[pub_city], $row[pub_stat]</td><td>$row[pub_nat]</td><td>$row[title_total_dig]</td><td>$row[title_total_pub]</td></tr>";
                        }
                        echo "</table>";
                    }
                }
            }

            if (isset($q) and $q == "fulltext") {
                $type        = $_GET['type'];
                $search_text = trim($search_text);
                $group2      = "JOIN item ON page.item_id = item.item_uid JOIN issue ON item.issue_id = issue.issue_uid JOIN title ON issue.title_id = title.title_uid
        JOIN mod_stb ON page.text_uid = mod_stb.text_uid JOIN mod_std ON page.issue_id = mod_std.doc_uid JOIN mod_stg ON title.genre_p = mod_stg.mod_uid
        JOIN mod_snt ON page.text_uid = mod_snt.text_uid JOIN mod_tma ON page.text_uid = mod_tma.text_uid JOIN topic_clusters ON mod_tma.topic1 = topic_clusters.key_uid";
// BOOLEAN MODE //////////////////////
                if (strlen($search_text) > 0) {
// <<<<<<< EXPLODE TERMS SHOULD BEGIN HERE >>>>>>>>> ////////////////////////////////////////////////////////////////////////////////////////////
                    if ($type != "NATURAL LANGUAGE MODE") {
                        $query = "SELECT *, ( (1.3 * (MATCH(text) AGAINST ('+$search_text' IN BOOLEAN MODE))) + (0.6 * (MATCH(text) AGAINST ('+$search_text' IN BOOLEAN MODE))) ) AS score,
            substring(text, locate('$search_text', text)-440, 880) AS snippet
                FROM page $group2
                WHERE ( MATCH(text) AGAINST ('+$search_text' IN BOOLEAN MODE) )
                AND text_charlen > 500
                HAVING score > 0 ORDER BY score DESC LIMIT 0, 250";
// NATURAL LANGUAGE MODE
                    } else {
                        $query = "SELECT *, MATCH (text) AGAINST ('$search_text' IN NATURAL LANGUAGE MODE) AS score, substring(text, locate('$search_text', text)-450, 900) AS snippet
                FROM page $group2
                WHERE ( MATCH (text) AGAINST ('$search_text' IN NATURAL LANGUAGE MODE) )
                AND text_charlen > 500
                HAVING score > 1.0 ORDER BY score DESC LIMIT 0, 250";
                    }
                }
            }
        }

        $count = $dbo->prepare($query);
        $count->execute();
        $no  = $count->rowCount();
        $bib = "523";
        $tps = "4,496";
        $twc = "2,695,515";

        if ($no === 0) {
            echo "<br /><p align=center>No [" . $q . "] records matched your search for \"" . $search_text . "\" in [ " . $type . " ]. Try a different search string or phrase combination.</p>";
            echo "<p align=justify><span class=\"style17\"> \"" . $query . "\" </span></p>";
        } else {
            if ($no > 0) {
                echo "<br /><p align=center>Your [" . $q . "] search for \"" . $search_text . "\" in " . $type . " returned " . $no . " result(s).</p>";
                echo "<p align=justify><span class=\"style17\"> \"" . $query . "\" </span></p>";
////////////// Display Results //////////////////////////// Display Results //////////////////////////// Display Results //////////////////////////// Display Results //////////////////////////// Display Results ///////////////
                echo "<table width=99% border=1 align=center cellpadding=1><tr style='background-color:#ffcc66'>
            <td><span class=style46>[relevance]</span></td>
            <td width=14.3%><span class=style46>[style scores]</span></td>
            <td width=7.2%><span class=style46>[topic models]</span></td>
            <td width=6%><span class=style46>[sentiment]</span></td>
            <td><span class=style46>[strpos match]</span> + <span class=\"style49\">strpos</span> <span class=\"style48\">MATCH ON</span> [" . $no . "] <span class=style19>OUT OF</span> [" . $bib . "] <span class=style46> [ ITEMS ]</span> + <span class=style19>page</span> <span class=\"style48\">COUNT</span> of [" . $tps . "] + <span class=\"style49\">strlen</span> <span class=\"style48\">COUNT</span> of [" . $twc . "].</td>
            <td align=right><span class=style46>[charlen]</span></td>
            <td width=5% align=right><span class=style46>[text models]</span></td>
            <td align=right><span class=style46>[ @FACS ]</span></td></tr>";

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

                foreach ($dbo->query($query) as $row) {
                    $output = str_ireplace($search_text, '<span class=style47>' . $search_text . '</span>', $row[trim('snippet')]);
                    echo "<tr style='background-color:" . $rowColor[$row['title_uid']] . "'>
            <td>$row[score]</td>
            <td>
            <span class=style48>P</span> $row[s_key_the], <span class=style48>D</span> $row[d_key_the], <span class=style48>G</span> $row[g_key_the]<br/>
            <span class=style48>P</span> $row[s_key_of], <span class=style48>D</span> $row[d_key_of], <span class=style48>G</span> $row[g_key_of]<br/>
            <span class=style48>P</span> $row[s_key_and], <span class=style48>D</span> $row[d_key_and], <span class=style48>G</span> $row[g_key_and]<br/>
            <span class=style48>P</span> $row[s_key_to], <span class=style48>D</span> $row[d_key_to], <span class=style48>G</span> $row[g_key_to]<br/>
            <span class=style48>P</span> $row[s_key_was], <span class=style48>D</span> $row[d_key_was], <span class=style48>G</span> $row[g_key_was]<br/>
            <span class=style48>P</span> $row[s_key_in], <span class=style48>D</span> $row[d_key_in], <span class=style48>G</span> $row[g_key_in]</td>

            <td><span class=style48>$row[topic1]</span> ($row[topic1_w])<br/> <span class=style48>$row[topic2]</span> ($row[topic2_w])<br/> <span class=style48>$row[topic3]</span> ($row[topic3_w])<br/> <span class=style48>$row[topic4]</span> ($row[topic4_w])<br/> <span class=style48>$row[topic5]</span> ($row[topic5_w])<br/> <span class=style48>$row[topic6]</span> ($row[topic6_w])</td>

            <td><span class=style49>$row[PosEmoteGeneral] P</span><br/>$row[PosEmoteJest] C<br/>$row[NegEmoteSad] S<br/>$row[NegEmoteFear] F<br/>$row[NegEmoteAnger] A<br/><span class=style56>$row[NegEmoteGeneral] N</span></td>

            <td align=justify><div class=topbox>
            <span class=style46>[Source]</span>: <a href='http://www.pulpmags.org/$row[item_url]' target='_blank'>$row[item_title_m]</span></a>, $row[item_pers_name],
            <a href='http://www.pulpmags.org/html/$row[issue_id].html' target='_blank'><em>$row[title_title_j]</em></a>; $row[issue_vol], $row[issue_no] ($row[issue_date], $row[issue_year]): $row[text_page_id]</div>
            <div class=box>
            <span class=style46>[Extract]</span>: ... $output ... </div>
            <div class=botbox>
            <span class=style46>[Cluster]</span>: <span class=style42>Topic $row[topic1] = <strong>$row[topic]</strong> (relevance to page: <strong>$row[topic1_w]</strong>, corpus: <strong>$row[topicContrib]</strong>); Terms = $row[topicTermClust]</span></div>

            <td>$row[text_charlen]</td>

            <td><a href='http://www.pulpmags.org/pgs/$row[text_uid].txt' target='_blank'>Plain Text</a></link>,<br/><a href='http://www.pulpmags.org/mod/sa/$row[text_uid].html' target='_blank'>Annotated</a></link></td>
            <td style='background-color:" . '#FFCC66' . "'><a href='http://www.pulpmags.org/$row[text_facsimage].jpg' target='_blank'>
            <img src='http://www.pulpmags.org/$row[text_thumbnail].jpg' alt='Link to Facsimile' style='width:150px;height:210px;border:1px solid black;padding:0.25px'/></a></td>
            </tr>";
                }
                echo "</table>";
            }}}}
?>
<br>
<p align=center>Return to the <a href=search.php>Search</a> page.</p><br/></div><div class="c2" id="menu"></div></div><!-- End #content --></div><!-- End #wrapper --></div><!-- InstanceEnd --></body></html>

    }
}