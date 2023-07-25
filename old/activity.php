<?PHP

 include("dbinfo.php");

 mysql_connect($host,$username,$password);
 @mysql_select_db($database) or die("Unable to select database from activity.php");
 
 $players_query     = "SELECT *
                       FROM players
                       WHERE doolysnum = '0' 
                       ORDER BY name ASC";
 $players_result    = mysql_query($players_query);
 $players_num       = mysql_numrows($players_result);
 
 echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"0\">";
 echo "  <tr>";
 echo "    <td width=\"150\"><b>Name:</b></td>";
 echo "    <td width=\"100\"><b>Active:</b></td>";
 echo "  </tr>";

 $p = 0;
 while ($p < $players_num) {
   $p_id   = mysql_result($players_result, $p, "id");
   $p_name = mysql_result($players_result, $p, "name");

   $activity_query     = "SELECT *
                          FROM points
                          WHERE player_id = '$p_id' AND date >= '2010-09-19'
                          ORDER BY date ASC";
   $activity_result    = mysql_query($activity_query);
   $activity_num       = @mysql_numrows($activity_result);
   
   if ($activity_num == 0) {
     $update_query  = "UPDATE players SET
                       inactive = '1'
                       WHERE id = '$p_id'";
     $update_result = mysql_query($update_query);
     if (!$update_result) {
       echo "Invalid query: ". mysql_error();
     }
   }
   
   echo "<tr><td>$p_name</td><td>"; if ($activity_num == 0) {echo "<b>NO</b>";} else {echo "<b>YES</b>";}
   $p++;
 }
   
?>


