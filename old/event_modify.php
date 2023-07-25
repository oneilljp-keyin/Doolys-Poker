<?

 $id     = $_GET['id'];

 if (EMPTY($id)) {
   $id   = $_POST['id'];
 }

 $slash_replace = array("\"" => "&#34;", "'" => "&#39;", "," => "&#44;");

 include("dbinfo.php");

 $update = $_POST['update'];

 if ($id != 0) {
   $page_title = "Event Update";
 } else {
   $page_title = "Event Entry";
 }

 echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\"> \n";
 echo "<head>\n";
 echo "<link rel=\"stylesheet\" href=\"doolys.css\" type=\"text/css\" />\n";
 echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
 echo "<title>Change Tournament Information</title>\n";

 echo "<style type=\"text/css\">\n";
?>

 <!--
  body {background-color: #FFFFFF;}
 -->
 </style>

<?php
 echo "</head>\n";

 echo "<body><table style=\"width: 100%;\"><tr><td align=\"center\">\n";

 mysql_connect($host,$username,$password);
 @mysql_select_db($database) or die("Unable to select database from event_modify.php");

 if ($update == 1) {

   $i_id           = $_POST['id'];
   $i_date         = $_POST['date'];
   $i_time         = $_POST['time'];
     list($i_hour, $i_min) = split(":", $i_time);
   $i_am_pm        = $_POST['am_pm'];
     if($i_am_pm == 1) {$i_hour += 12; $i_time = $i_hour.":".$i_min;}
   $i_location     = $_POST['location'];
   $i_type         = $_POST['type'];
   $i_charity      = $_POST['charity'];
   $i_td1          = $_POST['td1'];
   $i_td2          = $_POST['td2'];
     $i_td = $i_td1.",".$i_td2;
   $i_players      = $_POST['players'];
   $i_freerolls    = $_POST['freerolls'];
   $i_issued       = $_POST['issued'];
   $i_ticket       = $_POST['ticket'];

   $i_players      = strtr($i_players, $slash_replace);

   if ($i_id != 0) {
     $update_query  = "UPDATE tournaments SET
                       date          = '$i_date',
                       time          = '$i_time',
                       location      = '$i_location',
                       type          = '$i_type',
                       charity       = '$i_charity',
                       issued        = '$i_issued',
                       players       = '$i_players',
                       freerolls     = '$i_freerolls',
                       ticket_num    = '$i_ticket',
                       td            = '$i_td'
                       WHERE id = '$i_id'";
   } else {
     $update_query = "INSERT INTO tournaments
                      VALUES ('','$i_date','$i_time','$i_location','$i_type','$i_charity','','$i_td','','','','$i_issued','$i_ticket')";
   }

   $update_result = mysql_query($update_query);

   if (!$update_result) {
     echo "Invalid query: ". mysql_error();
   } else {
     echo "$page_title Complete<br />\n";
     echo "$i_date $i_time - $i_location - $i_type - $i_charity - $i_td - $i_entered - $i_players - $i_issued - $i_ticket<br />\n";
     echo "<a href=\"\" onclick=\"CloseRefresh('tournaments.php'); return false\">Close Window</a><br />\n";
   }

 } else if ($id != 0 && $id != -1) {

   $tournament_query  = "SELECT *
                         FROM tournaments
                         WHERE id = '$id'";
   $tournament_result = mysql_query($tournament_query);
   $tournament_num    = mysql_numrows($tournament_result);

   $i_id           = mysql_result($tournament_result, 0, "id");
   $i_date         = mysql_result($tournament_result, 0, "date");
   $i_time         = mysql_result($tournament_result, 0, "time");
     list ($i_hour, $i_minute, $i_second) = split(":", $i_time);
     if ($i_hour > 12) {$i_hour = $i_hour - 12; $am_pm = "PM";}
   $i_location     = mysql_result($tournament_result, 0, "location");
   $i_type         = mysql_result($tournament_result, 0, "type");
   $i_charity      = mysql_result($tournament_result, 0, "charity");
   $i_td           = mysql_result($tournament_result, 0, "td");
   list($i_td1, $i_td2) = split(",", $i_td);
   $i_entered      = mysql_result($tournament_result, 0, "entered");
   $i_players      = mysql_result($tournament_result, 0, "players");
   $i_freerolls    = mysql_result($tournament_result, 0, "freerolls");
   $i_issued       = mysql_result($tournament_result, 0, "issued");
   $i_ticket       = mysql_result($tournament_result, 0, "ticket_num");

 }

 if ($update != 1 || $id == -1) {

 echo "<a href=\"javascript:window.close();\">Close Window</a><br />\n";
 echo "<form action=\"event_modify.php\" method=\"post\">\n";
 echo "<div>";
 if ($id != 0 && $id != -1) {
   echo "<input type=\"hidden\" name=\"id\" value=\"$id\" />\n";
 }
 echo "<input type=\"hidden\" name=\"update\" value=\"1\" />\n";
 echo "<table class=\"titles\" cellpadding=\"0\" cellspacing=\"0\" style=\"background-color: #FFFFFF; color: #000000;\">\n";
 echo "  <tr>\n";
 echo "    <td align=\"right\">Date:&nbsp;</td>\n";
 echo "    <td align=\"left\"><input type=\"text\" name=\"date\" size=\"10\" value=\""; if ($id == -1) {echo "YYYY-MM-DD";} else {echo "$i_date";} echo "\" /></td>\n";
 echo "    <td align=\"right\">&nbsp;&nbsp;Time:&nbsp;</td>\n";
 echo "    <td align=\"left\"><input type=\"text\" name=\"time\" size=\"4\" value=\""; if ($id == -1) {echo "HH:MM";} else {echo "$i_hour:$i_minute";} echo "\" />\n";
 echo "      &nbsp;<b>AM</b><input type=\"radio\" name=\"am_pm\" value=\"0\""; if ($id == -1) {} else if ($i_time <  "12:00:00") {echo " checked=\"checked\"";} echo " />\n";
 echo "      &nbsp;<b>PM</b><input type=\"radio\" name=\"am_pm\" value=\"1\""; if ($id == -1) {} else if ($i_time >= "12:00:00") {echo " checked=\"checked\"";} echo " /></td>\n";
 echo "    <td align=\"right\">&nbsp;&nbsp;Location:&nbsp;</td>\n";
 echo "    <td align=\"left\"><select size=\"1\" name=\"location\">\n";
 echo "      <option";             if ($id == -1) {echo " selected=\"selected\"";} echo ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;----&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>\n";
 echo "      <option value=\"1\""; if ($id != -1 && $i_location == 1) {echo " selected=\"selected\"";} echo ">Topsail</option>\n";
 echo "      <option value=\"2\""; if ($id != -1 && $i_location == 2) {echo " selected=\"selected\"";} echo ">Kenmount</option>\n";
 echo "      <option value=\"3\""; if ($id != -1 && $i_location == 3) {echo " selected=\"selected\"";} echo ">Water St.</option></select></td>\n";
 echo "  </tr>\n";
 echo "  <tr>\n";
 echo "    <td align=\"right\">&nbsp;&nbsp;Type:&nbsp;</td>\n";
 echo "    <td align=\"left\" colspan=\"2\"><select size=\"1\" name=\"type\">\n";
 echo "      <option";             if ($id == -1) {echo " selected=\"selected\"";} echo ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;------------&nbsp;&nbsp;&nbsp;&nbsp;</option>\n";
 echo "      <option value=\"1\""; if ($id != -1 && $i_type == 1) {echo " selected=\"selected\"";} echo ">$20 Freezeout</option>\n";
 echo "      <option value=\"3\""; if ($id != -1 && $i_type == 3) {echo " selected=\"selected\"";} echo ">$50 Freezeout</option>\n";
 echo "      <option value=\"4\""; if ($id != -1 && $i_type == 4) {echo " selected=\"selected\"";} echo ">$40-$40-$40</option>\n";
 echo "      <option value=\"2\""; if ($id != -1 && $i_type == 2) {echo " selected=\"selected\"";} echo ">$20-$15-$20</option></select></td>\n";
 echo "    <td align=\"right\">&nbsp;&nbsp;Charity:&nbsp;\n";
 echo "      &nbsp;<b>YES</b><input type=\"radio\" name=\"charity\" value=\"1\""; if ($id == -1) {} else if ($charity == 1) {echo " checked=\"checked\"";} echo " />\n";
 echo "      &nbsp;<b>NO</b><input type=\"radio\" name=\"charity\" value=\"0\""; if ($id == -1) {} else if ($charity == 0) {echo " checked=\"checked\"";} echo " /></td>\n";
 echo "    <td align=\"right\">&nbsp;&nbsp;TD #1:&nbsp;</td>\n";
 echo "    <td align=\"left\"><select size=\"1\" name=\"td1\">\n";
 echo "      <option value=\"0\""; if ($id == -1) {echo " selected=\"selected\"";} echo ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>\n";

 $td_query  = "SELECT *
               FROM players
               WHERE td = '1'
               ORDER BY name ASC";
 $td_result = mysql_query($td_query);
 $td_num    = mysql_numrows($td_result);
 

 $b = 0;
 $c = 0;
 while ($b < $td_num) {
   $td_id    = mysql_result($td_result, $b, "id");
   $td_name  = mysql_result($td_result, $b, "name");

   echo "          <option value=\"$td_id\""; if ($i_td1 == $td_id) {echo " selected=\"selected\"";} echo ">$td_name</option>\n";
   $b++;
 }
 echo "    </select></td>\n";
 echo "  </tr>\n";
 echo "  <tr>\n";
 echo "    <td align=\"right\">&nbsp;&nbsp;Ticket #:&nbsp;</td>\n";
 echo "    <td align=\"left\" colspan=\"3\"><input type=\"text\" name=\"ticket\" size=\"4\" value=\""; if ($id == -1) {echo "HH:MM";} else {echo "$i_ticket";} echo "\" />\n";
 echo "      &nbsp;Issued?:\n";
 echo "      &nbsp;<b>YES</b><input type=\"radio\" name=\"issued\" value=\"1\""; if ($i_issued == 1) {echo " checked=\"checked\"";} echo " />\n";
 echo "      &nbsp;<b>NO</b><input type=\"radio\" name=\"issued\" value=\"0\""; if ($i_issued == 0) {echo " checked=\"checked\"";} echo " /></td>\n";
 echo "    <td align=\"right\">&nbsp;&nbsp;TD #2:&nbsp;</td>\n";
 echo "    <td align=\"left\"><select size=\"1\" name=\"td2\">\n";
 echo "      <option value=\"0\""; if ($id == -1) {echo " selected=\"selected\"";} echo ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>\n";

 while ($c < $td_num) {
   $td_id    = mysql_result($td_result, $c, "id");
   $td_name  = mysql_result($td_result, $c, "name");

   echo "          <option value=\"$td_id\""; if ($i_td2 == $td_id) {echo " selected=\"selected\"";} echo ">$td_name</option>\n";
   $c++;
 }

 echo "    </select></td>\n";
 echo "  </tr>\n";
 echo "  <tr>\n";
 echo "    <td align=\"right\">&nbsp;&nbsp;Players:&nbsp;</td>\n";
 echo "    <td align=\"left\"><input type=\"text\" name=\"players\" size=\"4\" value=\"$i_players\" /></td>\n";
 echo "    <td align=\"right\">&nbsp;</td>\n";
 echo "    <td align=\"right\">&nbsp;</td>\n";
 echo "    <td align=\"right\">&nbsp;&nbsp;Freerolls:&nbsp;</td>\n";
 echo "    <td align=\"left\"><input type=\"text\" name=\"freerolls\" size=\"4\" value=\"$i_freerolls\" /></td>\n";
 echo "  </tr>\n";
 echo "  <tr>\n";
 echo "    <td colspan=\"8\" align=\"center\"><input type=\"submit\" value=\"Submit\" style=\"border-right: solid 1px #00BBEC;\n";
 echo "    border-left: solid  1px #00BBEC; border-top: solid 1px #00BBEC; border-bottom: solid 1px #00BBEC;\n";
 echo "    font-family: Times New Roman; font-size: 10pt; color: #00BBEC; font-weight: bold; background-color: #FFFFFF\" /></td>\n";
 echo "  </tr>\n";
 echo "</table>\n";
 echo "</div>\n";
 echo "</form>\n";

 }

 mysql_close();

 echo "</td></tr></table></body></html>";

?>
