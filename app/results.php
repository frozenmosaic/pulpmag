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
                </div>
            </div>
        </div>

<?php

$search_type = $_POST['search_type'];
$search_text = $_POST['search_text'];
$operand     = $_POST['operand'];

$search_text  = trim($search_text);
$search_terms = explode(" ", $search_text);

if (empty($search_text) || strlen($search_text) == 0) {
    echo "Empty results";
} else {

/**
 * search metadata
 */

    $search_result = array();
    if ($search_type == "Search Metadata") {
        // perform exact match
        $query =
            "SELECT *
        FROM metadata
        WHERE title_j = '$search_text' OR
            pers_name = '$search_text' OR
            name = '$search_text' OR
            primary_genre = '$search_text' OR
            secondary_genre = '$search_text'
        ORDER BY title_j ASC";

        $exact = array();
        try {
            $stmt = $dbo->query($query);
            if ($stmt != false) {
                $exact = $stmt->fetchAll();
            }
        } catch (PDOException $e) {
            print_r($e->getMessage());
        }

        $inserted_rec = array();
        foreach ($exact as $row) {
            $search_result[] = $row;
            $inserted_rec[]  = $row['title_id'];

        }

        // perform match anywhere
        $any = array();
        foreach ($search_terms as $value) {
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
                        $stmt = $stmt->fetchAll();
                        foreach ($stmt as $row) {
                            if (!in_array($row['title_id'], $inserted_rec)) {
                                $search_result[] = $row;
                            }
                        }
                    }
                } catch (PDOException $e) {
                    print_r($e->getMessage());
                }

            }
        }
    }
    ?>


<table width=99% border=1 align=center cellpadding=3>
    <tr style='font-weight:bold'>
        <td>[ journal_title ]</td>
        <td>[ format_paper ]</td>
        <td>[ genre_subgenre ]</td>
        <td>[ pub_schedule ]</td>
        <td>[ date_est ]</td>
        <td>[ pers_editor ]</td>
        <td>[ org_imprint ]</td>
        <td>[ loc_address ]</td>
        <td>[ city_state ]</td>
        <td>[ country_org ]</td>
        <td>[ coh ]</td>
        <td>[ ext ]</td>
    </tr>

    <?php
    foreach ($search_result as $row) {

        ?>
        <tr>
            <td>
                <a href='http://www.pulpmags.org/$row[title_url].html' target='_blank'>
                    <em><?php echo $row['title_j']; ?></em>
                </a>
            </td>
    <?php
$attributes = array(
            'primary_genre',
            'size_format',
            'paper_format',
            'frequency',
            'date_est',
            'name',
            'address',
            'city',
            'nation',
            'digitized_copy',
            'published_copy',
        );
        foreach ($attributes as $value) {
            echo "<td>" . $row[$value] . "</td>";
        }
        ?>

        </tr>
<?php
}
    ?>

</table>
<?php
if ($search_type == "Search Full-text") {
        $group = "page, item, issue, title
                WHERE page.issue_id = issue.uid";
        $group2 = "JOIN item ON page.item_id = item.item_uid
            JOIN issue ON item.issue_id = issue.issue_uid
            JOIN title ON issue.title_id = title.title_uid";
        // JOIN mod_stb ON page.text_uid = mod_stb.text_uid
        // JOIN mod_std ON page.issue_id = mod_std.doc_uid
        // JOIN mod_stg ON title.genre_p = mod_stg.mod_uid
        // JOIN mod_snt ON page.text_uid = mod_snt.text_uid
        // JOIN mod_tma ON page.text_uid = mod_tma.text_uid
        // JOIN topic_clusters ON mod_tma.topic1 = topic_clusters.key_uid

        if ($operand == "PHRASE") {
            // natural language mode
            $query =
                "SELECT *, substring(text, locate('$search_text', text)-450, 900) AS snippet
                FROM page $group2
                WHERE MATCH (text) AGAINST ('$search_text' IN NATURAL LANGUAGE MODE)
                AND text_charlen > 500
                LIMIT 0, 250";

        } else {
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
            $search_str .= " IN BOOLEAN MODE)) ";

            $query =
                "SELECT *, " . $search_str .
                "AS relevance,
                substring(
                    text,
                    locate('$search_text', text)-440, 880
                ) AS snippet
                FROM page
                WHERE" . $search_str .
                "AND text_charlen > 500
                ORDER BY 1 DESC LIMIT 0, 250";
            // print_r($query);
        }

        try {
            print_r($query);
            $stmt = $dbo->query($query);
            if ($stmt != false) {
                $fulltext = $stmt->fetchAll();
            }
        } catch (PDOException $e) {
            print_r($e->getMessage());
        }
        foreach ($fulltext as $row) {
            $search_result[] = $row;
        }

        $no = count($search_result);
        if ($no == 0) {
            print_r("No results");
        } else {
            if ($no > 0) {
                foreach ($search_result as $row) {
                    print_r("<pre>");
                    print_r($row);
                    print_r("</pre>");
                }
            }
        }
    }
}

?>
    </body>
    </html>

