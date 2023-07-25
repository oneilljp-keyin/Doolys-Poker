<?PHP

 include("dbinfo.php");

 mysql_connect($host,$username,$password);
 @mysql_select_db($database) or die("Unable to select database from event_listing.php");

 if ($_GET['sortby'] == "id_num") {
   $players_query  = "SELECT *
                       FROM players
                       WHERE inactive = '0'
                       ORDER BY id ASC";
 } else {
   $players_query  = "SELECT *
                       FROM players
                       WHERE inactive = '0'
                       ORDER BY name ASC";
 }
 $players_result = mysql_query($players_query);
 $players_num    = mysql_numrows($players_result);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php

 echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\"> \n";
 echo "<head>\n";
 echo "<link rel=\"stylesheet\" href=\"doolys.css\" type=\"text/css\" />\n";
 echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
 echo "<title>List Of Poker Players</title>\n";
 
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
 echo "<h2 style=\"color: #000000;\">Players List</h2>\n";
 echo "<table class=\"titles\" cellspacing=\"0\" cellpadding=\"1\" style=\"background-color: #FFFFFF;\">\n";
 echo "  <tr>\n";
 echo "    <td style=\"width: 150px; border-bottom: solid 1px #000000;\"><b><a href=\"players.php?sortby=name\">Name</a></b></td>\n";
 echo "    <td style=\"width: 50px;  border-bottom: solid 1px #000000;\" align=\"center\"><a href=\"players.php?sortby=id_num\"><b>ID #</b></a></td>\n";
 // echo "    <td style=\"width: 75px;  border-bottom: solid 1px #000000;\" align=\"center\"><b>Phone<br />#</b></td>\n";
 // echo "    <td style=\"width: 75px;  border-bottom: solid 1px #000000;\" align=\"center\"><b>Phone<br />#</b></td>\n";
 //  if ($players_num > 27) {
 //    echo "    <td style=\"width: 14px; border-bottom: solid 1px #000000;\">&nbsp;</td>\n";
 //  }
 echo "  </tr>\n";
 // echo "</table>\n";

 // echo "<div style=\"overflow: auto; width: 354px; height: 700px; table-layout: fixed;\">\n";

 // echo "<table class=\"titles\" cellspacing=\"0\" cellpadding=\"1\" style=\"background-color: #FFFFFF;\">\n";

 $i=0;
 while ($i < $players_num) {
   $i_id        = mysql_result($players_result, $i, "id");
   $i_name      = mysql_result($players_result, $i, "name");
//   $i_doolysnum = mysql_result($players_result, $i, "doolysnum");
//   $i_td        = mysql_result($players_result, $i, "td");
//   $i_phone1    = mysql_result($players_result, $i, "phone1");
//   $i_phone2    = mysql_result($players_result, $i, "phone2");

   echo "  <tr onmouseover=\"hilight(this, '#DAA520')\" onmouseout=\"hilight(this, '')\">\n";
   echo "    <td style=\"width: 150px;\"><a href=\"player_info.php?id=$i_id\">"; if ($i_td == 1) {echo "<b class=\"ecw\">";} echo "$i_name"; if ($i_td == 1) {echo "</b>";} echo "</a></td>\n";
   echo "    <td style=\"width: 50px; \" align=\"right\">$i_id</td>\n";
//   echo "    <td style=\"width: 75px; \" align=\"center\">$i_phone1</td>\n";
//   echo "    <td style=\"width: 75px; \" align=\"center\">$i_phone2</td>\n";
   echo "  </tr>\n";

   $i++;
 }

 echo "</table>\n";
// echo "</div>\n";

 echo "<script type=\"text/javascript\" src=\"modify.js\"></script>\n";

?>
