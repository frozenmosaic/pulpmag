table width=99% border=1 align=center cellpadding=1><tr style='background-color:#ffcc66'>
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

            <tr style='background-color:" . $rowColor[$row['title_uid']] . "'>
    <td>$row[score]</td>
    <td>
        <span class=style48>P</span> $row[s_key_the], 
        <span class=style48>D</span> $row[d_key_the], 
        <span class=style48>G</span> $row[g_key_the]
        <br/>
        <span class=style48>P</span> $row[s_key_of], 
        <span class=style48>D</span> $row[d_key_of], 
        <span class=style48>G</span> $row[g_key_of]
        <br/>
        <span class=style48>P</span> $row[s_key_and], 
        <span class=style48>D</span> $row[d_key_and], 
        <span class=style48>G</span> $row[g_key_and]
        <br/>
        <span class=style48>P</span> $row[s_key_to], 
        <span class=style48>D</span> $row[d_key_to], 
        <span class=style48>G</span> $row[g_key_to]
        <br/>
        <span class=style48>P</span> $row[s_key_was], 
        <span class=style48>D</span> $row[d_key_was], 
        <span class=style48>G</span> $row[g_key_was]
        <br/>
        <span class=style48>P</span> $row[s_key_in], 
        <span class=style48>D</span> $row[d_key_in], 
        <span class=style48>G</span> $row[g_key_in]
    </td>
    <td>
        <span class=style48>$row[topic1]</span> ($row[topic1_w])
        <br/>
        <span class=style48>$row[topic2]</span> ($row[topic2_w])
        <br/>
        <span class=style48>$row[topic3]</span> ($row[topic3_w])
        <br/>
        <span class=style48>$row[topic4]</span> ($row[topic4_w])
        <br/>
        <span class=style48>$row[topic5]</span> ($row[topic5_w])
        <br/>
        <span class=style48>$row[topic6]</span> ($row[topic6_w])
    </td>
    <td>
        <span class=style49>$row[PosEmoteGeneral] P</span>
        <br/>$row[PosEmoteJest] C
        <br/>$row[NegEmoteSad] S
        <br/>$row[NegEmoteFear] F
        <br/>$row[NegEmoteAnger] A
        <br/>
        <span class=style56>$row[NegEmoteGeneral] N</span>
    </td>
    <td align=justify>
        <div class=topbox>
            <span class=style46>[Source]</span>: 
            <a href='http://www.pulpmags.org/$row[item_url]' target='_blank'>$row[item_title_m]
            </span>
        </a>, $row[item_pers_name],
            
        <a href='http://www.pulpmags.org/html/$row[issue_id].html' target='_blank'>
            <em>$row[title_title_j]</em>
        </a>; $row[issue_vol], $row[issue_no] ($row[issue_date], $row[issue_year]): $row[text_page_id]
    </div>
    <div class=box>
        <span class=style46>[Extract]</span>: ... $output ... 
    </div>
    <div class=botbox>
        <span class=style46>[Cluster]</span>: 
        <span class=style42>Topic $row[topic1] = 
            <strong>$row[topic]</strong> (relevance to page: 
            <strong>$row[topic1_w]</strong>, corpus: 
            <strong>$row[topicContrib]</strong>); Terms = $row[topicTermClust]
        </span>
    </div>
    <td>$row[text_charlen]</td>
    <td>
        <a href='http://www.pulpmags.org/pgs/$row[text_uid].txt' target='_blank'>Plain Text</a>
    </link>,
    <br/>
    <a href='http://www.pulpmags.org/mod/sa/$row[text_uid].html' target='_blank'>Annotated</a>
</link>undefined</td>undefined<td style='background-color:" . '#FFCC66' . "'>
<a href='http://www.pulpmags.org/$row[text_facsimage].jpg' target='_blank'>
    <img src='http://www.pulpmags.org/$row[text_thumbnail].jpg' alt='Link to Facsimile' style='width:150px;height:210px;border:1px solid black;padding:0.25px'/>
</a></td></tr>";
                
            </table>