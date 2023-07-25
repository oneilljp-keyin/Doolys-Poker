 <?PHP

 include("browser_detection.php");
 
 $version = browser_detection('number');

 $ip_address = $_SERVER['REMOTE_ADDR'];
 $show = $_GET['show'];

 $change_month = array("01" => "Jan", "02" => "Feb", "03" => "Mar", "04" => "Apr",
                       "05" => "May", "06" => "Jun", "07" => "Jul", "08" => "Aug",
                       "09" => "Sep", "10" => "Oct", "11" => "Nov", "12" => "Dec");

 $change_month2 = array("1" => "Jan",  "2" => "Feb",  "3" => "Mar",  "4" => "Apr",
                        "5" => "May",  "6" => "Jun",  "7" => "Jul",  "8" => "Aug",
                        "9" => "Sep", "10" => "Oct", "11" => "Nov", "12" => "Dec");

 $slash_replace = array("\\"" => "&#34;", "'" => "&#39;", "," => "&#44;");

 $td_names = array("1" => "Pat Drake",
                   "2" => "Sarah Mills",
                   "3" => "John O&#39;Neill",
                   "4" => "Chris Drover",
                   "5" => "Walter Tucker",
                   "6" => "Diane Tobin",
                   "7" => "Gary Kavanaugh",
                   "560" => "Steve Miller",
                   "670" => "Ray Hickey",
                   "332" => "Josh Randell",
                   "196" => "Dion Learning",
                   "804" => "Tom Fitzpatrick",
                   "638" => "Lee Escott");

 $location_names = array("1" => "Topsail",
                         "2" => "Kenmount",
                         "3" => "Water St.");

 $tourn_types = array("1" => "<b class=\\"sd\\" >\\$20 FO</b>",
                      "2" => "<b class=\\"ecw\\">\\$20 RB</b>",
                      "3" => "<b class=\\"raw\\">\\$40 RB</b>",
                      "4" => "<b>\\$50 FO</b>",
                      "5" => "<b class=\\"snme\\">\\$100 FO</b>");

 include("dbinfo.php");

 mysql_connect($host,$username,$password);
 @mysql_select_db($database) or die("Unable to select database from event_listing.php");

 $tournament_query  = "SELECT *
                       FROM tournaments
                       ORDER BY date ASC, TIME ASC";
 $tournament_result = mysql_query($tournament_query);
 $tournament_num    = mysql_numrows($tournament_result);

 $start_date = "2009-01-01";

 // Finds the Day of the Week
 $li_time = strtotime($start_date);
   $day_of_week_num = date("w",$li_time);
   $day_array = array("0" => "Sun",
                      "1" => "Mon",
                      "2" => "Tue",
                      "3" => "Wed",
                      "4" => "Thu",
                      "5" => "Fri",
                      "6" => "Sat");
 $day_of_week = strtr($day_of_week_num, $day_array);
 if($day_of_week_num != 0) {
   list($s_year, $s_month, $s_day) = split("-", $start_date);
   $start_date   = date("Y-m-d", mktime(0, 0, 0, $s_month, $s_day + (7 - $day_of_week_num), $s_year));
 }
   


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php

 echo "<html xmlns=\\"http://www.w3.org/1999/xhtml\\" xml:lang=\\"en\\" lang=\\"en\\"> \\n";
 echo "<head>\\n";

 echo "<script type=\\"text/javascript\\">\\n";
 echo "<!--\\n";

 echo "function popUpImage(img){\\n";
 echo "  image1= new Image();\\n";
 echo "  image1.src=(img);\\n";
 echo "  imageSize(img);\\n";
 echo "}\\n\\n";

 echo "function imageSize(img){\\n";
 echo "  if((image1.width!=0)&&(image1.height!=0)){\\n";
 echo "    viewImage(img);\\n";
 echo "  }\\n";
 echo "  else{\\n";
 echo "    funzione=\\"imageSize('\\"+img+\\"')\\";\\n";
 echo "    intervallo=setTimeout(funzione,20);\\n";
 echo "  }\\n";
 echo "}\\n\\n";

 echo "function viewImage(img){\\n";
 echo "  imageWidth=image1.width+30;\\n";
 echo "  imageHeight=image1.height+30;\\n";
 echo "  imageWindow=\\"width=\\"+imageWidth+\\",height=\\"+imageHeight;\\n";
 echo "  imagePopUp=window.open(img,\\"\\",imageWindow);\\n";
 echo "}\\n\\n";

 echo "function hilight(obj, Color) {\\n";
 echo "    obj.style.backgroundColor = Color;\\n";
 echo "}\\n\\n";
 echo "// -->\\n";
 echo "</script>\\n";

 echo "<link rel=\\"stylesheet\\" href=\\"doolys.css\\" type=\\"text/css\\" />\\n";
 echo "<meta http-equiv=\\"Content-Type\\" content=\\"text/html; charset=utf-8\\" />\\n";
 echo "<title>Dooly&#39;s Poker Tournament Schedule</title>\\n";

 echo "<style type=\\"text/css\\">\\n";
?>

 <!--
  body {background-color: #FFFFFF;}
 -->
</style>

<?php
 echo "</head>\\n";

 echo "<body>\\n";
 echo "<center>\\n";

 if ($show == "yes") {
   echo "<a href=\\"Javascript:onclick=entrypopup('event_modify.php?id=-1', 550, 130, 'enter_tournament');\\">Add A Tournament</a>\\n<br />";
 }
 echo "<table class=\\"titles\\" cellspacing=\\"0\\" cellpadding=\\"1\\" style=\\"background-color: #FFFFFF;\\">\\n";
 if ($version != '330/4.5.0.12') {
   echo "  <tr>\\n";
   echo "    <td style=\\"width: 30px;  border-bottom: solid 1px #FFFFFF;\\"><b>Date</b></td>\\n";
   echo "    <td style=\\"width: 24px;  border-bottom: solid 1px #FFFFFF;\\">&nbsp;</td>\\n";
   echo "    <td style=\\"width: 18px;  border-bottom: solid 1px #FFFFFF;\\">&nbsp;</td>\\n";
   echo "    <td style=\\"width: 26px;  border-bottom: solid 1px #FFFFFF;\\">&nbsp;</td>\\n";
   echo "    <td style=\\"width: 10px;  border-bottom: solid 1px #FFFFFF;\\" align=\\"center\\"><b>Plyrs</b></td>\\n";
   echo "  </tr>\\n";
 }
 echo "</table>\\n";

 if ($show == "yes") {
   echo "<div style=\\"overflow: auto; width: auto; height: 740px; table-layout: fixed;\\">\\n";
 } else {
   echo "<div style=\\"overflow: auto; width: auto; height: 740px; table-layout: fixed;\\">\\n";
 }

 echo "<table class=\\"titles\\" cellspacing=\\"0\\" cellpadding=\\"1\\" style=\\"background-color: #FFFFFF; border: 0px solid #000000;\\">\\n";

 $i=0;
 $date_check = "";
 $month_check = '';
 $year_check = 0;
 $dow_check = 6; 
 $am_pm = "AM";

 while ($i < $tournament_num) {
   $i_id           = mysql_result($tournament_result, $i, "id");
   $i_date         = mysql_result($tournament_result, $i, "date");
     list ($i_year, $i_month, $i_day) = split("-", $i_date);
     $i_month2 = strtr($i_month, $change_month);
   $i_time         = mysql_result($tournament_result, $i, "time");
     list ($i_hour, $i_minute, $i_second) = split(":", $i_time);
     if ($i_hour > 12) {$i_hour = $i_hour - 12; $am_pm = "PM";}
     $i_hour = $i_hour * 1;
   $i_location     = mysql_result($tournament_result, $i, "location");
   $i_type         = mysql_result($tournament_result, $i, "type");
   $i_charity      = mysql_result($tournament_result, $i, "charity");
   $i_td           = mysql_result($tournament_result, $i, "td");
     list($i_td1, $i_td2) = split(",", $i_td);
   $i_entered      = mysql_result($tournament_result, $i, "entered");
   $i_players      = mysql_result($tournament_result, $i, "players");
   $i_freerolls    = mysql_result($tournament_result, $i, "freerolls");
   $i_issued       = mysql_result($tournament_result, $i, "issued");
   $i_ticket       = mysql_result($tournament_result, $i, "ticket_num");
   
   $winner_query  = "SELECT player_id, player_name
                     FROM points
                     WHERE date = '$i_date' AND location = '$i_location' AND game_type = '$i_type' AND finish = '1'";
   $winner_result = mysql_query($winner_query);
   $winner_num    = mysql_numrows($winner_result);

   if ($winner_num  != 0) {
     $winner_id     = mysql_result($winner_result, 0, "player_id");
     $winner_name   = mysql_result($winner_result, 0, "player_name");
   }
   
   $day_color_array = array("0" => "FFFF00",
                            "1" => "FF0000",
                            "2" => "00CC00",
                            "3" => "FF9900",
                            "4" => "C1FF7D",
                            "5" => "00BBEC",
                            "6" => "0077FF");

   $current_date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
   $ili_time     = strtotime($current_date);
   $start_of_week = date("w",$ili_time);
   if ($start_of_week == 0) {$start_of_week = 7;}
   $begin_date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - $start_of_week, date("Y")));
   list($s_year, $s_month, $s_day) = split("-", $begin_date);
   $end_date   = date("Y-m-d", mktime(0, 0, 0, $s_month, $s_day + 7, $s_year));
   
   echo "  <tr>\\n";

   if ($date_check == $i_date) {
     echo "    <td valign=\\"top\\" style=\\"width: 30px;"; if ($day_of_week_num == 0 && $dow_check == 6) {echo " border-top: solid 2px #404040;";} echo "\\">&nbsp;</td>\\n";
     echo "    <td valign=\\"top\\" style=\\"width: 24px;"; if ($day_of_week_num == 0 && $dow_check == 6) {echo " border-top: solid 2px #404040;";} echo "\\">&nbsp;</td>\\n";
     echo "    <td valign=\\"top\\" style=\\"width: 18px;"; if ($day_of_week_num == 0 && $dow_check == 6) {echo " border-top: solid 2px #404040;";} echo "\\">&nbsp;</td>\\n";
     if ($version != '330/4.5.0.12') {
     echo "    <td valign=\\"top\\" style=\\"width: 26px;"; if ($day_of_week_num == 0 && $dow_check == 6) {echo " border-top: solid 2px #404040;";} echo "\\">&nbsp;</td>\\n";
     }
   } else {
     $date_check  = $i_date;

     echo "    <td valign=\\"top\\" style=\\"width: 30px;"; if ($day_of_week_num == 0 && $dow_check == 6) {echo " border-top: solid 2px #404040;";} echo "\\">$day_of_week, </td>\\n";
     echo "    <td valign=\\"top\\" style=\\"width: 24px;"; if ($day_of_week_num == 0 && $dow_check == 6) {echo " border-top: solid 2px #404040;";} echo "\\">";
       if ($month_check == $i_month) {echo "&nbsp;";} else {echo "$i_month2";}
     echo " </td>\\n";
     echo "    <td valign=\\"top\\" style=\\"width: 18px;"; if ($day_of_week_num == 0 && $dow_check == 6) {echo " border-top: solid 2px #404040;";} echo "\\">$i_day"; if ($version != '330/4.5.0.12') {echo ", ";} echo "</td>\\n";
     if ($version != '330/4.5.0.12') {
     echo "    <td valign=\\"top\\" style=\\"width: 26px;"; if ($day_of_week_num == 0 && $dow_check == 6) {echo " border-top: solid 2px #404040;";} echo "\\">$i_year";
     }
   }
   echo "</td>\\n";

//   if ($version != '330/4.5.0.12') {
//   echo "    <td valign=\\"top\\" align=\\"center\\" style=\\"width: 40px;"; if ($day_of_week_num == 6) {echo " border-bottom: solid 2px #404040;";} echo "\\">$i_hour:$i_minute $am_pm</td>\\n";
//   }

   echo "    <td valign=\\"top\\" align=\\"center\\" style=\\"width: 60px;"; if ($day_of_week_num == 0 && $dow_check == 6) {echo " border-top: solid 2px #404040;";} echo "\\">";
   if ($show == "yes") {echo "\\n    <a href=\\"Javascript:onclick=entrypopup('event_modify.php?id=$i_id', 550, 180, 'modify_tournament');\\">";}
   if ($version != '330/4.5.0.12') {
   echo strtr($i_location, $location_names);
   } else {
   if ($i_location == 1) {echo "Top";} else if ($i_location == 2) {echo "Ken";} else if ($i_location == 3) {echo "Wat";}
   }
   if ($show == "yes") {echo "</a>";}
   echo "</td>\\n";

   echo "    <td valign=\\"top\\" align=\\"center\\" style=\\"width: 50px;"; if ($day_of_week_num == 0 && $dow_check == 6) {echo " border-top: solid 2px #404040;";} echo "\\">";
   echo strtr($i_type, $tourn_types); echo "</a></td>\\n";
   echo "    <td valign=\\"top\\" align=\\"center\\" style=\\"width: 120px;"; if ($day_of_week_num == 0 && $dow_check == 6) {echo " border-top: solid 2px #404040;";} echo "\\">"; if ($i_td1 == "0") {echo "--";} else {echo strtr($i_td1, $td_names);} if ($i_td2 == "0") {} else {echo "<br />"; echo strtr($i_td2, $td_names);} echo "</td>\\n";

   if ($show == "yes") {
     echo "    <td valign=\\"top\\" align=\\"center\\" style=\\"width: 40px;"; if ($day_of_week_num == 0 && $dow_check == 6) {echo " border-top: solid 2px #404040;";} echo "\\">"; if ($i_ticket == "0") {echo "--";} else {echo "$i_ticket";} echo "</td>\\n";
     echo "    <td valign=\\"top\\" align=\\"center\\" style=\\"width: 40px;"; if ($day_of_week_num == 0 && $dow_check == 6) {echo " border-top: solid 2px #404040;";} echo "\\">"; if ($i_players == "0") {echo "--";} else {echo "$i_players";} echo "</td>\\n";
     echo "    <td valign=\\"top\\" align=\\"center\\" style=\\"width: 10px;"; if ($day_of_week_num == 0 && $dow_check == 6) {echo " border-top: solid 2px #404040;";} echo "\\">"; if ($i_freerolls == "0") {echo "--";} else {echo "$i_freerolls";} echo "</td>\\n";
     echo "    <td valign=\\"top\\" align=\\"center\\" style=\\"width: 130px;"; if ($day_of_week_num == 0 && $dow_check == 6) {echo " border-top: solid 2px #404040;";} echo "\\">"; if ($winner_id == "0") {echo "--";} else {echo "$winner_name";} echo "</td>\\n";
   }

   echo "  </tr>\\n";

   $year_check = $i_year;
   $month_check = $i_month;
   $winner_id = 0;
   $winner_name = "--";
   $dow_check = $day_of_week_num;

   $i++;
 }

 echo "</table>\\n</div>\\n";

 echo "<script type=\\"text/javascript\\" src=\\"modify.js\\"></script>\\n";

?>