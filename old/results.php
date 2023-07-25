<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?PHP

 include("dates.php");
 include("dbinfo.php");

 if (ISSET($_GET['date'])) {
   $t_date     = $_GET['date'];
   $t_location = $_GET['location'];
 }

 echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\"> \n";
 echo "<head>\n";

 echo "<script type=\"text/javascript\">\n";
 echo "<!--\n";
 echo "function hilight(obj, Color) {\n";
 echo "    obj.style.backgroundColor = Color;\n";
 echo "}\n\n";
 echo "// -->\n";
 echo "</script>\n";

 echo "<link rel=\"stylesheet\" href=\"doolys.css\" type=\"text/css\" />\n";
 echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
 echo "<title>Dooly&#39;s Poker Tournament Schedule</title>\n";

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


 $query = "SELECT *
           FROM points
           WHERE date = '$t_date' AND location = '$t_location' AND player_id != '2886'
           ORDER BY bubble ASC, finish ASC, id ASC";
 $result = mysqli_query($conn, $query);
 
  // Finds the Day of the Week
 $li_time = strtotime($t_date);
 $day_of_week_num = date("w",$li_time);
 $day_array = array("0" => "<b>SUNDAY</b>",
                    "1" => "<b>MONDAY</b>",
                    "2" => "<b>TUESDAY</b>",
                    "3" => "<b>WEDNESDAY</b>",
                    "4" => "<b>THURSDAY</b>",
                    "5" => "<b>FRIDAY</b>",
                    "6" => "<b>SATURDAY</b>");
 $day_of_week = strtr($day_of_week_num, $day_array);
          

 echo "$day_of_week ($t_date) - $result_num Players<br />\n";
   
 echo "<table border=\"1\" cellspacing=\"0\" cellpadding=\"0\">\n";
 echo "  <tr>\n";
 echo "    <td valign=\"top\"><table border=\"0\" cellspacing=\"0\" cellpadding=\"1\">\n";

 $r = 0;
 while ($row3 = mysqli_fetch_assoc($result)) {
   echo "      <tr>\n";
   echo "        <td align=\"right\">"; if ($row3["finish"] == 0) {echo "&nbsp;&nbsp;";} else {echo $row3["finish"]; echo ".&nbsp;";} echo "</td>\n";
   echo "        <td align=\"left\">".$row3["player_name"]."</td>\n";
   echo "        <td align=\"left\">".$row3["player_name"]."</td>\n";
   echo "      </tr>\n";

   $r++;
   if ($r % 20 == 0) {
     echo "    </table></td>\n    <td valign=\"top\">\n";
     echo "    <table border=\"0\" cellspacing=\"0\" cellpadding=\"1\">\n";
    }
 
 }

 echo "    </table></td>\n";
 echo "  </tr>\n";
 echo "</table>\n";

 echo "<script type=\"text/javascript\" src=\"modify.js\"></script>\n";
 echo "</body>\n";
 echo "</html>\n";

?>