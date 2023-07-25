<?PHP

 include("dbinfo.php");

 mysql_connect($host,$username,$password);
 @mysql_select_db($database) or die("Unable to select database from point_entry.php");

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
                      "2" => "<b class=\"ecw\">\$20-$15-$20</b>",
                      "3" => "<b class=\"raw\">\$40-$40-$40</b>",
                      "4" => "<b>\$50 Freezeout</b>",
                      "5" => "<b class=\"snme\">\$100 Freezeout</b>");

 if (ISSET($_POST['tournament'])) {
   $tournament  = $_POST['tournament'];
     list($t_id, $t_date, $t_location, $t_type) = split(",", $tournament);
   $td1           = $_POST['td1'];
   $td2           = $_POST['td2'];
   $td            = $td1.",".$td2;
   $num_players   = $_POST['num_players'];
   $num_freerolls = $_POST['num_freerolls'];
   $places_paid   = $_POST['places'];
   $charity       = $_POST['charity'];

   $update_query  = "UPDATE tournaments SET
                     players   = '$num_players',
                     freerolls = '$num_freerolls',
                     td        = '$td',
                     charity   = '$charity'
                     WHERE id  = '$t_id'";
   $update_result = mysql_query($update_query);
   if (!$update_result) {
     echo "<span style=\"color: #FFFFFF;\">Invalid Update Tournament Query:<br />". mysql_error()."</span>";
     echo "$t_id, $t_date, $t_location, $t_type, $td, $num_players, $num_freerolls, $places_paid, $charity<br />";
   } else {
     echo "$t_id, $t_date, $t_location, $t_type, $td, $num_players, $num_freerolls, $places_paid, $charity<br />";
   }

   $num = 0;
   $finish = 1;
   while ($num < $places_paid) {
     $new_playername    = "new_playername_" .$num;
     $entry_player_name = $_POST[$new_playername];
     if ($entry_player_name == "" || EMPTY($entry_player_name)) {
       $player       = "player_" .$num;
       $entry_player = $_POST[$player];
       list($entry_player_id, $entry_player_num, $entry_player_name) = split(",", $entry_player);
     } else {
       $entry_player_name = strtr($entry_player_name, $slash_replace);
       $new_playernum    = "new_playernum_" .$num;
       $entry_player_num = $_POST[$new_playernum];

       if ($entry_player_name == "" || EMPTY($entry_player_name)) {} else {
         $new_player_query = "INSERT INTO players VALUES
                              ('','$entry_player_name', '$entry_player_num','','','')";
         $new_player_result = mysql_query($new_player_query);
         $entry_player_id   = mysql_insert_id();
       }

       if (!$new_player_result) {
         echo "Invalid query: ". mysql_error()."";
       }
     }

     if ($entry_player_name == "EXISTING PLAYERS" || EMPTY($entry_player_name) || $entry_player_name == "") {} else {
       $entry_player_name = strtr($entry_player_name, $slash_replace);
       $numplayers = $num_players + $num_freerolls;
       $entry_query = "INSERT INTO points VALUES
                       ('','$entry_player_id', '$entry_player_name', '$entry_player_num', '$t_date', '$t_location', '$t_type', '$numplayers', '$finish')";
       $entry_result = mysql_query($entry_query);
       if (!$entry_result) {
         echo "<span style=\"color: #FFFFFF;\">Invalid Player Query: ". mysql_error()."</span>";
       }
     }
   $finish++;
   $num++;
   }
   $update_query  = "UPDATE tournaments SET
                     entered  = '1'
                     WHERE id = '$t_id'";
   $update_result = mysql_query($update_query);
   if (!$update_result) {
     echo "Invalid query: ". mysql_error();
   }

   echo "<span class=\"header2\" style=\"color: black;\">ENTRY COMPLETE</span><br />\n";
   echo "<a href=\"point_entry.php\">Click Here To Enter Another Tournament</a>\n";
 }

 $tournament_query  = "SELECT *
                       FROM tournaments
                       WHERE entered = '0' AND date >= '2009-09-13' AND date <= '2009-12-19'
                       ORDER BY date ASC, TIME ASC";
 $tournament_result = mysql_query($tournament_query);
 $tournament_num    = mysql_numrows($tournament_result);
 
 $players_query     = "SELECT *
                       FROM players
                       ORDER BY name ASC";
 $players_result    = mysql_query($players_query);
 $players_num       = mysql_numrows($players_result);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php

 echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\"> \n";
 echo "<head>\n";
 echo "<link rel=\"stylesheet\" href=\"doolys.css\" type=\"text/css\" />\n";
 echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
 echo "<title>Point Entry</title>\n";
 
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
 
 if (!ISSET($_POST['tournament'])) {
   echo "<form action=\"point_entry.php\" method=\"post\">\n";
   echo "<table class=\"titles\" cellspacing=\"0\" cellpadding=\"1\">\n";
   echo "  <tr>\n";
   echo "    <td align=\"center\"><b>SELECT A TOURNAMENT</b><br />\n";
   echo "    <select name=\"tournament\">\n";

   $j = 0;
   while ($j < $tournament_num) {
     $t_id     = mysql_result($tournament_result, $j, "id");
     $date     = mysql_result($tournament_result, $j, "date");
       list($l_year, $l_month, $l_day) = split("-", $date);
       $li_time = strtotime($date);
       $day_num = date("w",$li_time);
       $day_array2 = array("0" => "Sunday&nbsp;&nbsp;&nbsp;",
                           "1" => "Monday&nbsp;&nbsp;&nbsp;",
                           "2" => "Tuesday&nbsp;&nbsp;",
                           "3" => "Wednesday",
                           "4" => "Thursday&nbsp;",
                           "5" => "Friday&nbsp;&nbsp;&nbsp;",
                           "6" => "Saturday&nbsp;");
       $l_day_of_week = strtr($day_num, $day_array2);
     $location = mysql_result($tournament_result, $j, "location");
       $location_name = strtr($location, $location_names);
     $type     = mysql_result($tournament_result, $j, "type");
       $tourny_type = strtr($type, $tourn_types);

     echo "    <option style=\"font-family: Courier; font-size: 14px;";
       if ($location == 2) echo " background-color: #00BBEC; color: white;";
       if ($location == 3) echo " background-color: #00CC00; color: white;";
       echo "\" value=\"$t_id,$date,$location,$type\">$l_day_of_week, "; echo strtr($l_month, $change_month2); echo" $l_day, $l_year - $location_name - $tourny_type</option>\n";
     $j++;
   }

   echo "    </select><br /><b>CHARITY EVENT?</b> <input type=\"checkbox\" name=\"charity\" value=\"1\"></td>\n";
   echo "  </tr>\n";
   echo "  <tr>\n";

   echo "    <td align=\"center\"><b>TOURNAMENT DIRECTOR(S)</b><br />\n";
   echo "    <select name=\"td1\">\n";
   echo "    <option value=\"0\" selected=\"selected\">SELECT A TD</option>\n";

   $k = 1;
   while ($k < $players_num) {
     $td_check     = mysql_result($players_result, $k, "td");
     if ($td_check == 1) {
       $td_id   = mysql_result($players_result, $k, "id");
       $td_name = mysql_result($players_result, $k, "name");

       echo "    <option value=\"$td_id\">$td_name</option>\n";
     }
     $k++;
   }

   echo "    </select>&nbsp;&nbsp;\n";
   echo "    <select name=\"td2\">\n";
   echo "    <option value=\"0\" selected=\"selected\">SELECT A TD</option>\n";

   $j = 1;
   while ($j < $players_num) {
     $td_check     = mysql_result($players_result, $j, "td");
     if ($td_check == 1) {
       $td_id   = mysql_result($players_result, $j, "id");
       $td_name = mysql_result($players_result, $j, "name");

       echo "    <option value=\"$td_id\">$td_name</option>\n";
     }
     $j++;
   }

   echo "    </select></td>\n";
   echo "  </tr>\n";
   echo "  <tr>\n";
   echo "    <td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" style=\"border: 0px;\"><tr><td align=\"center\"><b>NUMBER OF PLAYERS</b></td>\n";
   echo "    <td align=\"center\">&nbsp;&nbsp;<input class=\"small\" type=\"text\" name=\"num_players\" /></td><td>&nbsp;<b>+</b>&nbsp;</td><td align=\"center\"><b>NUMBER OF FREEROLLS</b></td>\n";
   echo "    <td align=\"center\">&nbsp;&nbsp;<input class=\"small\" type=\"text\" name=\"num_freerolls\" /></td></tr></table></td>\n";
   echo "  </tr>\n";
   echo "  <tr>\n";
   echo "    <td align=\"center\"><b>PLACES PAID</b><br />\n";
   echo "    <input class=\"small\" type=\"text\" name=\"places\" /></td>\n";
   echo "  </tr>\n";
   echo "</table>\n";

   echo "<table class=\"titles\" cellspacing=\"0\" cellpadding=\"1\">\n";
   echo "  <tr>\n";
   echo "    <td>&nbsp;</td>\n";
   echo "    <td align=\"center\"><b>NEW PLAYER</b></td>\n";
   echo "    <td align=\"center\"><b>DOOLYS #</b></td>\n";
   echo "  </tr>\n";


   $g = 0;
   $place = 1;
   while ($g < 10) {
     echo "  <tr>\n";
     echo "    <td><input type=\"hidden\" name=\"place_$place\" value=\"$place\" />"; if ($place < 10) {echo "&nbsp;&nbsp;";} echo "$place.\n";

     echo "    <select name=\"player_$g\">\n";
     echo "    <option selected=\"selected\">EXISTING PLAYERS</option>";
     $p = 0;
     while ($p < $players_num) {
       $p_id   = mysql_result($players_result, $p, "id");
       $p_name = mysql_result($players_result, $p, "name");
       $p_mem  = mysql_result($players_result, $p, "doolysnum");

       echo "\n    <option value=\"$p_id,$p_mem,$p_name\">$p_name"; if ($p_mem != 0) {echo " - "; if ($p_mem < 1000) {echo "0";} echo "$p_mem"; } echo "</option>";
       $p++;
     }
     echo "    </td>\n";
     echo "    <td><input class=\"large\" type=\"text\" name=\"new_playername_$g\" /></td>\n";
     echo "    <td><input class=\"med\" type=\"text\" name=\"new_playernum_$g\" /></td>\n";
     echo "  </tr>\n";
     $g++;
     $place++;
   }

   echo "  <tr>\n";
   echo "    <td align=\"center\" colspan=\"9\"><input class=\"large\" type=\"submit\" value=\"Submit\" style=\"border-right: solid 1px #000000;\n";
   echo "     border-left: solid  1px #000000; border-top: solid 1px #000000; border-bottom: solid 1px #000000;\n";
   echo "     font-family: Times New Roman; font-size: 10pt; color: #000000; font-weight: bold; background-color: #FFFFFF\" /></td>\n";
   echo "  </tr>\n";
   echo "</table>\n";
   echo "</form>\n";
 }
 
 echo "</center>\n";
 echo "<script type=\"text/javascript\" src=\"modify.js\"></script>\n";

?>
