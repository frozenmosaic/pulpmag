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


if (empty($search_text) || strlen($search_text)) {
    echo "Empty results";
}

