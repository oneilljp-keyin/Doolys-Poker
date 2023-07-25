<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<?php

$password  = $_GET['password'];

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

 echo "&nbsp;<br />\n";
 echo "&nbsp;<br />\n";
 echo "&nbsp;<br />\n";

if ($password == "beta36pi") {

 echo "<a href=\"point_entry.php?places=10\">Point Entry</a><br />\n";
 echo "<a href=\"point_totals.php\">Point Totals</a><br />\n";
 echo "<a href=\"tournaments.php\">Tournament Schedule</a><br />\n";

 } else {

 echo "SORRY";

 }

 echo "</center>\n";
 echo "</body>\n";
 echo "</html>\n";
?>
