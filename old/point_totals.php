<?PHP

 include("dates.php");
 
 $top_non = 60;
 
 if (ISSET($_GET['min_games'])) {
   $minimum_games = $_GET['min_games'];
 }
 if (ISSET($_GET['max_games'])) {
   $games_to_qualify = $_GET['max_games'];
 }

 include("dbinfo.php");

// $point_connect = new mysqli($host,$username,$password,$database);
// @mysql_select_db($database) or die("Unable to select database from point_entry.php");

//Output any connection error
//if ($point_connect->connect_error) {
//     die('Error : ('. $point_connect->connect_errno .') '. $point_connect->connect_error);
//}

 function diff_days($start_date, $end_date) {
   return round(abs(strtotime($start_date) - strtotime($end_date))/86400);
 }

 function sort_points($x, $y) {if ($x[2] == $y[2]) return 0; else if ($x[2] < $y[2]) return 1; else return -1;}
 function sort_games($x, $y)  {if ($x[4] == $y[4]) return 0; else if ($x[4] < $y[4]) return 1; else return -1;}
 function sort_names($x, $y)  {if ($x[1] == $y[1]) return 0; else if ($x[1] < $y[1]) return -1; else return 1;}

 function sort_actual($x, $y)          {if ($x[2] == $y[2]) return 0; else if ($x[2] < $y[2]) return 1; else return -1;}
 function sort_final_tables($x, $y)    {if ($x[3] == $y[3]) return 0; else if ($x[3] < $y[3]) return 1; else return -1;}
 function sort_final_percent($x, $y)   {if ($x[4] == $y[4]) return 0; else if ($x[4] < $y[4]) return 1; else return -1;}
 function sort_most_1($x, $y)          {if ($x[5] == $y[5]) return 0; else if ($x[5] < $y[5]) return 1; else return -1;}
 function sort_most_2($x, $y)          {if ($x[6] == $y[6]) return 0; else if ($x[6] < $y[6]) return 1; else return -1;}
 function sort_most_3($x, $y)          {if ($x[7] == $y[7]) return 0; else if ($x[7] < $y[7]) return 1; else return -1;}
 function sort_top_3($x, $y)           {if ($x[8] == $y[8]) return 0; else if ($x[8] < $y[8]) return 1; else return -1;}
 function sort_cashes($x, $y)          {if ($x[9] == $y[9]) return 0; else if ($x[9] < $y[9]) return 1; else return -1;}
 function sort_bubbles($x, $y)         {if ($x[10] == $y[10]) return 0; else if ($x[10] < $y[10]) return 1; else return -1;}
 function sort_top_3_percent($x, $y)   {if ($x[11] == $y[11]) return 0; else if ($x[11] < $y[11]) return 1; else return -1;}
 function sort_cash_percent($x, $y)    {if ($x[12] == $y[12]) return 0; else if ($x[12] < $y[12]) return 1; else return -1;}
 function sort_bubble_percent($x, $y)  {if ($x[13] == $y[13]) return 0; else if ($x[13] < $y[13]) return 1; else return -1;}

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

 $tourn_types = array("1" => "<b class=\"sd\" >\$25 FO</b>",
                      "2" => "<b class=\"ecw\">\$25 RB</b>",
                      "3" => "<b class=\"raw\">\$45-$40-$40</b>",
                      "4" => "<b>\$60 FO</b>",
                      "5" => "<b class=\"snme\">\$100 FO</b>",
                      "6" => "<b class=\"sd\">\$25 PLO</b>");
                      
 $date    = $_GET['start'];
 $end     = $_GET['end'];
 $current = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
 $bonus = $_GET['bonus'];
 $competition = $_GET['competition'];

 if (!ISSET($_GET['start'])) {
   $start_date = $playoff_start;
   $end_date   = $playoff_end;
 } else if (!ISSET($_GET['end'])) {
   $start_date = $date;
   $end_date   = $date;
 } else {
   $start_date = $date;
   $end_date   = $end;
 }
 
// $points_result    = mysql_query($points_query);
// echo "$points_num<br />\n";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php

 echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\"> \n";
 echo "<head>\n";
 echo "<link rel=\"stylesheet\" href=\"doolys.css\" type=\"text/css\" />\n";
 echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
 echo "<meta name=\"viewport\" content=\"width=device-width, initial-scale=";
 if ($_GET['show'] == "stats") {echo "0.70";} else {echo "0.80";} echo "\" />\n";
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

?>

<!-- Start of StatCounter Code -->
<script type="text/javascript">
var sc_project=6820649; 
var sc_invisible=1;  
var sc_security="d23e7cda"; 
var sc_https=1; 
var scJsHost = (("https:" == document.location.protocol) ?
"https://secure." : "http://www.");
document.write("<sc"+"ript type='text/javascript' src='" +
scJsHost +
"statcounter.com/counter/counter.js'></"+"script>");</script>
<noscript><div class="statcounter"><a title="web counter"
href="http://statcounter.com/" target="_blank"><img
class="statcounter"
src="https://c.statcounter.com/6820649/0/d23e7cda/1/"
alt="web counter"></a></div></noscript>
<!-- End of StatCounter Code -->

<?PHP
 echo "<center>\n";
 
//  if ($top_non == 60) {
//   echo "<a style=\"font-size: 22px;\" href=\"http://doolyspoker.johnny-o.net/chip_totals.php?sort=table"; if ($chips == 1) {echo "&chips=1";} echo "\">CLICK HERE to see Table/Seat List</a><br />(SEATING ARRANGEMENT MAY CHANGE WITHOUT NOTICE)<br />\n";
// } else {

// echo "$points_num - !!<br />\n";

if ($_GET['show'] == "stats") {} else {

 if ($bonus == "no") {
    echo "<span style=\"font-size: 20px;\">All Time Dooly's Poker Standings<br /></br ></span>";
 } else  if ($track != "ipad") {

/* if ($competition != "yes") {
   echo "<a href=\"point_totals.php?competition=yes\" style=\"font-size: 15px;\">Click Here To View The Quarterly Points Competition Totals</a>\n<br />\n<br />";
 } else {
   echo "<a href=\"point_totals.php\" style=\"font-size: 15px;\">Click Here To View The Point Totals</a>\n<br />\n<br />";
 }
*/
   echo "<a href=\"point_totals.php?show=stats\" style=\"font-size: 15px;\">Dooly's Poker By The Numbers (Player Statistics)</a>\n<br />\n<br />";

//   if ($competition != "year") {
//  }
   echo "<a href=\"tournaments.php\" style=\"font-size: 15px;\">Click Here To View The Tournament Schedule</a>\n<br />\n<br />";

//   echo "<a href=\"point_totals.php?date=2009-06-01&end=$end_date\" style=\"font-size: 17px;\">Click Here To View the Dooly's All-Time Point Standings (Since June 2009)</a>\n<br />\n<br />";

   echo "<b style=\"font-size: 25px;\">IMPORTANT NOTICE:</b><br />\n";

//  echo "If anyone believes there is an error in their points, please contact John before Thursday, December 20\n";

   echo "Please do not email about points not entered if you haven't check the tournament schedule (link above)<br />\n";
   echo "and to see if that particular tournament is entered. It may take some time for the results to be posted.<br />\n";
   echo "Only message if you know the tournament you finished in has been entered into the standings and your name is missing from the results.\n<br />\n<br />\n";
   
   echo "It is <b>YOUR RESPONSIBILITY</b> to make sure your name is on the sheet and legible.<br />\n";
   echo "If it is not there or can not be read or picked out, you will not be credited for the game played or finish.<br />\n<br />\n";
   
   echo "Any questions or corrections to the spelling of your name\n\n";
   echo "<br />please e-mail <a href=\"mailto:doolyspoker@johnny-o.net\">doolyspoker@johnny-o.net</a>\n<br />\n<br />\n";


   if ($competition != "yes") {
     echo "<span style=\"font-size:large\">NOTE: Names will not show on list<br />until <b>$minimum_games GAMES</b> Credited</span><br />\n<br />\n";
 
     echo "<table border=\"0\" cellpadding=\"5\">\n";
     echo "  <tr>\n";
     echo "    <td align=\"center\" style=\"background-color: #eedd82;\"><b>Reached $games_to_qualify Game Qualification</b><br />\n";
     echo "       Sunday - Thursday = 1 Game<br />\n";
     echo "       Friday & Saturday = 1.5 Games</td>\n";
     echo "  </tr>\n";
     echo "</table>\n";
//     echo "<br />\n";
   }

   $jackpot_total = 0;
   $jackpot_result  = $conn->query(
                      "SELECT jackpot
                       FROM tournaments
                       WHERE date >= '$start_date' AND date <= '$end_date'");
   while ($row_jp = $jackpot_result->fetch_assoc()) {
     $jackpot_total += $row_jp["jackpot"];
   }
   
   echo "<table border=\"0\" cellpadding=\"0\">\n";
   echo "  <tr>\n";
   echo "    <td style=\"font-size: 18px\" align=\"center\">Approx. Playoff Pot Total: $ "; echo number_format($jackpot_total, 0, '.', ','); echo "</td>\n";
   echo "  <tr>\n";
   echo "  </tr>\n";
   echo "    <td style=\"font-size: 12px\" align=\"center\">(Click Tournament Schedule for More Detail)</td>\n";
   echo "  </tr>\n";
   echo "</table>\n";

   if (ISSET($_GET['date']) && ($competition != "yes" && $competition != "year")) {
     list($c_yr, $c_mn, $c_dy) = explode("-", $date);
     $previous   = date("Y-m-d", mktime(0, 0, 0, $c_mn, $c_dy - 1, $c_yr));
     $next       = date("Y-m-d", mktime(0, 0, 0, $c_mn, $c_dy + 1, $c_yr));

     echo "<table style=\"border-collapse: collapse; border: 0px;\" cellspacing=\"0\" cellpadding=\"0\">\n";
     echo "  <tr>\n";
     echo "    <td width=\"150\" align=\"left\"><a href=\"http://doolyspoker.johnny-o.net/point_totals.php?track=no&date=$previous\">Previous Day</a></td>\n";
     echo "    <td width=\"150\" align=\"right\"><a href=\"http://doolyspoker.johnny-o.net/point_totals.php?track=no&date=$next\">Next Day</a></td>\n";
     echo "  </tr>\n";
     echo "</table>\n";
     echo "<br />\n";
   }
 }

   if ($competition == "yes") {
   echo "<b style=\"font-size: 20px;\">Point Competion Totals<br />March 23, 2014 - June 21, 2014</b>\n<br />\n<br />";
  }

//  if ($competition == "year") {
//   echo "<b style=\"font-size: 20px;\">Point Competion Totals<br />March 2012 - March 2013</b>\n<br />\n<br />";
//  }

 echo "<table class=\"titles\" cellspacing=\"0\" cellpadding=\"1\" style=\"border-collapse: collapse;\">\n";
 echo "  <tr>\n";
 echo "    <td align=\"center\" valign=\"bottom\" rowspan=\"2\" style=\"width: 30px; border-left: 1px solid #909090; border-top: 1px solid #909090; border-bottom: 1px solid #909090;\">&nbsp;</td>\n";
 echo "    <td align=\"left\" valign=\"bottom\" rowspan=\"2\" style=\"width: 115px; border-right: 1px solid #909090; border-top: 1px solid #909090; border-bottom: 1px solid #909090;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>NAME</b>&nbsp;</td>\n";
 if ($competition != "yes" && $competition != "year") {
   echo "    <td align=\"center\" colspan=\"11\" style=\"border: 1px solid #909090;\"><b>TOURNAMENT FINISHES</b></td>\n";
   echo "    <td align=\"center\" valign=\"bottom\" rowspan=\"2\" style=\"width: 30px; border: 1px solid #909090;\"><b style=\"font-size: 8px;\">BON<br>PTS</b></td>\n";
   echo "    <td align=\"center\" valign=\"bottom\" rowspan=\"2\" style=\"width: 55px; border: 1px solid #909090;\"><b style=\"font-size: 8px;\">PTS</b></td>\n";
//   echo "    <td align=\"center\" valign=\"bottom\" rowspan=\"2\" style=\"width: 55px; border: 1px solid #909090;\"><b style=\"font-size: 8px;\">PTS Behind 1st</b></td>\n";
 } else {
    echo "    <td align=\"center\" valign=\"bottom\" style=\"width: 55px; border: 1px solid #909090;\"><b style=\"font-size: 8px;\">PTS</b></td>\n";
 }

 echo "  <tr>\n";

   if ($competition != "yes" && $competition != "year") {
 echo "    <td align=\"center\" style=\"width: 30px; border-left: 1px solid #909090; border-bottom: 1px solid #909090;\"><b>GC</b></td>\n";
 echo "    <td align=\"center\" style=\"width: 24px; border-left: 1px solid #909090; border-bottom: 1px solid #909090;\"><b>1<span class=\"sup\">st</span></b></td>\n";
 echo "    <td align=\"center\" style=\"width: 24px; border-left: 1px solid #909090; border-bottom: 1px solid #909090;\"><b>2<span class=\"sup\">nd</span></b></td>\n";
 echo "    <td align=\"center\" style=\"width: 24px; border-left: 1px solid #909090; border-bottom: 1px solid #909090;\"><b>3<span class=\"sup\">rd</span></b></td>\n";
 echo "    <td align=\"center\" style=\"width: 24px; border-left: 1px solid #909090; border-bottom: 1px solid #909090;\"><b>4<span class=\"sup\">th</span></b></td>\n";
 echo "    <td align=\"center\" style=\"width: 24px; border-left: 1px solid #909090; border-bottom: 1px solid #909090;\"><b>5<span class=\"sup\">th</span></b></td>\n";
 echo "    <td align=\"center\" style=\"width: 24px; border-left: 1px solid #909090; border-bottom: 1px solid #909090;\"><b>6<span class=\"sup\">th</span></b></td>\n";
 echo "    <td align=\"center\" style=\"width: 24px; border-left: 1px solid #909090; border-bottom: 1px solid #909090;\"><b>7<span class=\"sup\">th</span></b></td>\n";
 echo "    <td align=\"center\" style=\"width: 24px; border-left: 1px solid #909090; border-bottom: 1px solid #909090;\"><b>8<span class=\"sup\">th</span></b></td>\n";
 echo "    <td align=\"center\" style=\"width: 24px; border-left: 1px solid #909090; border-bottom: 1px solid #909090;\"><b>9<span class=\"sup\">th</span></b></td>\n";
 echo "    <td align=\"center\" style=\"width: 24px; border-left: 1px solid #909090; border-bottom: 1px solid #909090;\"><b>10<span class=\"sup\">th</span></b></td>\n";
}

 echo "  </tr>\n";
 echo "</table>\n";

 echo "<table class=\"titles\" cellspacing=\"0\" cellpadding=\"1\" style=\"border-collapse: collapse; "; if ($points_num <= 31) {echo " border-bottom: 1px solid #909090;";} echo "\">\n";
 echo "  <tr>\n";
 
 }

 $games_played   = 0;           $actual_played  = 0;
 $first_finishes = 0;           $final_tables   = 0;
 $secon_finishes = 0;           
 $third_finishes = 0;           $top_3          = 0;
 $fourt_finishes = 0;           $cash_finishes  = 0;
 $fifth_finishes = 0;           $bubble_finish  = 0;
 $sixth_finishes = 0;           $cash_percent   = 0;
 $seven_finishes = 0;           $bubble_percent = 0; 
 $eight_finishes = 0;
 $ninth_finishes = 0;
 $tenth_finishes = 0;

 $total_games = 0;        $bonus_points = 0;    $total_points = 0;    $seat = 0;    $points = 0;

 $qualify_array = array();
 $games_array   = array();
 $other_array   = array();
 $stats_array   = array();
 $id_check = -1;
 $winners_check = 0;
 $split_check = 0;
 
 $multiplier = 1;
 
 $points_result = $conn->query(
                  "SELECT *
                   FROM points
                   WHERE date >= '$start_date' AND date <= '$end_date' AND player_id != '2886'
                   ORDER BY player_id ASC, date ASC");

$k = 0;
$id_check = 0;
$points_num       = mysqli_num_rows($points_result);

while ($row4 = $points_result->fetch_assoc()) {
   $id          = $row4["player_id"];

   if (($id_check != $id) || ($k + 1 == $points_num)) {
     $total_points = round($total_points, 2);
     if ($_GET['show'] == "stats" && $actual_played >= $actual && $total_points != 0) {
       $final_percent  = round(($final_tables  / $actual_played) * 100, 1);
       $cash_percent   = round(($cash_finishes / $actual_played) * 100, 1);
       $bubble_percent = round(($bubble_finish / $actual_played) * 100, 1);
       $top_3_percent  = round(($top_3 / $actual_played) * 100, 1);
       $stats_array[] = array($id_check, $name, $actual_played, $final_tables, $final_percent, $first_finishes,
                              $secon_finishes, $third_finishes, $top_3, $cash_finishes, $bubble_finish,
                              $top_3_percent, $cash_percent, $bubble_percent);
     } else if ($total_games >= $games_to_qualify) {
       if ($total_points != 0 && $total_games >= $games_to_qualify) {
         $qualify_array[] = array($id_check, $name, $total_points, $bonus_points, $total_games, $seat,
                                  $first_finishes, $secon_finishes, $third_finishes, $fourt_finishes, $fifth_finishes,
                                  $sixth_finishes, $seven_finishes, $eight_finishes, $ninth_finishes, $tenth_finishes);
       } else {
         $games_array[] = array($id_check, $name, $total_points, $bonus_points, $total_games, $seat,
                                  $first_finishes, $secon_finishes, $third_finishes, $fourt_finishes, $fifth_finishes,
                                  $sixth_finishes, $seven_finishes, $eight_finishes, $ninth_finishes, $tenth_finishes);
        }
     } else if ($total_games >= $minimum_games) {
       $other_array[] = array($id_check, $name, $total_points, $bonus_points, $total_games, $seat,
                                $first_finishes, $secon_finishes, $third_finishes, $fourt_finishes, $fifth_finishes,
                                $sixth_finishes, $seven_finishes, $eight_finishes, $ninth_finishes, $tenth_finishes);
     }
     
     $first_finishes = 0;     $secon_finishes = 0;   $third_finishes = 0;     $fourt_finishes = 0;
     $fifth_finishes = 0;     $sixth_finishes = 0;   $seven_finishes = 0;     $eight_finishes = 0;
     $ninth_finishes = 0;     $tenth_finishes = 0;   $actual_played  = 0;     $final_tables   = 0;
     $top_3          = 0;     $cash_finishes  = 0;   $bubble_finish  = 0;     $cash_percent   = 0;
     $bubble_percent = 0;

     $total_games = 0;        $bonus_points = 0;    $total_points = 0;   $multiplier = 1;    $points = 0;
   }


//   $id_check    = @mysql_result($points_result, $k+1, "player_id");
   $name        =  $row4["player_name"];
   $date        =  $row4["date"];
   $mem_num     =  $row4["member"];
   $location    =  $row4["location"];
   $game_type   =  $row4["game_type"];
   if ($date <= "2012-03-23") {
     if ($game_type == 2) {
       $multiplier = 1.5;                // $25 Re-Buy
     } else if ($game_type == 3) {
       $multiplier = 3.5;                // $45-$40-$40
     } else if ($game_type == 4) {
       $multiplier = 2.5;                // $60 FO
     } else if ($game_type == 5) {
       $multiplier = 5;                  // $100 FO
     } else if ($game_type == 6) {
       $multiplier = 1;                  // $25 PLO
     }
   }
   $num_players =  $row4["num_players"];
     if (($num_players * 100) % 25 != 0) {$splits++; $split_check = 1; $num_players -= 0.05;}
   $finish      =  $row4["finish"];
   $bubble      =  $row4["bubble"];

//   echo "$name - $id - $mem_num - $finish - $num_players<br />\n";

   
   if ($finish < 0) {} else {
     if ($game_type == 1)  {$total_games += 0.75;} else 
     if ($game_type == 2)  {$total_games += 1.5;} else 
     if ($game_type == 4)  {$total_games += 2;}   else 
     if ($game_type == 7)  {$total_games += 1;}
     if ($game_type == 9)  {$total_games += 1;}
     if ($game_type == 10) {$total_games += 2;}
     if ($game_type == 11) {$total_games += 1.5;}
     if ($game_type == 12) {$total_games += 1;}
     if ($game_type == 13) {$total_games += 1;}
     if ($game_type == 14) {$total_games += 1;}
     if ($game_type == 15) {if ($date > "2015-12-19") {$total_games += 1.5;} else {$total_games += 2;}}
   }
   
   if($bubble != 4) {$actual_played++;}

   if($bubble == 0) {$cash_finishes++;}
   if($bubble == 1) {$bubble_finish++;}


   if ($finish < 0) {} else {
     if ($finish == 1 ) {$first_finishes++; $final_tables++; $top_3++; $points = ($num_players * $multiplier) + 10;}
     if ($finish == 2 ) {$secon_finishes++; $final_tables++; $top_3++; $points = (($num_players - 2) * $multiplier) + 7;}
     if ($finish == 3 ) {$third_finishes++; $final_tables++; $top_3++; $points = (($num_players - 3) * $multiplier) + 5;}
//   if (($split_check * 100) % 25 != 0) {$top_3++; echo "yes<br />";} 
     if ($finish == 4 ) {if ($split_check == 1) {$split_check = 0;} $fourt_finishes++; $final_tables++; $points = ($num_players - 4)  * $multiplier;}
     if ($finish == 5 ) {$fifth_finishes++; $final_tables++; $points = ($num_players - 5)  * $multiplier;}
     if ($finish == 6 ) {$sixth_finishes++; $final_tables++; $points = ($num_players - 6)  * $multiplier;}
     if ($finish == 7 ) {$seven_finishes++; if($game_type != 12 && $game_type != 14) {$final_tables++;} $points = ($num_players - 7)  * $multiplier;}
     if ($finish == 8 ) {$eight_finishes++; if($game_type != 12 && $game_type != 14) {$final_tables++;} $points = ($num_players - 8)  * $multiplier;}
     if ($finish == 9 ) {$ninth_finishes++; if($game_type != 12 && $game_type != 14) {$final_tables++;}; $points = ($num_players - 9)  * $multiplier;}
     if ($finish == 10) {$tenth_finishes++; if($game_type != 12 && $game_type != 14) {$final_tables++;} $points = ($num_players - 10) * $multiplier;}
     if ($finish == 11) {$tenth_finishes++; if($game_type != 12 && $game_type != 14) {$final_tables++;} $points = ($num_players - 11) * $multiplier;}
   
     if ($points < 1 && $finish != 0) {$points = 1;}
   }
   if ($competition != "yes" && $competition != "year") {
     if ($mem_num > 0 && $finish != 0) {$points += 5; $bonus_points += 5;}
   }

   $total_points += $points;
   
   $tourn_result = $conn->query(
                  "SELECT *
                   FROM tournaments
                   WHERE date >= '$start_date' AND date <= '$end_date' AND td != '-1,0'
                   ");

   $days       = mysqli_num_rows($tourn_result);
//   $actual = floor((diff_days($start_date, $current) - $games_missed) / 3, 0);
   $actual = round($days / 3, 0);
   if ($actual < 1) {$actual = 1;}
   
   // echo "$id - $id_check\n<br />"; 

   $k++;
   $id_check = $id;
   $multiplier = 1;
   $points = 0;
 }
 
 usort($qualify_array, 'sort_points');
 usort($games_array,   'sort_games');
 usort($other_array,   'sort_names');
 $qualify_num = count($qualify_array);
 $games_num   = count($games_array);
 $other_num   = count($other_array);
 $stats_num   = count($stats_array);

// echo "<pre>\n";
// echo print_r($qualify_array);
// echo "</pre>\n";

 if ($_GET['show'] == "stats") {
  

   echo "<span style=\"font-size: 20px;\">Poker Player Statistics<br />(Minimum $actual Games PLAYED)<br />($start_date - $end_date)</span><br /><br />\n";
   
//   $days = diff_days($start_date, $current) - $games_missed;

   $split = 0;
   
   $sort_array = array("1" => "sort_actual",
                       "2" => "sort_final_tables",
                       "3" => "sort_final_percent",
                       "4" => "sort_most_1",
                       "5" => "sort_most_2",
                       "6" => "sort_most_3",
                       "7" => "sort_top_3",
                       "8" => "sort_cashes",
                       "9" => "sort_bubbles",
                      "10" => "sort_top_3_percent",
                      "11" => "sort_cash_percent",
                      "12" => "sort_bubble_percent"
                      );
                      
   $label_array = array("1" => "Actual Games",
                        "2" => "Final Tables",
                        "3" => "Final Table %",
                        "4" => "Most Wins",
                        "5" => "Most 2nd Places",
                        "6" => "Most 3rd Places",
                        "7" => "Most Top 3 Finishes",
                        "8" => "Most Cashes",
                        "9" => "Most Bubbles",
                       "10" => "Top 3 %",
                       "11" => "Cash %",
                       "12" => "Bubble %"
                       );
   $sort_num  = count($sort_array);
   
   echo "<table cellspacing=\"0\" cellpadding=\"0\" style=\"border: none;\">\n";
   echo "  <tr>\n";
   echo "    <td valign=\"top\">\n";

   $g = 0;
   while ($g < $sort_num) {
     $h = $g+1;
     $sort_variable = strtr($h, $sort_array);
     $label         = strtr($h, $label_array); 
   


   echo "    <table class=\"titles\" cellspacing=\"0\" cellpadding=\"1\" style=\"border: 1px solid #909090;\" width=\"100%\">\n";
   echo "      <tr>\n";
   echo "        <td align=\"center\" colspan=\"3\"><b>$label</b><br />&nbsp;"; if ($h == 1 || $h  == 2 || $h == 4 || $h  == 5 || $h  == 6 || $h  == 7 || $h  == 8 || $h  == 9) {echo "(Possible $days)";} echo "&nbsp;</td>\n";
   echo "      </tr>\n";
   echo "      <tr>\n";
   echo "        <td width=\"20\">&nbsp;</td>\n";
   echo "        <td align=\"left\" width=\"130\">&nbsp;&nbsp;Name:"; if ($h == 3 || $h == 10 || $h == 11 || $h == 12) {echo " <small>(Games)</small>";} echo "&nbsp;&nbsp;</td>\n";
   echo "        <td align=\"center\" width=\"20\">&nbsp;&nbsp;</td>\n";
   echo "      </tr>\n";
   
  
   usort($stats_array, $sort_variable);
 
   $place = 1;
   $s = 0;
   $h++;
   $check = $stats_array[9][$h];
   while($s < $stats_num) {
   
     $id       = $stats_array[$s][0];
     $name     = $stats_array[$s][1];
     $variable = $stats_array[$s][$h];
     $next     = $stats_array[$s+1][$h];
     $actual   = $stats_array[$s][2];

     if ($variable == 1 || $variable == 0) { } else {      
     echo "      <tr>\n";
     echo "        <td align=\"right\">"; if ($previous != $variable) {echo "&nbsp;$place.";} else {echo "&nbsp;";} echo "</td>\n";
     echo "        <td align=\"left\">&nbsp;&nbsp;<a href=\"player_info.php?id=$id";
                   echo "&start=$start_date&end=$end_date"; 
                   echo "\">$name</a>"; if ($h == 4 || $h == 11 || $h == 12 || $h == 13) {echo " <small><small>($actual)</small></small>";} echo "&nbsp;&nbsp;</td>\n";
     if ($h == 4 || $h == 11 || $h == 12 || $h == 13) {
       echo "        <td align=\"center\">$variable"; list($int, $dec) = explode('.', $variable); if($dec == 0) {echo ".0";} echo"%&nbsp;</td>\n";
     } else {
       echo "        <td align=\"center\">$variable</td>\n";
     }
     echo "      </tr>\n";
     $place++;
     }
     
     $s++;
     if ($s >= 10 && $check != $next) {
       $s = $stats_num;
     }
     $previous = $variable;
   
   }
   
   $split++;   
   echo "    </table>\n";
   echo "    </td>\n";
   if ($split % 3 == 0) {
     echo "  </tr>\n";
     echo "  <tr>\n";
     echo "    <td colspan=\"3\">&nbsp;</td>\n";
     echo "  </tr>\n";
     echo "  <tr>\n";
   }  
   echo "    <td valign=\"top\">\n";
   
   $g++;
   }
  
 } else {

 $t = 0;
 $top = 0;
 $winners_check = 0;
 
 while ($t < $qualify_num) {
   $display_id             = $qualify_array[$t][0];
   $display_name           = $qualify_array[$t][1];
//   list($display_first, $display_last, $display_suffix) = explode(" ", $display_name);
   $display_first_letter = $display_name{0};
   $display_total_points   = $qualify_array[$t][2];
   $display_bonus_points   = $qualify_array[$t][3];
   $display_total_games    = $qualify_array[$t][4];
   $display_seat           = $qualify_array[$t][5];

   $display_first_finishes = $qualify_array[$t][6];
   $display_secon_finishes = $qualify_array[$t][7];
   $display_third_finishes = $qualify_array[$t][8];
   $display_fourt_finishes = $qualify_array[$t][9];
   $display_fifth_finishes = $qualify_array[$t][10];
   $display_sixth_finishes = $qualify_array[$t][11];
   $display_seven_finishes = $qualify_array[$t][12];
   $display_eight_finishes = $qualify_array[$t][13];
   $display_ninth_finishes = $qualify_array[$t][14];
   $display_tenth_finishes = $qualify_array[$t][15];
   $display_six_ten_fin    = $qualify_array[$t][16];

   echo "  <tr"; if ($display_total_games >= $games_to_qualify && $display_total_points != 0 && $competition != "yes") {echo " style=\"background-color: #eedd82;\"";}
   echo " onmouseover=\"hilight(this, '#daa520')\" onmouseout=\"hilight(this, '"; if ($display_total_games >= 10 && $display_total_points != 0 && $competition != "yes") {echo "#eedd82";} echo "')\">\n";
   echo "    <td align=\"right\" style=\"width: 30px; "; if (($t >= $top_non && $display_total_points != $winners_check && $top == 0) || ($competition == "yes" && $t == 10) || ($competition == "year" && $t == 3)) {echo "border-top: 2px solid #000000;";} echo "border-left: 1px solid #909090;\">&nbsp;"; if ($display_total_points == $winners_check) {} else {echo $t + 1; echo ".";} echo "&nbsp;</td>\n";
   echo "    <td style=\"width: 115px;";
   if (($t >= $top_non && $display_total_points != $winners_check && $top == 0) || ($competition == "yes" && $t == 10) || ($competition == "year" && $t == 3)) {
     echo " border-top: 2px solid #000000;";
   }
   echo "\"><a href=\"player_info.php?id=$display_id";
   echo "&start=$start_date&end=$end_date"; 
   echo "\">$display_name</a>&nbsp;&nbsp;</td>\n";

   if ($competition != "yes" && $competition != "year") {
     echo "    <td align=\"center\" style=\"width: 30px; "; if ($t >= $top_non && $display_total_points != $winners_check && $top == 0) {echo "border-top: 2px solid #000000;";} echo "border-left: 1px solid #909090;\">"; if ($display_total_games    == 0) {echo "--";}  else {echo "<b>$display_total_games</b>";} echo "</td>\n";
     echo "    <td align=\"center\" style=\"width: 24px; "; if ($t >= $top_non && $display_total_points != $winners_check && $top == 0) {echo "border-top: 2px solid #000000;";} echo "border-left: 1px solid #909090;\">"; if ($display_first_finishes == 0) {echo "--";}  else {echo "<b>$display_first_finishes</b>";} echo "</td>\n";
     echo "    <td align=\"center\" style=\"width: 24px; "; if ($t >= $top_non && $display_total_points != $winners_check && $top == 0) {echo "border-top: 2px solid #000000;";} echo "border-left: 1px solid #909090;\">"; if ($display_secon_finishes == 0) {echo "--";}  else {echo "<b>$display_secon_finishes</b>";} echo "</td>\n";
     echo "    <td align=\"center\" style=\"width: 24px; "; if ($t >= $top_non && $display_total_points != $winners_check && $top == 0) {echo "border-top: 2px solid #000000;";} echo "border-left: 1px solid #909090;\">"; if ($display_third_finishes == 0) {echo "--";}  else {echo "<b>$display_third_finishes</b>";} echo "</td>\n";
     echo "    <td align=\"center\" style=\"width: 24px; "; if ($t >= $top_non && $display_total_points != $winners_check && $top == 0) {echo "border-top: 2px solid #000000;";} echo "border-left: 1px solid #909090;\">"; if ($display_fourt_finishes == 0) {echo "--";}  else {echo "<b>$display_fourt_finishes</b>";} echo "</td>\n";
     echo "    <td align=\"center\" style=\"width: 24px; "; if ($t >= $top_non && $display_total_points != $winners_check && $top == 0) {echo "border-top: 2px solid #000000;";} echo "border-left: 1px solid #909090;\">"; if ($display_fifth_finishes == 0) {echo "--";}  else {echo "<b>$display_fifth_finishes</b>";} echo "</td>\n";
     echo "    <td align=\"center\" style=\"width: 24px; "; if ($t >= $top_non && $display_total_points != $winners_check && $top == 0) {echo "border-top: 2px solid #000000;";} echo "border-left: 1px solid #909090;\">"; if ($display_sixth_finishes == 0) {echo "--";}  else {echo "<b>$display_sixth_finishes</b>";} echo "</td>\n";
     echo "    <td align=\"center\" style=\"width: 24px; "; if ($t >= $top_non && $display_total_points != $winners_check && $top == 0) {echo "border-top: 2px solid #000000;";} echo "border-left: 1px solid #909090;\">"; if ($display_seven_finishes == 0) {echo "--";}  else {echo "<b>$display_seven_finishes</b>";} echo "</td>\n";
     echo "    <td align=\"center\" style=\"width: 24px; "; if ($t >= $top_non && $display_total_points != $winners_check && $top == 0) {echo "border-top: 2px solid #000000;";} echo "border-left: 1px solid #909090;\">"; if ($display_eight_finishes == 0) {echo "--";}  else {echo "<b>$display_eight_finishes</b>";} echo "</td>\n";
     echo "    <td align=\"center\" style=\"width: 24px; "; if ($t >= $top_non && $display_total_points != $winners_check && $top == 0) {echo "border-top: 2px solid #000000;";} echo "border-left: 1px solid #909090;\">"; if ($display_ninth_finishes == 0) {echo "--";}  else {echo "<b>$display_ninth_finishes</b>";} echo "</td>\n";
     echo "    <td align=\"center\" style=\"width: 24px; "; if ($t >= $top_non && $display_total_points != $winners_check && $top == 0) {echo "border-top: 2px solid #000000;";} echo "border-left: 1px solid #909090;\">"; if ($display_tenth_finishes == 0) {echo "--";}  else {echo "<b>$display_tenth_finishes</b>";} echo "</td>\n";
     echo "    <td align=\"center\" style=\"width: 30px; "; if ($t >= $top_non && $display_total_points != $winners_check && $top == 0) {echo "border-top: 2px solid #000000;";} echo "border-left: 1px solid #909090;\">"; if ($display_bonus_points == 0  ) {echo "--";}  else {echo "<b>$display_bonus_points</b>";} echo "</td>\n";
     echo "    <td align=\"center\" style=\"width: 55px; "; if ($t >= $top_non && $display_total_points != $winners_check && $top == 0) {echo "border-top: 2px solid #000000; "; $top = 1;} echo "border-right: 1px solid #909090; border-left: 1px solid #909090;\">"; if ($display_total_points == 0)   {echo "--";}  else {echo number_format(round($display_total_points,2),2);}   echo "</td>\n";
//     echo "    <td align=\"center\" style=\"width: 55px; "; if ($t >= $top_non && $display_total_points != $winners_check && $top == 0) {echo "border-top: 2px solid #000000; "; $top = 1;} echo "border-right: 1px solid #909090; border-left: 1px solid #909090;\">"; if ($winners_check == 0 || $t > 4)   {echo "--";}  else {echo number_format(round($first_place_points - $display_total_points,2),2);}   echo "</td>\n";
     echo "  </tr>\n";
   } else {
     echo "    <td align=\"center\" style=\"width: 55px; "; if (($t >= $top_non && $display_total_points != $winners_check && $top == 0) || ($competition == "yes" && $t == 10) || ($competition == "year" && $t == 3)) {echo "border-top: 2px solid #000000; "; $top = 1;} echo "border-right: 1px solid #909090; border-left: 1px solid #909090;\">"; if ($display_total_points == 0)   {echo "--";}  else {echo number_format(round($display_total_points,2),2);}   echo "</td>\n";
   } 
   

   $t++;
   if (($competition == "yes" || $competition == "year") && $t == 15) {
     $t = $qualify_num;
   }

   if ($winners_check == 0) {
     $first_place_points = $display_total_points; 
   }
   $winners_check = $display_total_points;
 }

 $v = 0;
 $top = 0;
 $winners_check = 0;
 while ($v < $games_num && $competition != "yes") {
   $display_id             = $games_array[$v][0];
   $display_name           = $games_array[$v][1];
   list($display_first, $display_last, $display_suffix) = explode(" ", $display_name);
   $display_first_letter = $display_name{0};
   $display_total_points   = $games_array[$v][2];
   $display_bonus_points   = $games_array[$v][3];
   $display_total_games    = $games_array[$v][4];
   $display_seat           = $games_array[$v][5];

   $display_first_finishes = $games_array[$v][6];
   $display_secon_finishes = $games_array[$v][7];
   $display_third_finishes = $games_array[$v][8];
   $display_fourt_finishes = $games_array[$v][9];
   $display_fifth_finishes = $games_array[$v][10];
   $display_sixth_finishes = $games_array[$v][11];
   $display_seven_finishes = $games_array[$v][12];
   $display_eight_finishes = $games_array[$v][13];
   $display_ninth_finishes = $games_array[$v][14];
   $display_tenth_finishes = $games_array[$v][15];
   $display_six_ten_fin    = $games_array[$v][16];

   echo "  <tr style=\""; if ($v == 0) {echo "border-top: 2px solid #000000; ";} if ($display_total_games >= 10 && $competition != "yes") {echo " background-color: #eedd82;\"";} if ($v ==0) {echo " style=\"border-top: 2px solid #000000;\"";}
   echo " onmouseover=\"hilight(this, '#daa520')\" onmouseout=\"hilight(this, '"; if ($display_total_games >= 10 && $competition != "yes") {echo "#eedd82";} echo "')\">\n";
   echo "    <td align=\"right\" style=\"width: 30px; border-left: 1px solid #909090;\">&nbsp;&nbsp;</td>\n";
   echo "    <td style=\"width: 115px;";
   echo "\"><a href=\"player_info.php?id=$display_id";
   echo "&start=$start_date&end=$end_date"; 
   echo "\">$display_name</a>&nbsp;&nbsp;</td>\n";
   echo "    <td align=\"center\" style=\"width: 30px; border-left: 1px solid #909090;\">"; if ($display_total_games    == 0) {echo "--";}  else {echo "<b>$display_total_games</b>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\"width: 24px; border-left: 1px solid #909090;\">"; if ($display_first_finishes == 0) {echo "--";}  else {echo "<b>$display_first_finishes</b>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\"width: 24px; border-left: 1px solid #909090;\">"; if ($display_secon_finishes == 0) {echo "--";}  else {echo "<b>$display_secon_finishes</b>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\"width: 24px; border-left: 1px solid #909090;\">"; if ($display_third_finishes == 0) {echo "--";}  else {echo "<b>$display_third_finishes</b>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\"width: 24px; border-left: 1px solid #909090;\">"; if ($display_fourt_finishes == 0) {echo "--";}  else {echo "<b>$display_fourt_finishes</b>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\"width: 24px; border-left: 1px solid #909090;\">"; if ($display_fifth_finishes == 0) {echo "--";}  else {echo "<b>$display_fifth_finishes</b>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\"width: 24px; border-left: 1px solid #909090;\">"; if ($display_sixth_finishes == 0) {echo "--";}  else {echo "<b>$display_sixth_finishes</b>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\"width: 24px; border-left: 1px solid #909090;\">"; if ($display_seven_finishes == 0) {echo "--";}  else {echo "<b>$display_seven_finishes</b>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\"width: 24px; border-left: 1px solid #909090;\">"; if ($display_eight_finishes == 0) {echo "--";}  else {echo "<b>$display_eight_finishes</b>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\"width: 24px; border-left: 1px solid #909090;\">"; if ($display_ninth_finishes == 0) {echo "--";}  else {echo "<b>$display_ninth_finishes</b>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\"width: 24px; border-left: 1px solid #909090;\">"; if ($display_tenth_finishes == 0) {echo "--";}  else {echo "<b>$display_tenth_finishes</b>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\"width: 30px; border-left: 1px solid #909090;\">"; if ($display_bonus_points == 0  ) {echo "--";}  else {echo "<b>$display_bonus_points</b>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\"width: 55px; border-right: 1px solid #909090; border-left: 1px solid #909090;\">"; if ($display_total_points == 0)   {echo "--";}  else {echo number_format(round($display_total_points,2),2);}   echo "</td>\n";
   echo "  </tr>\n";


   $v++;

   $winners_check = $display_total_points;
 }
 
 $u = 0;
 $top = 0;
 $winners_check = 0;
 while ($u < $other_num && $competition != "yes") {
   $display_id             = $other_array[$u][0];
   $display_name           = $other_array[$u][1];
   list($display_first, $display_last, $display_suffix) = explode(" ", $display_name);
   $display_first_letter = $display_name{0};
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
   $display_six_ten_fin    = $other_array[$u][16];

   echo "  <tr onmouseover=\"hilight(this, '#daa520')\" onmouseout=\"hilight(this, '')\">\n";
   echo "    <td align=\"right\" style=\"width: 30px; border-left: 1px solid #909090;\">&nbsp;&nbsp;</td>\n";
   echo "    <td style=\"width: 115px;";
   echo "\"><a href=\"player_info.php?id=$display_id";
   echo "&start=$start_date&end=$end_date"; 
   echo "\">$display_name</a>&nbsp;&nbsp;</td>\n";
   echo "    <td align=\"center\" style=\"width: 30px; border-left: 1px solid #909090;\">"; if ($display_total_games    == 0) {echo "--";}  else {echo "<b>$display_total_games</b>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\"width: 24px; border-left: 1px solid #909090;\">"; if ($display_first_finishes == 0) {echo "--";}  else {echo "<b>$display_first_finishes</b>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\"width: 24px; border-left: 1px solid #909090;\">"; if ($display_secon_finishes == 0) {echo "--";}  else {echo "<b>$display_secon_finishes</b>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\"width: 24px; border-left: 1px solid #909090;\">"; if ($display_third_finishes == 0) {echo "--";}  else {echo "<b>$display_third_finishes</b>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\"width: 24px; border-left: 1px solid #909090;\">"; if ($display_fourt_finishes == 0) {echo "--";}  else {echo "<b>$display_fourt_finishes</b>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\"width: 24px; border-left: 1px solid #909090;\">"; if ($display_fifth_finishes == 0) {echo "--";}  else {echo "<b>$display_fifth_finishes</b>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\"width: 24px; border-left: 1px solid #909090;\">"; if ($display_sixth_finishes == 0) {echo "--";}  else {echo "<b>$display_sixth_finishes</b>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\"width: 24px; border-left: 1px solid #909090;\">"; if ($display_seven_finishes == 0) {echo "--";}  else {echo "<b>$display_seven_finishes</b>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\"width: 24px; border-left: 1px solid #909090;\">"; if ($display_eight_finishes == 0) {echo "--";}  else {echo "<b>$display_eight_finishes</b>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\"width: 24px; border-left: 1px solid #909090;\">"; if ($display_ninth_finishes == 0) {echo "--";}  else {echo "<b>$display_ninth_finishes</b>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\"width: 24px; border-left: 1px solid #909090;\">"; if ($display_tenth_finishes == 0) {echo "--";}  else {echo "<b>$display_tenth_finishes</b>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\"width: 30px; border-left: 1px solid #909090;\">"; if ($display_bonus_points == 0  ) {echo "--";}  else {echo "<b>$display_bonus_points</b>";} echo "</td>\n";
   echo "    <td align=\"center\" style=\"width: 55px; border-right: 1px solid #909090; border-left: 1px solid #909090;\">"; if ($display_total_points == 0)   {echo "--";}  else {echo number_format(round($display_total_points,2),2);}   echo "</td>\n";
   echo "  </tr>\n";


   $u++;

   $winners_check = $display_total_points;
 }

 }

 echo "</table>\n";
 echo "</center>\n";
 echo "<script type=\"text/javascript\" src=\"modify.js\"></script>\n";
 echo "</body>\n";
 echo "</html>\n";
 
// }

?>