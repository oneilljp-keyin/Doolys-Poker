<?PHP

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

 $tourn_types = array("1" => "<b class=\"sd\" >\$20 Freezeout</b>",
                      "2" => "<b class=\"ecw\">\$20 Re-Buy</b>",
                      "3" => "<b class=\"raw\">\$50 Freezeout</b>",
                      "4" => "<b class=\"ppv\">\$100 Freezeout</b>");
                      
 $date = $_GET['date'];
 if (!ISSET($_GET['date'])) {
   $start_date = "2009-09-13";
   $end_date   = "2009-12-19";
 } else {
   $start_date = $date;
   $end_date   = $date;
 }
 
// echo "$start_date  - $end_date<br />";

 $points_query     = "SELECT *
                      FROM points
                      WHERE date >= '$start_date' AND date <= '$end_date'
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
 
 echo "<table class=\"mobile\" style=\"border-collapse: collapse; border: 0px;\" cellspacing=\"0\" cellpadding=\"0\">\n";
 echo "  <tr>\n";
 echo "    <td style=\"background-color: #eedd82;\" width=\"20px\">&nbsp;</td>\n";
 echo "    <td>&nbsp;&nbsp;Seat Winner</td>\n";
 echo "  </tr>\n";
 echo "</table>\n";
 echo "<br />\n";

 echo "<table class=\"mobile\" cellspacing=\"0\" cellpadding=\"1\" style=\"border-collapse: collapse;\">\n";
// echo "  <tr>\n";
// echo "    <td align=\"center\" valign=\"bottom\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>NAME</b>&nbsp;&nbsp;<b>TOTAL&nbsp;<br />PTS</b></td>\n";
// echo "  </tr>\n";

 $total_games = 0; $total_points = 0; $seat = 0; $points = 0;

 $winners_array = array();
 $other_array = array();
 $id_check = -1;
 $winners_check = 0;
 $other_check = 0;
 $multiplier = 1;
 $k = 0;
 while ($k < $points_num) {
   $id          =  mysql_result($points_result, $k,   "player_id");
   $id_check    = @mysql_result($points_result, $k+1, "player_id");
   $name        =  mysql_result($points_result, $k,   "player_name");
   $date        =  mysql_result($points_result, $k,   "date");
   $mem_num     =  mysql_result($points_result, $k,   "member");
   $location    =  mysql_result($points_result, $k,   "location");
   $game_type   =  mysql_result($points_result, $k,   "game_type");
     if ($game_type == 2) {$multiplier = 1.5;} else if ($game_type == 3) {$multiplier = 2.5;} else if ($game_type == 4) {$multiplier = 5;}
   $num_players =  mysql_result($points_result, $k,   "num_players");
   $finish      =  mysql_result($points_result, $k,   "finish");
   
   $total_games++;   $total_points++;

   if ($finish == 1 ) {$seat = 1; $points = $num_players * $multiplier;}
   if ($finish == 2 ) {           $points = $num_players * $multiplier - 2;}
   if ($finish == 3 ) {           $points = $num_players * $multiplier - 3;}
   if ($finish == 4 ) {           $points = $num_players * $multiplier - 4;}
   if ($finish == 5 ) {           $points = $num_players * $multiplier - 5;}
   if ($finish == 6 ) {           $points = $num_players * $multiplier - 6;}
   if ($finish == 7 ) {           $points = $num_players * $multiplier - 7;}
   if ($finish == 8 ) {           $points = $num_players * $multiplier - 8;}
   if ($finish == 9 ) {           $points = $num_players * $multiplier - 9;}
   if ($finish == 10) {           $points = $num_players * $multiplier - 10;}

   $total_points += $points;
   
   if ($mem_num > 0) {$total_points++;}
   
   if (($id_check != $id) || ($k + 1 == $points_num)) {
     if ($seat == 1) {
       $winners_array[] = array($id, $name, $total_points, $total_games, $seat);
     } else {
       $other_array[]   = array($id, $name, $total_points, $total_games, $seat);
     }
     $total_games = 0; $total_points = 0; $seat = 0;  $multiplier = 1;    $points = 0;
   }
   $k++;
   $id_check = $id;
   $multiplier = 1;
   $points = 0;
 }
 
 usort($winners_array, 'sort_points');
 usort($other_array, 'sort_points');
 $winners_num = count($winners_array);
 $other_num = count($other_array);

 $t = 0;
 while ($t < $winners_num) {
   $display_id             = $winners_array[$t][0];
   $display_name           = $winners_array[$t][1];
   $display_total_points   = $winners_array[$t][2];
   $display_total_games    = $winners_array[$t][3];
   $display_seat           = $winners_array[$t][4];

   echo "  <tr"; if ($display_seat == 1) {echo " style=\"background-color: #eedd82;\"";} echo "\">\n";
   echo "    <td align=\"left\">"; if ($display_total_points == $winners_check) {echo "&nbsp;";} else {if ($t < 99) {echo "&nbsp;";} if ($t < 9) {echo "&nbsp;&nbsp;";} echo $t + 1; echo ".";} if ($display_total_points < 1000) {echo "&nbsp;";} if ($display_total_points < 100) {echo "&nbsp;&nbsp;";} echo round($display_total_points); echo "&nbsp;<a href=\"player_info.php?id=$display_id\">$display_name</a>"; echo "</td>\n";
   echo "  </tr>\n";

   $t++;
   $winnners_check = $display_total_points;
 }

 $u = 0;
 $top40 = 0;
 while ($u < 50) {
   $display_id             = $other_array[$u][0];
   $display_name           = $other_array[$u][1];
   $display_total_points   = $other_array[$u][2];
   $display_total_games    = $other_array[$u][3];

   echo "  <tr>\n";
   echo "    <td align=\"left\" style=\"";
     if ($u >= 40 && $display_total_points != $other_check && $top40 == 0) {
       echo "border-top: 2px solid #000000;";
       $top40 = 1;
     }
   echo "\">&nbsp;";
     if ($display_total_points == $other_check) {
       echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
     } else {if ($u < 99) {echo "&nbsp;";} if ($u < 9) {echo "&nbsp;&nbsp;";} echo $u + 1; echo ".";} if ($display_total_points < 1000) {echo "&nbsp;";} if ($display_total_points < 100) {echo "&nbsp;&nbsp;";} echo round($display_total_points); echo "&nbsp;<a href=\"player_info.php?id=$display_id\">$display_name</a>"; echo "</td>\n";
   echo "  </tr>\n";

   $t++;
   $u++;
   $other_check = $display_total_points;
 }

 echo "</table>\n";
 echo "</center>\n";
 echo "<script type=\"text/javascript\" src=\"modify.js\"></script>\n";

?>
