<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<?php

  $start_date = $_GET['start'];
  $end_date   = $_GET['end'];

 include("dbinfo.php");
 
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
  
  if (!ISSET($_GET['start'])) {
    echo "Enter &quot;start&quot; and &quot;end&quot; dates in address bar<br />\n";
  } else {

    $jackpot_total  = 0;
    $jackpot_result = $conn->query(
                      "SELECT jackpot
                       FROM tournaments
                       WHERE date >= '$start_date' AND date <= '$end_date'");
    while ($row_jp = $jackpot_result->fetch_assoc()) {
      $jackpot_total += $row_jp["jackpot"];
    }
//    echo $jackpot_total."<br />\n";
    
    $points_result = $conn->query(
                     "SELECT *
                      FROM points
                      WHERE date >= '$start_date' AND date <= '$end_date' AND player_id != '2886'
                      AND player_id != '1' AND player_id != '3' AND player_id != '6'
                      AND player_id != '490' AND player_id != '530'
                      ORDER BY player_name ASC, player_id ASC");


    $id_check = 0;
    $money_in = 0;
    $p = 0;
    $q = 0;
    echo "<table cellpadding=\"0\" cellspacing =\"0\" border=\"0\"><tr><td valign=\"top\">\n";
    echo "<table cellpadding=\"4\" cellspacing =\"0\" border=\"0\"><tr>\n";
    while ($row4 = $points_result->fetch_assoc()) {
      if ($id_check != $row4["player_id"] && $p != 0) {
        echo "<tr><td>$name</td>\n";
        echo "<td>$money_in (".sprintf("%0.2f", round(($money_in/$jackpot_total) * 100, 2)).")</td></tr>\n";
        $money_in = 0;
        $q++;
      }
      $money_in += 10;
      $id_check = $row4["player_id"];
      $name = $row4["player_name"];
      $p++;
      if ($q == 30 || $q == 60 || $q == 90 || $q == 120 || $q == 150 || $q == 180) {echo "</table></td><td valign=\"top\"><table cellpadding=\"4\" cellspacing =\"0\" border=\"0\"><tr>\n";}
    }
    echo "</table>\n";
  }

  echo "</center>\n";
  echo "</body>\n";
  echo "</html>\n";
?>
