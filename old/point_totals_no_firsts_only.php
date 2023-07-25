<?PHP

 include("dates.php");

 $ip_address = $_SERVER['REMOTE_ADDR'];

 if ($ip_address == "142.163.153.132" || $_GET['track'] == "no") {} else {

   include("browser_detection.php");

   $current_date = date("Y-m-d H:i:s");
   $domain = GetHostByName($REMOTE_ADDR);
   $browser = "Browser: ".browser_detection('browser')." (".browser_detection('number').")\nOperating System: ".browser_detection('os')." (".browser_detection('os_number').")";

   $message .= "$ip_address\n\n";
   $message .= "Date & Time: $current_date\n\n";
   $message .= "$browser";

   mail("johnny_o_neill@hotmail.com", "Site Visitor" , $message);

 }

 include("dbinfo.php");

 mysql_connect($host,$username,$password);
 @mysql_select_db($database) or die("Unable to select database from point_entry.php");

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

 $tourn_types = array("1" => "<b class=\"sd\" >\$20 FO</b>",
                      "2" => "<b class=\"ecw\">\$20-$15-$20 RB</b>",
                      "3" => "<b class=\"raw\">\$40-$40-$40 SRB</b>",
                      "4" => "<b>\$50 FO</b>",
                      "5" => "<b class=\"snme\">\$100 FO</b>");

 $date = $_GET['date'];
 if (!ISSET($_GET['date'])) {
   $start_date = $playoff_start;
   $end_date   = $playoff_end;
 } else {
   $start_date = $date;
   $end_date   = $date;
 }
 
 $points_query     = "SELECT *
                      FROM points
                      WHERE date >= '$start_date' AND date <= '$end_date' AND player_id != 286
                      ORDER BY player_id ASC, date ASC";
 $points_result    = mysql_query($points_query);
 $points_num       = @mysql_numrows($points_result);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php

 echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\"> \n";
 echo "<head>\n";
 echo "<link rel=\"stylesheet\" href=\"doolys.css\" type=\"text/css\" />\n";
 echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
 echo "<title>Dooly&#39;s Poker Point Standings</title>\n";
 
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
 
 echo "<h1>2nd-10th Place Finishes<br>(1st Place Winners Removed)</h1>";

 echo "<table class=\"titles\" cellspacing=\"0\" cellpadding=\"1\" style=\"border-collapse: collapse;\">\n";
 echo "  <tr>\n";
 echo "    <td align=\"center\" valign=\"bottom\" rowspan=\"2\" style=\"width: 30px; border-left: 1px solid #909090; border-top: 1px solid #909090; border-bottom: 1px solid #909090;\">&nbsp;</td>\n";
 echo "    <td align=\"left\" valign=\"bottom\" rowspan=\"2\" style=\"width: 120px; border-right: 1px solid #909090; border-top: 1px solid #909090; border-bottom: 1px solid #909090;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>NAME</b>&nbsp;</td>\n";
 echo "    <td align=\"center\" valign=\"bottom\" rowspan=\"2\" style=\"width: 25px; border: 1px solid #909090;\"><img src=\"games.jpg\"></td>\n";
 echo "    <td align=\"center\" colspan=\"10\" style=\"border: 1px solid #909090;\"><b>TOURNAMENT FINISHES</b></td>\n";
 echo "    <td align=\"center\" valign=\"bottom\" rowspan=\"2\" style=\"width: 25px; border: 1px solid #909090;\"><img src=\"bonus.jpg\"></td>\n";
 echo "    <td align=\"center\" valign=\"bottom\" rowspan=\"2\" style=\"width: 50px; border: 1px solid #909090;\">&nbsp;<b>TOTAL&nbsp;<br />PTS<br />(x2)</b></td>\n";
 echo "  </tr>\n";
 echo "  <tr>\n";
 echo "    <td align=\"center\" style=\"width: 23px; border-left: 1px solid #909090; border-bottom: 1px solid #909090;\"><b>1<span class=\"sup\">st</span></b></td>\n";
 echo "    <td align=\"center\" style=\"width: 23px; border-left: 1px solid #909090; border-bottom: 1px solid #909090;\"><b>2<span class=\"sup\">nd</span></b></td>\n";
 echo "    <td align=\"center\" style=\"width: 23px; border-left: 1px solid #909090; border-bottom: 1px solid #909090;\"><b>3<span class=\"sup\">rd</span></b></td>\n";
 echo "    <td align=\"center\" style=\"width: 23px; border-left: 1px solid #909090; border-bottom: 1px solid #909090;\"><b>4<span class=\"sup\">th</span></b></td>\n";
 echo "    <td align=\"center\" style=\"width: 23px; border-left: 1px solid #909090; border-bottom: 1px solid #909090;\"><b>5<span class=\"sup\">th</span></b></td>\n";
 echo "    <td align=\"center\" style=\"width: 23px; border-left: 1px solid #909090; border-bottom: 1px solid #909090;\"><b>6<span class=\"sup\">th</span></b></td>\n";
 echo "    <td align=\"center\" style=\"width: 23px; border-left: 1px solid #909090; border-bottom: 1px solid #909090;\"><b>7<span class=\"sup\">th</span></b></td>\n";
 echo "    <td align=\"center\" style=\"width: 23px; border-left: 1px solid #909090; border-bottom: 1px solid #909090;\"><b>8<span class=\"sup\">th</span></b></td>\n";
 echo "    <td align=\"center\" style=\"width: 23px; border-left: 1px solid #909090; border-bottom: 1px solid #909090;\"><b>9<span class=\"sup\">th</span></b></td>\n";
 echo "    <td align=\"center\" style=\"width: 23px; border-left: 1px solid #909090; border-bottom: 1px solid #909090;\"><b>10<span class=\"sup\">th</span></b></td>\n";
// if ($points_num > 41) {
//   echo "    <td align=\"center\" style=\"width: 15px; border: 0px solid #909090;\">&nbsp;</td>\n";
// }
 echo "  </tr>\n";
 echo "</table>\n";

// if ($points_num > 41) {
//   echo "<div style=\"overflow: auto; width: 541px; height: 672px; table-layout: fixed; border-bottom: 1px solid #909090;\">\n";
// }
 echo "<table class=\"titles\" cellspacing=\"0\" cellpadding=\"1\" style=\""; if ($points_num <= 41) {echo " border-bottom: 1px solid #909090;";} echo "\">\n";
 echo "  <tr>\n";


 $first_finishes = 0;
 $secon_finishes = 0;
 $third_finishes = 0;
 $fourt_finishes = 0;
 $fifth_finishes = 0;
 $sixth_finishes = 0;
 $seven_finishes = 0;
 $eight_finishes = 0;
 $ninth_finishes = 0;
 $tenth_finishes = 0;

 $total_games = 0;        $bonus_points = 0;    $total_points = 0;    $seat = 0;    $points = 0;

 $winners_array = array();
 $other_array = array();
 $id_check = -1;
 $winners_check = 0;
 $other_check = 0;
 $multiplier = 1;
 $k = 0;
 $total_finishes = 0;
 while ($k < $points_num) {
   $id          =  mysql_result($points_result, $k,   "player_id");
   $id_check    = @mysql_result($points_result, $k+1, "player_id");
   $name        =  mysql_result($points_result, $k,   "player_name");
   $date        =  mysql_result($points_result, $k,   "date");
   $mem_num     =  mysql_result($points_result, $k,   "member");
   $location    =  mysql_result($points_result, $k,   "location");
   $game_type   =  mysql_result($points_result, $k,   "game_type");
     if ($game_type == 2) {$multiplier = 1.5;} else if ($game_type == 3) {$multiplier = 3.5;} else if ($game_type == 4) {$multiplier = 2.5;} else if ($game_type == 5) {$multiplier = 5;}
   $num_players =  mysql_result($points_result, $k,   "num_players");
   $finish      =  mysql_result($points_result, $k,   "finish");
   
   if ($finish != 0 ) {$total_games++;}

   if ($finish == 1 ) {$seat = 1;}
   if ($finish == 2 ) {           $secon_finishes++; $points = ($num_players - 2) * $multiplier;  $total_finishes++;}
   if ($finish == 3 ) {           $third_finishes++; $points = ($num_players - 3) * $multiplier;  $total_finishes++;}
   if ($finish == 4 ) {           $fourt_finishes++; $points = ($num_players - 4) * $multiplier;  $total_finishes++;}
   if ($finish == 5 ) {           $fifth_finishes++; $points = ($num_players - 5) * $multiplier;  $total_finishes++;}
   if ($finish == 6 ) {           $sixth_finishes++; $points = ($num_players - 6) * $multiplier;  $total_finishes++;}
   if ($finish == 7 ) {           $seven_finishes++; $points = ($num_players - 7) * $multiplier;  $total_finishes++;}
   if ($finish == 8 ) {           $eight_finishes++; $points = ($num_players - 8) * $multiplier;  $total_finishes++;}
   if ($finish == 9 ) {           $ninth_finishes++; $points = ($num_players - 9) * $multiplier;  $total_finishes++;}
   if ($finish == 10) {           $tenth_finishes++; $points = ($num_players - 10) * $multiplier; $total_finishes++;}

   if ($id == 219) {$seat = 0;}
   if ($mem_num > 0) {$bonus_points+=5; $points+=5;}
   if ($mem_num > 0 && $date >= "2010-02-01" && $date <= "2010-02-20" && $location == 1) {$points += 5; $bonus_points += 5;}

   $total_points += round(($points * 2), 0);

   if ((($id_check != $id) || ($k + 1 == $points_num)) &&  $total_finishes != 0) {
     if ($seat == 1) {
       $winners_array[] = array($id, $name, $total_points, $bonus_points, $total_games, $seat,
                                $first_finishes, $secon_finishes, $third_finishes, $fourt_finishes, $fifth_finishes,
                                $sixth_finishes, $seven_finishes, $eight_finishes, $ninth_finishes, $tenth_finishes);
     } else {
       if ($id == 1223) {} else {
       $other_array[]   = array($id, $name, $total_points, $bonus_points, $total_games, $seat,
                                $first_finishes, $secon_finishes, $third_finishes, $fourt_finishes, $fifth_finishes,
                                $sixth_finishes, $seven_finishes, $eight_finishes, $ninth_finishes, $tenth_finishes);
       }
     }
     $first_finishes = 0;     $secon_finishes = 0;   $third_finishes = 0;     $fourt_finishes = 0;
     $fifth_finishes = 0;     $sixth_finishes = 0;   $seven_finishes = 0;     $eight_finishes = 0;
     $ninth_finishes = 0;     $tenth_finishes = 0;

     $total_games = 0;        $bonus_points = 0;    $total_points = 0;    $seat = 0;    $multiplier = 1;    $points = 0;
   }
   $k++;
   $id_check = $id;
   $multiplier = 1;
   $points = 0;
 }
 
// $winners_array[] = array($id
 
 usort($winners_array, 'sort_points');
 usort($other_array, 'sort_points');
 $winners_num = count($winners_array);
 $other_num = count($other_array);
// echo "$winners_num - $other_num<br />\n";

 $t = 0;
 while ($t < 0) {
   $display_id             = $winners_array[$t][0];
   $display_name           = $winners_array[$t][1];
   $display_total_points   = $winners_array[$t][2];
   $display_bonus_points   = $winners_array[$t][3];
   $display_total_games    = $winners_array[$t][4];
   $display_seat           = $winners_array[$t][5];

   $display_first_finishes = $winners_array[$t][6];
   $display_secon_finishes = $winners_array[$t][7];
   $display_third_finishes = $winners_array[$t][8];
   $display_fourt_finishes = $winners_array[$t][9];
   $display_fifth_finishes = $winners_array[$t][10];
   $display_sixth_finishes = $winners_array[$t][11];
   $display_seven_finishes = $winners_array[$t][12];
   $display_eight_finishes = $winners_array[$t][13];
   $display_ninth_finishes = $winners_array[$t][14];
   $display_tenth_finishes = $winners_array[$t][15];

   echo "  <tr"; if ($display_seat == 1) {echo " style=\"background-color: #eedd82;\"";}
   echo " onmouseover=\"hilight(this, '#daa520')\" onmouseout=\"hilight(this, '"; if ($display_seat == 1) {echo "#eedd82";} echo "')\">\n";
   echo "    <td align=\"right\" style=\""; if ($t == 0) {echo "width: 30px; ";} echo "border-left: 1px solid #909090;\">&nbsp;"; if ($display_total_points == $winners_check) {} else {echo $t + 1; echo ".";} echo "&nbsp;</td>\n";
   echo "    <td"; if ($t == 0) {echo " style=\"width: 120px;\"";} echo "><a href=\"player_info.php?id=$display_id\">$display_name</a>&nbsp;&nbsp;</td>\n";
   echo "    <td align=\"center\" style=\""; if ($t == 0) {echo "width: 25px; ";} echo "border-left: 1px solid #909090;\">"; if ($display_total_games == 0)    {echo "--";}  else {echo "$display_total_games";}    echo "</td>\n";
   echo "    <td align=\"center\" style=\""; if ($t == 0) {echo "width: 23px; ";} echo "border-left: 1px solid #909090;\">"; if ($display_first_finishes == 0) {echo "--";}  else {echo "<b>$display_first_finishes</b>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\""; if ($t == 0) {echo "width: 23px; ";} echo "border-left: 1px solid #909090;\">"; if ($display_secon_finishes == 0) {echo "--";}  else {echo "<b>$display_secon_finishes</b>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\""; if ($t == 0) {echo "width: 23px; ";} echo "border-left: 1px solid #909090;\">"; if ($display_third_finishes == 0) {echo "--";}  else {echo "<b>$display_third_finishes</b>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\""; if ($t == 0) {echo "width: 23px; ";} echo "border-left: 1px solid #909090;\">"; if ($display_fourt_finishes == 0) {echo "--";}  else {echo "<b>$display_fourt_finishes</b>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\""; if ($t == 0) {echo "width: 23px; ";} echo "border-left: 1px solid #909090;\">"; if ($display_fifth_finishes == 0) {echo "--";}  else {echo "<b>$display_fifth_finishes</b>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\""; if ($t == 0) {echo "width: 23px; ";} echo "border-left: 1px solid #909090;\">"; if ($display_sixth_finishes == 0) {echo "--";}  else {echo "<b>$display_sixth_finishes</b>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\""; if ($t == 0) {echo "width: 23px; ";} echo "border-left: 1px solid #909090;\">"; if ($display_seven_finishes == 0) {echo "--";}  else {echo "<b>$display_seven_finishes</b>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\""; if ($t == 0) {echo "width: 23px; ";} echo "border-left: 1px solid #909090;\">"; if ($display_eight_finishes == 0) {echo "--";}  else {echo "<b>$display_eight_finishes</b>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\""; if ($t == 0) {echo "width: 23px; ";} echo "border-left: 1px solid #909090;\">"; if ($display_ninth_finishes == 0) {echo "--";}  else {echo "<b>$display_ninth_finishes</b>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\""; if ($t == 0) {echo "width: 23px; ";} echo "border-left: 1px solid #909090;\">"; if ($display_tenth_finishes == 0) {echo "--";}  else {echo "<b>$display_tenth_finishes</b>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\""; if ($t == 0) {echo "width: 25px; ";} echo "border-right: 1px solid #909090; border-left: 1px solid #909090;\">"; if ($display_bonus_points == 0)   {echo "--";}  else {echo round($display_bonus_points);}   echo "</td>\n";
   echo "    <td align=\"center\" style=\""; if ($t == 0) {echo "width: 50px; ";} echo "border-right: 1px solid #909090;\">"; if ($display_total_points == 0)   {echo "--";}  else {echo round($display_total_points);}   echo "</td>\n";
   echo "  </tr>\n";

   $t++;
   $winnners_check = $display_total_points;
 }

 $u = 0;
 $top40 = 1;
 while ($u < 40) {
   $display_id             = $other_array[$u][0];
   $display_name           = $other_array[$u][1];
   $display_total_points   = $other_array[$u][2];
   $display_bonus_points   = $other_array[$u][3];
   $display_total_games    = $other_array[$u][4];
   $display_seat           = $other_array[$u][5];

   $display_first_finishes = $other_array[$u][6];
   $display_secon_finishes = $other_array[$u][7];
   $display_third_finishes = $other_array[$u][8];
   $display_fourt_finishes = $other_array[$u][9];
   $display_fifth_finishes = $other_array[$u][10];
   $display_sixth_finishes = $other_array[$u][11];
   $display_seven_finishes = $other_array[$u][12];
   $display_eight_finishes = $other_array[$u][13];
   $display_ninth_finishes = $other_array[$u][14];
   $display_tenth_finishes = $other_array[$u][15];

   echo "  <tr onmouseover=\"hilight(this, '#daa520')\" onmouseout=\"hilight(this, '"; if ($display_seat == 1) {echo "#eedd82";} echo "')\">\n";
   echo "    <td align=\"right\" style=\""; if ($u == 0) {echo "width: 30px; ";} if ($u >= 40 && $display_total_points != $other_check && $top40 == 0) {echo "border-top: 2px solid #000000;";} echo "border-left: 1px solid #909090;\">&nbsp;"; if ($display_total_points == $other_check) {} else {echo $u + 1; echo ".";} echo "&nbsp;</td>\n";
   echo "    <td style=\""; if ($u == 0) {echo "width: 120px;";} if ($u >= 40 && $display_total_points != $other_check && $top40 == 0) {echo "border-top: 2px solid #000000;";} echo "\"><a href=\"player_info.php?id=$display_id\">$display_name</a>&nbsp;&nbsp;</td>\n";
//   echo "    <td align=\"center\" style=\""; if ($u == 0) {echo "width: 36px; ";} echo "border-left: 1px solid #909090;\">"; if ($display_seat == 1)           {echo "YES";} else {echo "--";} echo "</td>\n";
   echo "    <td align=\"center\" style=\""; if ($u == 0) {echo "width: 25px; ";} if ($u >= 40 && $display_total_points != $other_check && $top40 == 0) {echo "border-top: 2px solid #000000;";} echo "border-left: 1px solid #909090;\">"; if ($display_total_games == 0)    {echo "--";}  else {echo "$display_total_games";}    echo "</td>\n";
   echo "    <td align=\"center\" style=\""; if ($u == 0) {echo "width: 23px; ";} if ($u >= 40 && $display_total_points != $other_check && $top40 == 0) {echo "border-top: 2px solid #000000;";} echo "border-left: 1px solid #909090;\">"; if ($display_first_finishes == 0) {echo "--";}  else {echo "<b>$display_first_finishes</b>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\""; if ($u == 0) {echo "width: 23px; ";} if ($u >= 40 && $display_total_points != $other_check && $top40 == 0) {echo "border-top: 2px solid #000000;";} echo "border-left: 1px solid #909090;\">"; if ($display_secon_finishes == 0) {echo "--";}  else {echo "<b>$display_secon_finishes</b>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\""; if ($u == 0) {echo "width: 23px; ";} if ($u >= 40 && $display_total_points != $other_check && $top40 == 0) {echo "border-top: 2px solid #000000;";} echo "border-left: 1px solid #909090;\">"; if ($display_third_finishes == 0) {echo "--";}  else {echo "<b>$display_third_finishes</b>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\""; if ($u == 0) {echo "width: 23px; ";} if ($u >= 40 && $display_total_points != $other_check && $top40 == 0) {echo "border-top: 2px solid #000000;";} echo "border-left: 1px solid #909090;\">"; if ($display_fourt_finishes == 0) {echo "--";}  else {echo "<b>$display_fourt_finishes</b>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\""; if ($u == 0) {echo "width: 23px; ";} if ($u >= 40 && $display_total_points != $other_check && $top40 == 0) {echo "border-top: 2px solid #000000;";} echo "border-left: 1px solid #909090;\">"; if ($display_fifth_finishes == 0) {echo "--";}  else {echo "<b>$display_fifth_finishes</b>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\""; if ($u == 0) {echo "width: 23px; ";} if ($u >= 40 && $display_total_points != $other_check && $top40 == 0) {echo "border-top: 2px solid #000000;";} echo "border-left: 1px solid #909090;\">"; if ($display_sixth_finishes == 0) {echo "--";}  else {echo "<b>$display_sixth_finishes</b>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\""; if ($u == 0) {echo "width: 23px; ";} if ($u >= 40 && $display_total_points != $other_check && $top40 == 0) {echo "border-top: 2px solid #000000;";} echo "border-left: 1px solid #909090;\">"; if ($display_seven_finishes == 0) {echo "--";}  else {echo "<b>$display_seven_finishes</b>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\""; if ($u == 0) {echo "width: 23px; ";} if ($u >= 40 && $display_total_points != $other_check && $top40 == 0) {echo "border-top: 2px solid #000000;";} echo "border-left: 1px solid #909090;\">"; if ($display_eight_finishes == 0) {echo "--";}  else {echo "<b>$display_eight_finishes</b>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\""; if ($u == 0) {echo "width: 23px; ";} if ($u >= 40 && $display_total_points != $other_check && $top40 == 0) {echo "border-top: 2px solid #000000;";} echo "border-left: 1px solid #909090;\">"; if ($display_ninth_finishes == 0) {echo "--";}  else {echo "<b>$display_ninth_finishes</b>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\""; if ($u == 0) {echo "width: 23px; ";} if ($u >= 40 && $display_total_points != $other_check && $top40 == 0) {echo "border-top: 2px solid #000000;";} echo "border-left: 1px solid #909090;\">"; if ($display_tenth_finishes == 0) {echo "--";}  else {echo "<b>$display_tenth_finishes</b>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\""; if ($u == 0) {echo "width: 25px; ";} if ($u >= 40 && $display_total_points != $other_check && $top40 == 0) {echo "border-top: 2px solid #000000;";} echo "border-right: 1px solid #909090; border-left: 1px solid #909090;\">"; if ($display_bonus_points == 0)   {echo "--";}  else {echo round($display_bonus_points);}   echo "</td>\n";
   echo "    <td align=\"center\" style=\""; if ($u == 0) {echo "width: 50px; ";} if ($u >= 40 && $display_total_points != $other_check && $top40 == 0) {echo "border-top: 2px solid #000000;"; $top40 = 1;} echo "border-right: 1px solid #909090;\">"; if ($display_total_points == 0)   {echo "--";}  else {echo round($display_total_points);}   echo "</td>\n";
   echo "  </tr>\n";

   $t++;
   $u++;
   $other_check = $display_total_points;
 }

 echo "</table>\n";
// if ($points_num > 41) {
//   echo "</div>\n";
// }
 echo "</center>\n";
 echo "<script type=\"text/javascript\" src=\"modify.js\"></script>\n";

?>
