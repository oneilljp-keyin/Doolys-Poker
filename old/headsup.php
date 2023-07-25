<?PHP

 include("browser_detection.php");
 include("dates.php");
 $version = browser_detection('number');

 include("dbinfo.php");

// @mysql_connect($host,$username,$password);
// @mysql_select_db($database) or die("Unable to select database from point_entry.php");

 function sort_points($x, $y) {if ($x[2] == $y[2]) return 0; else if ($x[2] < $y[2]) return 1; else return -1;}

 $change_month = array("01" => "January ",   "02" => "February ", "03" => "March ",    "04" => "April ",
                       "05" => "May",        "06" => "June ",     "07" => "July ",     "08" => "August ",
                       "09" => "September ", "10" => "October ",  "11" => "November ", "12" => "December ");

 $change_month2 = array("01" => "Jan.",      "02" => "Feb.", "03" => "Mar.", "04" => "Apr.",
                        "05" => "May&nbsp;", "06" => "Jun.", "07" => "Jul.", "08" => "Aug.",
                        "09" => "Sep.",      "10" => "Oct.", "11" => "Nov.", "12" => "Dec.");

 $slash_replace = array("\"" => "&#34;", "'" => "&#39;", "," => "&#44;");

 $location_names = array("1" => "Topsail&nbsp;&nbsp;",
                         "2" => "Kenmount&nbsp;",
                         "3" => "Water St.");

 $location_names2 = array("1" => "Top",
                          "2" => "Ken",
                          "3" => "Wat");

 $tourn_types = array("1" => "<b class=\"sd\" >\$20 FO</b>",
                      "2" => "<b class=\"ecw\">\$20 RB</b>",
                      "3" => "<b class=\"raw\">\$40 RB</b>",
                      "4" => "<b>\$60 FO</b>",
                      "5" => "<b class=\"snme\">\$100 FO</b>",
                      "6" => "<b class=\"sd\">\$25 PLO</b>",
                      "7" => "<b class=\"snme\">\$40 FO</b>",
                      "9" => "<b class=\"snme\">\$50 FO</b>",
                     "10" => "<b>\$70 FO</b>",
                     "11" => "<b class=\"sd\">\$30 RB</b>",
                     "12" => "<b class=\"ecw\">\$50 6-MAX</b>",
                     "13" => "<b class=\"snme\">\$60 FO</b>",
                     "14" => "<b class=\"ecw\">\$60 6-MAX</b>",
                     "15" => "<b>\$75 FO</b>",
                      );

 $place_array = array("1" => "1<span class=\"superscript\">st</span>", "2" => "2<span class=\"superscript\">nd</span>", "3" => "3<span class=\"superscript\">rd</span>",
                      "4" => "4<span class=\"superscript\">th</span>", "5" => "5<span class=\"superscript\">th</span>", "6" => "6<span class=\"superscript\">th</span>",
                      "7" => "7<span class=\"superscript\">th</span>", "8" => "8<span class=\"superscript\">th</span>", "9" => "9<span class=\"superscript\">th</span>",
                     "10" => "10<span class=\"superscript\">th</span>", "0" => "--");

 $player_id1 = $_GET['id1'];
 $player_id2 = $_GET['id2'];
 $start_date = $_GET['start_date'];
 $end_date   = $_GET['end_date'];
 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php

 echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\"> \n";
 echo "<head>\n";
 echo "<link rel=\"stylesheet\" href=\"doolys.css\" type=\"text/css\" />\n";
 echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
 echo "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />\n";
 echo "<title>Heads-Up Stats - $player_id1 vs. $player_id1</title>\n";
 
 echo "<script type=\"text/javascript\">\n";
 echo "<!--\n";
 echo "function hilight(obj, Color) {\n";
 echo "    obj.style.backgroundColor = Color;\n";
 echo "}\n\n";
 echo "// -->\n";
 echo "</script>\n";

 echo "<style type=\"text/css\">\n";
?>

 <!--
  body {background-color: #FFFFFF;}
 -->
</style>

<?php
 echo "</head>\n";

 echo "<body>\n";
 echo "<center>\n";
 
 echo "<h2 style=\"color: #000000;\">Heads-Up Stats</h2>\n";

 echo "<table class=\"titles\" cellspacing=\"0\" cellpadding=\"1\" style=\"border-collapse: collapse;\">\n";
 echo "  <tr>\n";
 echo "    <td align=\"center\" style=\"width: 100px; border: 1px solid #909090;\"><b>$player_id1</b><br />FINISH:</td>\n";
 echo "    <td align=\"center\" style=\"width: 100px; border: 1px solid #909090;\">DATE:</td>\n";
 echo "    <td align=\"center\" style=\"width: 100px;  border: 1px solid #909090;\"><b>$player_id2</b><br />FINISH:</td>\n";
 echo "  </tr>\n";
 
 $final_tables = 0; $top3 = 0; $bubble_finish = 0; $cash_finish = 0;
 $split_check = 0;
 $first = 0; $second = 0;  $third = 0;  $fourth = 0;  $fifth = 0;
 $sixth = 0; $seventh = 0; $eighth = 0; $ninth = 0;   $tenth = 0;

 $multiplier = 1;
 $points     = 0;
 $k = 0;

 $player_result     = $conn->query(
                    "SELECT player_id, date, location, member, game_type, num_players, finish, bubble
                     FROM points
                     WHERE (player_id = '$player_id1' OR player_id = '$player_id2')
                      AND date >= '$start_date' AND date <= '$end_date'
                      AND (game_type = '10' OR game_type = '15' OR game_type = '4')
                     ORDER BY date ASC, player_id ASC");
 $actual_played = mysqli_num_rows($player_result);
 
 $date_check = "";
 $type_check = 0;
 $loc_check  = 0;
 $finish_check  = 0;
 $finish_check2 = 0;
 $non_finish = 0;
 
 $total_games = 0;
 
 $john_finish = 0;
 $rod_finish  = 0;
 $john_cash   = 0;
 $rod_cash    = 0;

 while ($rpr = $player_result->fetch_assoc()) {
   $date = $rpr['date'];
   $type = $rpr['game_type'];
   $loc  = $rpr['location'];
   $bub  = $rpr['bubble']; 
   if ($date == $date_check && $type == $type_check && $loc == $loc_check) {
     $total_games++;
     $finish = $rpr['finish']; if ($finish == 0) {$finish = 20;}  
                               if ($finish_check == 0) {$finish_check2 = 20;} else {$finish_check2 = $finish_check;}   
     if ($bubble_check <= 0) {$john_cash++;}   
     if ($bub <= 0) {$rod_cash++;}   
     if ($finish_check2 < $finish) {
       $john_finish++; 
     } else if ($finish_check2 > $finish) {
       $rod_finish++;      
     }
     echo "  <tr>\n";
     echo "    <td align=\"center\""; if ($finish_check2 < $finish) {echo " style=\"background-color: yellow;\"";} echo ">".strtr($finish_check, $place_array)."</td>\n";
     echo "    <td align=\"center\""; if ($finish_check2 == $finish) {echo " style=\"background-color: red;\""; $non_finish++;} echo ">$date_check</td>\n";
     echo "    <td align=\"center\""; if ($finish_check2 > $finish) {echo " style=\"background-color: yellow;\"";} echo ">".strtr($rpr['finish'], $place_array)."</td>\n";
     echo "  </tr>\n";
   } else { 
     $date_check   = $rpr['date'];
     $type_check   = $rpr['game_type'];
     $loc_check    = $rpr['location'];
     $id_check     = $rpr['id'];
     $finish_check = $rpr['finish'];
     $bubble_check = $rpr['bubble'];
   }
 } 
 
 echo "  <tr>\n";
 echo "    <td align=\"center\">$john_finish ($john_cash)</td>\n";
 echo "    <td align=\"center\">$total_games ($non_finish)</td>\n";
 echo "    <td align=\"center\">$rod_finish ($rod_cash)</td>\n";
 echo "  </tr>\n";
 echo "</table>\n"; 
 
 
 
 
 
/*
   $date        =  $row_pr["date"];
   $location    =  $row_pr["location"];
   $mem_num     =  $row_pr["member"];
   $game_type   =  $row_pr["game_type"];
   if ($date <= "2012-03-23") {
     if ($game_type == 2) {
       $multiplier = 1.5;
     } else if ($game_type == 3) {
       $multiplier = 3.5;
     } else if ($game_type == 4) {
       $multiplier = 2.5;
     } else if ($game_type == 5) {
       $multiplier = 5;
     } else if ($game_type == 6) {
       $multiplier = 1;
     }
   }
   $num_players =  $row_pr["num_players"];
   if (($num_players * 100) % 25 != 0) {$split = 1; $split_check = 1; $num_players -= 0.05;} else {$split = 0; $split_check = 0;}
   $finish      =  $row_pr["finish"];
   $bubble      =  $row_pr["bubble"];
   if ($bubble == 4) {$actual_played--;} 

   //===========================================
   // Finds the Day of the Week
   //===========================================
   $li_time = @strtotime($date);
   $day_of_week_num = @date("w",$li_time);
   $day_array = array("0" => "Sun",
                      "1" => "Mon",
                      "2" => "Tue",
                      "3" => "Wed",
                      "4" => "Thu",
                      "5" => "Fri",
                      "6" => "Sat");
   $day_of_week = strtr($day_of_week_num, $day_array);
   
   if ($bubble == 1) {$bubble_finish++;} else if ($bubble == 0) {$cash_finish++;}
   
   
   if ($finish < 0) {} else {
     if ($game_type == 2 || $game_type == 11 || ($game_type == 15 && $date > "2015-12-19")) {$total_games+=1.5;}
       else if ($game_type == 4 || $game_type == 10 || ($game_type == 15 && $date < "2015-12-19")) {$total_games+=2;}
         else if ($game_type == 1) {$total_games+=0.75;}
            else {$total_games++;}
   
     if ($finish == 1)  {$points += $num_players * $multiplier;}
                   else {$points += ($num_players - $finish) * $multiplier;}
     if ($finish == 1)  {$points += 10; $first++;  $final_tables++; $top3++;}
     if ($finish == 2)  {$points += 7;  $second++; $final_tables++; $top3++;}
     if ($finish == 3)  {$points += 5;  $third++;  $final_tables++; $top3++;}
//   echo "$split_check $num_players<br />";
//   if (($split_check * 100) % 25 != 0) {$top_3++; echo "yes<br />";}
     if ($finish == 4)  {if ($split_check == 1) {$top_3++; $split_check = 0;} $fourth++;  $final_tables++;}
     if ($finish == 5)  {$fifth++;   $final_tables++;}
     if ($finish == 6)  {$sixth++;   $final_tables++;}
     if ($finish == 7)  {$seventh++; if($game_type != 12 && $game_type != 14) {$final_tables++;}}
     if ($finish == 8)  {$eighth++;  if($game_type != 12 && $game_type != 14) {$final_tables++;}}
     if ($finish == 9)  {$ninth++;   if($game_type != 12 && $game_type != 14) {$final_tables++;}}
     if ($finish == 10) {$tenth++;   if($game_type != 12 && $game_type != 14) {$final_tables++;}}

     if ($points <= 1 && $finish != 0) {$points = 1;}
     $points = round($points, 2);
     $total_points += $points;
   }
   
   if ($mem_num > 0 && $finish != 0) {$total_points = $total_points + 5; $points = $points + 5;}
//   if ($mem_num > 0 && $date >= "2010-02-01" && $date <= "2010-02-20" && $location == 1) {$total_points = $total_points + 5; $points = $points + 5;}

   echo "  <tr style=\"background-color: #"; if ($finish == 1) {echo "eedd82";} else if ($bubble == 0 && $finish != 1 && $finish > 0) {echo "b1ddf3";} else if ($bubble == 1) {echo "e3675c";}
   echo ";\" onmouseover=\"hilight(this, '#daa520')\" onmouseout=\"hilight(this, '#"; if ($finish == 1) {echo "eedd82";} else if ($bubble == 0 && $finish != 1) {echo "b1ddf3";} else if ($bubble == 1) {echo "e3675c";} else {echo "FFFFFF";} echo "')\">\n";
   echo "    <td align=\"left\" style=\"border-left: 1px solid #909090;\">&nbsp;&nbsp;"; if ($finish < 0) {echo "<s>";} echo "$date&nbsp;($day_of_week)"; if ($finish < 0) {echo "</s>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\"border-left: 1px solid #909090;\">"; if ($finish < 0) {echo "<s>";} echo strtr($location, $location_names); if ($finish < 0) {echo "</s>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\"border-left: 1px solid #909090;\">"; if ($finish < 0) {echo "<s>";} echo strtr($game_type, $tourn_types); if ($finish < 0) {echo "</s>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\"border-left: 1px solid #909090;\">"; if ($split == 1) {echo "<b>*</b>";} if($finish > 0) {echo strtr($finish, $place_array);} else {echo "--";} echo "</td>\n";
   echo "    <td align=\"center\" style=\"border-left: 1px solid #909090; border-right: 1px solid #909090;\"><b>"; if ($points == 0) {echo "--";} else {echo number_format(round($points, 2),2);} echo "</b></td>\n";
   echo "  </tr>\n";

   $k++;
   $multiplier = 1;
   $points     = 0;
 }

// echo "</table>\n";

// echo "<table class=\"titles\" cellspacing=\"0\" cellpadding=\"1\">\n";
 echo "  <tr>\n";
 echo "    <td align=\"right\"  style=\"border-left: 1px solid #909090; border-bottom: 1px solid #909090;\"><b>GAMES Credited:</b>&nbsp;</td>\n";
 echo "    <td align=\"left\"   style=\"border-bottom: 1px solid #909090;\">$total_games</td>\n";
 echo "    <td align=\"right\"  style=\"border-left: 1px solid #909090; border-bottom: 1px solid #909090;\" colspan=\"2\"><b>"; if ($version != '330/4.5.0.12') {echo "TOTAL ";} echo "POINTS:</b></td>\n";
 echo "    <td align=\"center\" style=\"border-right: 1px solid #909090; border-bottom: 1px solid #909090;\"><b>"; echo number_format(round($total_points, 2),2); echo "</b></td>\n";
 echo "  </tr>\n";
 echo "</table>\n";
 
 // -------------------PLAYERS STATS--------------------------------
 
 echo "<h2 style=\"color: #000000;\">Player Stats</h2>\n";
 
 echo "<table style=\"border-collapse: collapse; border: 0px;\" cellspacing=\"0\" cellpadding=\"0\">\n";
 echo "  <tr>\n";

 echo "  </tr>\n";
 echo "    <td align=\"left\">Actual Games Played:&nbsp;</td>\n";
 echo "    <td align=\"left\">&nbsp;$actual_played&nbsp;</td>\n";
 echo "    <td align=\"right\">&nbsp;</td>\n";
 echo "  <tr>\n";
 echo "  </tr>\n";
 echo "    <td align=\"left\">Final Table Appeareances:&nbsp;</td>\n";
 echo "    <td align=\"left\">&nbsp;$final_tables&nbsp;</td>\n";
 echo "    <td align=\"right\">&nbsp;("; echo round(($final_tables / $actual_played) * 100, 1); echo "%)</td>\n";
 echo "  <tr>\n";
 echo "  </tr>\n";
 echo "    <td align=\"left\">&quot;Top 3&quot; Finishes:&nbsp;</td>\n";
 echo "    <td align=\"left\">&nbsp;$top3&nbsp;</td>\n";
 echo "    <td align=\"right\">&nbsp;("; echo round(($top3 / $actual_played) * 100, 1); echo "%)</td>\n";
 echo "  <tr>\n";
 echo "  </tr>\n";
 
 $popular = 0;
 $popular_check = 0;
 if ($first   > $popular_check) {$popular_check = $first;   $popular = 1;} 
 if ($second  > $popular_check) {$popular_check = $second;  $popular = 2;} 
 if ($third   > $popular_check) {$popular_check = $third;   $popular = 3;} 
 if ($fourth  > $popular_check) {$popular_check = $fourth;  $popular = 4;} 
 if ($fifth   > $popular_check) {$popular_check = $fifth;   $popular = 5;}
 if ($sixth   > $popular_check) {$popular_check = $sixth;   $popular = 6;}
 if ($seventh > $popular_check) {$popular_check = $seventh; $popular = 7;}
 if ($eighth  > $popular_check) {$popular_check = $eighth;  $popular = 8;}
 if ($ninth   > $popular_check) {$popular_check = $ninth;   $popular = 9;}
 if ($tenth   > $popular_check) {$popular_check = $tenth;   $popular = 10;}
 
 echo "    <td align=\"left\">Most Frequent Finish:&nbsp;</td>\n";
 echo "    <td align=\"left\">&nbsp;"; if($popular_check > 1) {echo strtr($popular, $place_array);} else {echo "--";} echo "&nbsp;</td>\n";
 echo "    <td align=\"right\">&nbsp;("; if($popular_check > 1) {echo round(($popular_check / $actual_played) * 100, 1); echo "%";} else {echo "--";}  echo ")</td>\n";
 echo "  <tr>\n";
 echo "  </tr>\n";
 echo "    <td align=\"left\"># of Cash Finishes:&nbsp;</td>\n";
 echo "    <td align=\"left\">&nbsp;$cash_finish&nbsp;</td>\n";
 echo "    <td align=\"right\">&nbsp;("; echo round(($cash_finish / $actual_played) * 100, 1); echo "%)</td>\n";
 echo "  <tr>\n";
 echo "  </tr>\n";
 echo "    <td align=\"left\"># of Bubble Finishes:&nbsp;</td>\n";
 echo "    <td align=\"left\">&nbsp;$bubble_finish&nbsp;</td>\n";
 echo "    <td align=\"right\">&nbsp;("; echo round(($bubble_finish / $actual_played) * 100, 1); echo "%)</td>\n";
 echo "  </tr>\n";
 echo "</table>\n";
 
 // -------------------PLAYERS STATS--------------------------------
 
 */

 echo "</center>\n";
 echo "<script type=\"text/javascript\" src=\"modify.js\"></script>\n";
 
 echo "</body>\n";
 echo "</html>\n";

?>