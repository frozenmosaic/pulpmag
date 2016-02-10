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

?>
<html>

<!DOCTYPE>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Search</title>
        <link rel="stylesheet" type="text/css" href="page_files/search.css" />
        <style type="text/css">
    .form-submit {
        border: .25em double #EFCD38;
        color: #000000;
        background-color: #CC9900;
        font-family: Georgia, "Times New Roman", Times, serif;
        font-weight: bolder;}
    .formInput {
        color: #999999;
        background-color: #FFFF99;
        border: 0.25em double #CC9900;
        font-family: Georgia, "Times New Roman", Times, serif;}
    .formField {
        padding:1em;
        background-color: #FFCC00;
        border: 1px solid #666666;
        text-align:center;}
        </style>
        <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-25243590-1', 'auto');
  ga('send', 'pageview');

    </script>
    </head>
    <body>
        <div id="wrapper">
            <div class="header" id="header">
                <div align="left">
                    <a href="search.php" class="style46">[ SEARCH ]</a>
                    <span class="style49">[ FACSIMILE ]</span>
                    <a href="http://www.pulpmags.org/magazines.html" class="style5">[ Style ]</a>
                    <a href="http://www.pulpmags.org/cover_gallery.html" class="style5">[ Topic ]</a>
                    <a href="http://www.pulpmags.org/archives_hub.html" class="style5">[ Sentiment ]</a>
                    <a href="http://www.pulpmags.org/contexts_page.html" class="style5">[ NETWORK ]</a>
                    <a href="browse.php" method="post" name="q" value="browse" class="style46">[ BROWSE ]</a>
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
                        
                        <!-- // Displaying the METADATA search box  -->
                        <table width=99% align=center>
                            <form method=get action='results.php'>
                                <input type="hidden" name="q" value=metadata/>
                                <td valign=top align=center width=25%>
                                    <input type="text" size="50" name="search_text" value='$search_text'/>
                                </td>
                                <td valign=top align=center width=25%>
                                    <input type=radio name="type" value='MATCH ANY WHERE' checked/>Match any where
    
        
                                </td>
                                <td valign=top align=center width=25%>
                                    <input type=radio name="type" value='EXACT TERM MATCH'/>Exact term match
    
        
                                </td>
                                <td valign=top align=center width=25%>
                                    <input type=submit value='Search Metadata' class=form-submit/>
                                </td>
                            </form>
                        </table>
                        <!-- Displaying the FULLTEXT search box  -->
                        <table width=99% align=center>
                            <tr>
                                <td>
                                    <form method=get action='results.php'>
                                        <input type=hidden name="q" value=fulltext/>
                                        <td valign=top align=center width=25%>
                                            <br/>
                                            <input type=text size=50 name=search_text value='$search_text'/>
                                        </td>
                                        <td valign=bottom align=center width=25%>
                                            <input type=radio name=type value='NATURAL LANGUAGE MODE' checked/>Natural language
                
                                        </td>
                                        <td valign=bottom align=center width=25%>
                                            <input type=radio name=type value='BOOLEAN MODE'/>In Boolean mode
                
                                        </td>
                                        <td valign=top align=center width=25%>
                                            <br/>
                                            <input type=submit value='Search Full-Text' class=form-submit/>
                                        </td>
                                    </form>
                                </td>
                            </tr>
                        </table>
<?php

$todo        = isset($_GET['q']) ? $_GET['q'] : '';
$search_text = isset($_GET['search_text']) ? $_GET['search_text'] : '';

if (strlen($search_text) > 0) {
    if (!ctype_alnum($search_text)) {
        echo "Data Error";
        exit;
    }
}
?>
                        <table width=99% border=1 align=center cellpadding=3>
                            <tr style='font-weight:bold'>
                                <td>[ title_title_j ]</td>
                                <td>[ desc_format ]</td>
                                <td>[ desc_genre ]</td>
                                <td>[ ext_schedule ]</td>
                                <td>[ date_estab ]</td>
                                <td>[ role_editor ]</td>
                                <td>[ org_imprint ]</td>
                                <td>[ org_loc_addr ]</td>
                                <td>[ org_loc_city ]</td>
                                <td>[ org_loc_country ]</td>
                                <td>[ coh ]</td>
                                <td>[ ext ]</td>
                            </tr>
<?php 
$query="SELECT * FROM title ORDER BY title_uid ASC";
 
$rowColor = array(
    '2gw' => '#ffcc66',
    'adv' => '#fffbbb',
    'ams' => '#ffffff',
    'bed' => '#ffcc99',
    'bm'  => '#fffbbb',
    'dsm' => '#ffffff',
    'ico' => '#ffcc66',
    'liv' => '#FFFFFF',
    'lsm' => '#fffbbb',
    'nlt' => '#ffcc99',
    'ran' => '#ffcc66',
    'sau' => '#fffddd',
    'sma' => '#fffaaa',
    'wei' => '#ffcc77');

foreach ($dbo->query($query) as $row) { ?>    

                            <tr style="background-color:<?php echo $rowColor[$row['title_uid']]; ?>">
                            
                                <td>
                                    <a href='http://www.pulpmags.org/$row[title_url].html' target='_blank'>
                                        <em>
                                            <?php echo $row['title_title_j']; ?>
                                        </em>
                                    </a>
                                </td>
                                <td><?php echo $row['title_format_size'] . $row['title_format_paper']; ?></td>
                                <td><?php echo $row['genre_p']; ?></td>
                                <td><?php echo $row['title_pub_freq']; ?></td>
                                <td><?php echo $row['date_est']; ?></td>
                                <td><?php echo $row['title_pers_name']; ?></td>
                                <td><?php echo $row['title_imprint']; ?></td>
                                <td><?php echo $row['pub_add']; ?></td>
                                <td><?php echo $row['pub_city'] . $row['pub_stat']; ?></td>
                                <td><?php echo $row['pub_nat']; ?></td>
                                <td><?php echo $row['title_total_dig']; ?></td>
                                <td><?php echo $row['title_total_pub']; ?></td>
                            </tr>
                        
<?php } ?>
    </table>
                        <br>
                            <p align=center>Return to 
        
                                <a href=search.php>top</a> of the page.
    
                            </p>
                        </div>
                        <div class="c2" id="menu"></div>
                    </div>
                    <!-- End #content -->
                </div>
                <!-- End #wrapper -->
            </div>
            <!-- InstanceEnd -->
        </body>
    </html>
