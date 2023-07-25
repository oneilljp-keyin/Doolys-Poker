<?PHP

include("browser_detection.php");
include("dates.php");
$version = browser_detection('number');

$ip_address = $_SERVER['REMOTE_ADDR'];
$show = $_GET['show'];
$jackpot_addon = $_GET['jackpot_addon'];


$change_month = array(
  "01" => "Jan", "02" => "Feb", "03" => "Mar", "04" => "Apr",
  "05" => "May", "06" => "Jun", "07" => "Jul", "08" => "Aug",
  "09" => "Sep", "10" => "Oct", "11" => "Nov", "12" => "Dec"
);

$change_month2 = array(
  "1" => "Jan",  "2" => "Feb",  "3" => "Mar",  "4" => "Apr",
  "5" => "May",  "6" => "Jun",  "7" => "Jul",  "8" => "Aug",
  "9" => "Sep", "10" => "Oct", "11" => "Nov", "12" => "Dec"
);

$slash_replace = array("\"" => "&#34;", "'" => "&#39;", "," => "&#44;");

$td_names = array(
  "1"    => "PD",
  "-1"    => "--",
  "3"    => "JO",
  "6"    => "DT",
  "7"    => "GK",
  "108"  => "CN",
  "2555" => "MB",
  "2101" => "SW",
  "530"  => "SH",
  "499"  => "RH"
);

$location_names = array(
  "1" => "Topsail",
  "2" => "Kenmount",
  "3" => "Water St."
);

$tourn_types = array(
  "1" => "<b class=\"sd\" >\$20 FO</b>",
  "2" => "<b class=\"ecw\">\$20 RB</b>",
  "3" => "<b class=\"raw\">\$40 RB</b>",
  "4" => "<b>\$60 FO</b>",
  "5" => "<b class=\"snme\">\$100 FO</b>",
  "6" => "<b class=\"snme\">\$25 PLO</b>",
  "7" => "<b class=\"snme\">\$40 FO</b>",
  "8" => "<b class=\"raw\">Playoff</b>",
  "9" => "<b class=\"snme\">\$50 FO</b>",
  "10" => "<b>\$70 FO</b>",
  "11" => "<b class=\"sd\">\$30 RB</b>",
  "12" => "<b class=\"ecw\">\$50 6-Max</b>",
  "13" => "<b class=\"snme\">\$60 FO</b>",
  "14" => "<b class=\"ecw\">\$60 6-Max</b>",
  "15" => "<b>\$75 FO</b>",
);

if (isset($_GET['start'])) {

  $playoff_start = $_GET['start'];
  $playoff_end   = $_GET['end'];
}

// if ($_GET['jackpot'] == "yes") {
$jackpot_start = $last_jackpot;
//   $playoff_end   = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
// }

// mysql_connect($host,$username,$password);
// @mysql_select_db($database) or die("Unable to select database from event_listing.php");

// $tournament_result = mysql_query($tournament_query);
// $tournament_num    = mysql_numrows($tournament_result);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php

echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\"> \n";
echo "<head>\n";
echo "<meta name=\"viewport\" content=\"width=device-width, initial-scale=";
if ($_GET['show'] == "yes") {
  echo "0.6";
} else {
  echo "1.0";
}
echo "\" />\n";

echo "<script type=\"text/javascript\">\n";
echo "<!--\n";

echo "function popUpImage(img){\n";
echo "  image1= new Image();\n";
echo "  image1.src=(img);\n";
echo "  imageSize(img);\n";
echo "}\n\n";

echo "function imageSize(img){\n";
echo "  if((image1.width!=0)&&(image1.height!=0)){\n";
echo "    viewImage(img);\n";
echo "  }\n";
echo "  else{\n";
echo "    funzione=\"imageSize('\"+img+\"')\";\n";
echo "    intervallo=setTimeout(funzione,20);\n";
echo "  }\n";
echo "}\n\n";

echo "function viewImage(img){\n";
echo "  imageWidth=image1.width+30;\n";
echo "  imageHeight=image1.height+30;\n";
echo "  imageWindow=\"width=\"+imageWidth+\",height=\"+imageHeight;\n";
echo "  imagePopUp=window.open(img,\"\",imageWindow);\n";
echo "}\n\n";

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

echo "<h1>Dooly's Poker Tournaments</h1>\n";
echo "<h3 style=\"color: #FF0000;\">Results Entered</h3>\n";

// echo "<table style=\"border-collapse: collapse; border: 0px;\" cellspacing=\"0\" cellpadding=\"0\">\n";
// echo "  <tr>\n";
// echo "    <td style=\"background-color: #eedd82;\" width=\"20px\">&nbsp;</td>\n";
// echo "    <td>&nbsp;&nbsp;Results Entered</td>\n";
// echo "  </tr>\n";
// echo "</table>\n";

// if ($show == "yes") {
//   echo "<a href=\"Javascript:onclick=entrypopup('event_modify.php?id=-1', 550, 130, 'enter_tournament');\">Add A Tournament</a>\n<br />";
// }
echo "<table class=\"titles\" cellspacing=\"0\" cellpadding=\"1\" style=\"background-color: #FFFFFF;\">\n";
if ($version != '330/4.5.0.12') {
  echo "  <tr>\n";
  echo "    <td style=\"width: 4em;  border-bottom: solid 1px #FFFFFF;\"><b>Date</b></td>\n";
  echo "    <td style=\"width: 3em;  border-bottom: solid 1px #FFFFFF;\">&nbsp;</td>\n";
  echo "    <td style=\"width: 2.5em;  border-bottom: solid 1px #FFFFFF;\">&nbsp;</td>\n";
  echo "    <td style=\"width: 3em;  border-bottom: solid 1px #FFFFFF;\">&nbsp;</td>\n";
  echo "    <td style=\"width: 8em;  border-bottom: solid 1px #FFFFFF;\" align=\"center\"><b>Location</b></td>\n";
  echo "    <td style=\"width: 6em; border-bottom: solid 1px #FFFFFF;\" align=\"center\"><b>Type</b></td>\n";
  echo "    <td style=\"width: 5em;  border-bottom: solid 1px #FFFFFF;\" align=\"center\"><b>Playoff<br />Pot</b></td>\n";
  if ($show == "yes") {
    echo "    <td style=\"width: 3em; border-bottom: solid 1px #FFFFFF;\" align=\"center\"><b>Fund</b></td>\n";
    echo "    <td style=\"width: 6em; border-bottom: solid 1px #FFFFFF;\" align=\"center\"><b>TD</b></td>\n";
    echo "    <td style=\"width: 5em;  border-bottom: solid 1px #FFFFFF;\" align=\"center\"><b>Players</b></td>\n";
    echo "    <td style=\"width: 5em;  border-bottom: solid 1px #FFFFFF;\" align=\"center\"><b>Payout</b></td>\n";
    echo "    <td style=\"width: 5em;  border-bottom: solid 1px #FFFFFF;\" align=\"center\"><b>Points</b></td>\n";
    echo "    <td style=\"width: 24em;  border-bottom: solid 1px #FFFFFF;\" align=\"center\"><b>Winner</b></td>\n";
    echo "    <td style=\"width: 24em;  border-bottom: solid 1px #FFFFFF;\" align=\"center\"><b>Bubble</b></td>\n";
  }
  //   if ($tournament_num > 27) {
  //     echo "    <td style=\"width: 16px; border-bottom: solid 1px #FFFFFF;\">&nbsp;</td>\n";
  //   }
  echo "  </tr>\n";
}
// echo "</table>\n";

// if ($show == "yes") {
//   echo "<div style=\"overflow: auto; width: auto; height: 72.5em; table-layout: fixed;\">\n";
// } else {
//   echo "<div style=\"overflow: auto; width: auto; height: 72.5em; table-layout: fixed;\">\n";
// }

// echo "<table class=\"titles\" cellspacing=\"0\" cellpadding=\"1\" style=\"background-color: #FFFFFF; border: 0px solid #000000;\">\n";

include("dbinfo.php");

$tournament_results = $conn->query(
  "SELECT *
                        FROM tournaments
                        WHERE date >= '$playoff_start' AND date <= '$playoff_end'
                        ORDER BY date ASC, location ASC"
);

$i = 0;
$date_check = "";
$month_check = '';
$year_check = 0;
$dow_check = 6;
$am_pm = "AM";
$total_players = 0;
$games_cancelled = 0;

while ($row5 = $tournament_results->fetch_assoc()) {
  $i_id           = $row5["id"];
  $i_date         = $row5["date"];
  list($i_year, $i_month, $i_day) = explode("-", $i_date);
  $i_month2 = strtr($i_month, $change_month);
  $i_location     = $row5["location"];
  $i_type         = $row5["type"];
  $i_buyin        = $row5["buyin"];
  $i_charity      = $row5["charity"];
  $i_td           = $row5["td"];
  list($i_td1, $i_td2) = explode(",", $i_td);
  if ($i_td1 == "-1") {
    $games_cancelled++;
  }
  $i_entered      = $row5["entered"];
  $i_payout       = $row5["payout"];
  $i_freerolls    = $row5["freerolls"];

  if ($i_date > "2012-04-01" && $$i_date < "2015-01-31") {
    if ($i_type == 2) {
      $points = ($i_payout * 0.025);
    } else if ($i_type == 1) {
      $points = (($i_payout + $i_freerolls * 25) * 0.025);
    } else if ($i_type == 7) {
      $points = (($i_payout + $i_freerolls * 40) * 0.025);
    } else if ($i_type == 4) {
      $points = (($i_payout + $i_freerolls * 60) * 0.025);
    }
  }
  if ($t_date > "2015-01-30") {
    if ($t_type == 11) {
      $points = ($payout * 0.025);
    } else if ($i_type == 9) {
      $points = (($i_payout + $i_freerolls * 50) * 0.025);
    } else if ($i_type == 10) {
      $points = (($i_payout + $i_freerolls * 70) * 0.025);
    }
  }

  $roundup2 = $points * 10000;
  $left2 = $roundup2 % 2500;
  if ($left2 >= 1250) {
    $i_points = round((($roundup2 - $left2) / 10000) + 0.25, 2);
  } else {
    $i_points = round(($roundup2 - $left2) / 10000, 2);
  }

  //     echo "$i_payout - $points - $roundup2 - $left2 - $i_points<br />\n";

  $i_issued       = $row5["issued"];
  $i_jackpot      = $row5["jackpot"];

  $jackpot_total = $jackpot_total += $i_jackpot;

  $winner_result  = $conn->query(
    "SELECT player_id, player_name
                      FROM points
                      WHERE date = '$i_date' AND location = '$i_location' AND game_type = '$i_type' AND finish = '1'"
  );
  //   $winner_result = mysql_query($winner_query);
  //   $winner_num    = mysql_numrows($winner_result);

  while ($row_wr = $winner_result->fetch_assoc()) {
    $winner_id     = $row_wr["player_id"];
    $winner_name   = $row_wr["player_name"];
  }

  $bubble_result  = $conn->query(
    "SELECT player_id, player_name
                      FROM points
                      WHERE date = '$i_date' AND location = '$i_location' AND game_type = '$i_type' AND bubble = '1'"
  );
  //   $bubble_result = mysql_query($bubble_query);
  //   $bubble_num    = mysql_numrows($bubble_result);


  while ($row_br = $bubble_result->fetch_assoc()) {
    $bubble_id     = $row_br["player_id"];
    $bubble_name   = $row_br["player_name"];
  }

  mysqli_free_result($bubble_result);

  $count_result  = $conn->query(
    "SELECT player_id
                     FROM points
                     WHERE date = '$i_date' AND location = '$i_location' AND game_type = '$i_type'"
  );
  //   $count_result = mysql_query($count_query);
  $count_num    = mysqli_num_rows($count_result);

  $total_players += $count_num;

  mysqli_free_result($count_result);

  //   echo "$count_num<br />\n";

  // Finds the Day of the Week
  $li_time = strtotime($i_date);
  $day_of_week_num = date("w", $li_time);
  $day_array = array(
    "0" => "Sun",
    "1" => "Mon",
    "2" => "Tue",
    "3" => "Wed",
    "4" => "Thu",
    "5" => "Fri",
    "6" => "Sat"
  );
  $day_of_week = strtr($day_of_week_num, $day_array);

  $day_color_array = array(
    "0" => "FFFF00",
    "1" => "FF0000",
    "2" => "00CC00",
    "3" => "FF9900",
    "4" => "C1FF7D",
    "5" => "00BBEC",
    "6" => "0077FF"
  );

  $current_date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
  $ili_time     = strtotime($current_date);
  $start_of_week = date("w", $ili_time);
  if ($start_of_week == 0) {
    $start_of_week = 7;
  }
  $begin_date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - $start_of_week, date("Y")));
  list($s_year, $s_month, $s_day) = explode("-", $begin_date);
  $end_date   = date("Y-m-d", mktime(0, 0, 0, $s_month, $s_day + 7, $s_year));

  echo "  <tr";
  if ($i_td1 == -1) {
    echo " style=\"
                   background-color: red;\"";
  }
  echo ">\n";

  if ($date_check == $i_date) {
    echo "    <td valign=\"top\" style=\"width: 4em;";
    if ($day_of_week_num == 0 && $dow_check == 6) {
      echo " border-top: solid 2px #404040;";
    }
    echo "\">&nbsp;</td>\n";
    echo "    <td valign=\"top\" style=\"width: 3em;";
    if ($day_of_week_num == 0 && $dow_check == 6) {
      echo " border-top: solid 2px #404040;";
    }
    echo "\">&nbsp;</td>\n";
    echo "    <td valign=\"top\" style=\"width: 2.5em;";
    if ($day_of_week_num == 0 && $dow_check == 6) {
      echo " border-top: solid 2px #404040;";
    }
    echo "\">&nbsp;</td>\n";
    if ($version != '330/4.5.0.12') {
      echo "    <td valign=\"top\" style=\"width: 3em;";
      if ($day_of_week_num == 0 && $dow_check == 6) {
        echo " border-top: solid 2px #404040;";
      }
      echo "\">&nbsp;</td>\n";
    }
  } else {
    $date_check  = $i_date;

    echo "    <td valign=\"top\" style=\"width: 4em;";
    if ($day_of_week_num == 0 && $dow_check == 6) {
      echo " border-top: solid 2px #404040;";
    }
    echo "\">$day_of_week, </td>\n";
    echo "    <td valign=\"top\" style=\"width: 3em;";
    if ($day_of_week_num == 0 && $dow_check == 6) {
      echo " border-top: solid 2px #404040;";
    }
    echo "\">";
    if ($month_check == $i_month && $day_of_week_num != 0) {
      echo "&nbsp;";
    } else {
      echo "$i_month2";
    }
    echo " </td>\n";
    echo "    <td valign=\"top\" style=\"width: 2.5em;";
    if ($day_of_week_num == 0 && $dow_check == 6) {
      echo " border-top: solid 2px #404040;";
    }
    echo "\">$i_day";
    if ($version != '330/4.5.0.12') {
      echo ", ";
    }
    echo "</td>\n";
    if ($version != '330/4.5.0.12') {
      echo "    <td valign=\"top\" style=\"width: 3em;";
      if ($day_of_week_num == 0 && $dow_check == 6) {
        echo " border-top: solid 2px #404040;";
      }
      echo "\">$i_year";
    }
  }
  echo "</td>\n";

  //   if ($version != '330/4.5.0.12') {
  //   echo "    <td valign=\"top\" align=\"center\" style=\"width: 2.5em;"; if ($day_of_week_num == 6) {echo " border-bottom: solid 2px #404040;";} echo "\">$i_hour:$i_minute $am_pm</td>\n";
  //   }

  echo "    <td valign=\"top\" align=\"center\" style=\"width: 4em;";
  if ($day_of_week_num == 0 && $dow_check == 6) {
    echo " border-top: solid 2px #404040;";
  }
  echo "\">";
  //   if ($show == "yes") {echo "\n    <a href=\"Javascript:onclick=entrypopup('event_modify.php?id=$i_id', 550, 180, 'modify_tournament');\">";}
  //   if ($i_td1 == -1) {echo "<s>";}   
  if ($version != '330/4.5.0.12') {
    if ($show == "yes") {
      echo "<a href=\"results.php?date=$i_date&amp;location=$i_location&amp;buyin=$i_buyin\">";
    }
    echo strtr($i_location, $location_names);
    if ($show == "yes") {
      echo "</a>";
    }
  } else {
    if ($i_location == 1) {
      echo "Top";
    } else if ($i_location == 1) {
      echo "Wat";
    } else {
      echo "--";
    }
  }
  //   if ($show == "yes") {echo "</a>";}
  //   if ($i_td1 == -1) {echo "</s>";} echo "</td>\n";

  echo "    <td valign=\"top\" align=\"center\" style=\"width: 4em;";
  if ($day_of_week_num == 0 && $dow_check == 6) {
    echo " border-top: solid 2px #404040;";
  }
  echo "\">";
  //   if ($i_td1 == -1) {echo "<s>";}
  echo strtr($i_type, $tourn_types);
  if ($i_td1 == -1) {
    echo "</s>";
  }
  echo "</td>\n";
  echo "    <td valign=\"top\" align=\"right\" style=\"width: 2.5em;";
  if ($day_of_week_num == 0 && $dow_check == 6) {
    echo " border-top: solid 2px #404040;";
  }
  echo "\">";
  if ($i_jackpot == "0") {
    echo "--";
  } else {
    echo "$" . floor($i_jackpot);
  }
  echo "&nbsp;&nbsp;</td>\n";
  if ($show == "yes") {
    echo "    <td valign=\"top\" align=\"center\" style=\"width: 1.5em;";
    if ($day_of_week_num == 0 && $dow_check == 6) {
      echo " border-top: solid 2px #404040;";
    }
    echo "\">";
    if ($i_charity == 1) {
      echo "YES";
    } else {
      echo "&nbsp;";
    }
    echo "</td>\n";
    echo "    <td valign=\"top\" align=\"center\" style=\"width: 3em;";
    if ($day_of_week_num == 0 && $dow_check == 6) {
      echo " border-top: solid 2px #404040;";
    }
    echo "\">";
    if ($i_td1 == "0") {
      echo "--";
    } else {
      echo strtr($i_td1, $td_names);
    }
    if ($i_td2 == "0") {
    } else {
      echo ",";
      echo strtr($i_td2, $td_names);
    }
    echo "</td>\n";

    echo "    <td valign=\"top\" align=\"center\" style=\"width: 2.5em;";
    if ($day_of_week_num == 0 && $dow_check == 6) {
      echo " border-top: solid 2px #404040;";
    }
    echo "\">";
    if ($count_num == "0") {
      echo "--";
    } else {
      if ($winner_id == "2886") {
        echo $count_num - 1;
      } else {
        echo $count_num;
      }
    }
    echo "</td>\n";
    echo "    <td valign=\"top\" align=\"right\" style=\"width: 2.5em;";
    if ($day_of_week_num == 0 && $dow_check == 6) {
      echo " border-top: solid 2px #404040;";
    }
    echo "\">";
    if ($i_payout == "0") {
      echo "--";
    } else {
      echo floor($i_payout);
    }
    echo "&nbsp;&nbsp;</td>\n";
    //     list($integer, $decimal) = split(".", $i_points); echo "$integer.$decimal";
    echo "    <td valign=\"top\" align=\"right\" style=\"width: 2.5em;";
    if ($day_of_week_num == 0 && $dow_check == 6) {
      echo " border-top: solid 2px #404040;";
    }
    echo "\">";
    if ($i_payout == "0") {
      echo "--";
    } else {
      echo "$i_points";
    }
    list($integer, $decimal) = explode('.', $i_points);
    //       echo "$integer - $decimal";
    if ($i_type == 8 || $i_type == -1 || $i_td1 == -1) {
    } else {
      if ($decimal == 0) {
        echo ".00";
      } else if ($decimal == 5) {
        echo "0";
      }
    }
    echo "&nbsp;&nbsp;</td>\n";
    echo "    <td valign=\"top\" align=\"center\" style=\"width: 12em;";
    if ($day_of_week_num == 0 && $dow_check == 6) {
      echo " border-top: solid 2px #404040;";
    }
    echo "\">";
    if ($winner_id == "2886") {
      echo "<b><i>--------";
    }
    if ($winner_id == "0") {
      echo "--";
    } else {
      echo "$winner_name";
    }
    if ($winner_id == "2886") {
      echo "--------</i></b>";
    }
    echo "</td>\n";
    echo "    <td valign=\"top\" align=\"center\" style=\"width: 12em;";
    if ($day_of_week_num == 0 && $dow_check == 6) {
      echo " border-top: solid 2px #404040;";
    }
    echo "\">";
    if ($bubble_id == "2886") {
      echo "<b><i>--------";
    }
    if ($bubble_id == "0") {
      echo "--";
    } else {
      echo "$bubble_name";
    }
    if ($bubble_id == "2886") {
      echo "--------</i></b>";
    }
    echo "</td>\n";
  }

  echo "  </tr>\n";

  $year_check = $i_year;
  $month_check = $i_month;
  $winner_id = 0;
  $winner_name = "--";
  $bubble_id = 0;
  $bubble_name = "--";
  $dow_check = $day_of_week_num;

  $i++;
}

echo "  <tr style=\"border-top: solid 2px #404040;\">\n";
echo "    <td style=\"border-top: solid 2px #404040; font-size: 1.125em;\" colspan=\"14\" align=\"center\">Approx. Playoff Pot Total: $ ";
echo number_format($jackpot_total + $jackpot_addon, 0, '.', ',');
echo "</td>\n";
echo "  <tr>\n";

if ($show == "yes") {
  echo "  <tr style=\"border-top: solid 2px #404040;\">\n";
  echo "    <td style=\"border-top: solid 2px #404040; font-size: 1.125em;\" colspan=\"14\" align=\"center\">Approx. Total Players: $total_players</td>\n";
  echo "  <tr>\n";
  //   echo "  </tr>\n";
  //   echo "    <td style=\"border-top: solid 2px #404040; font-size: 15px\" colspan=\"14\" align=\"center\">Estimated Jackpot Total: $ "; echo number_format(round(((($jackpot_total)/($i-$games_cancelled)) * (13*5-$games_cancelled)), 2), 0, '.', ','); echo "</td>\n";
  //   echo "  </tr>\n";
}

echo "</table>\n";

if ($show == "yes") {
  echo "Estimated payout:";
  echo "<table class=\"titles\" cellspacing=\"0\" cellpadding=\"1\" style=\"background-color: #FFFFFF; border: 0px solid #000000;\">";
  echo "  <tr>";
  echo "    <td align=\"right\">1<sup>st</sup> Place&nbsp;&nbsp;</td>";
  echo "    <td>$&nbsp;</td><td align=\"right\">";
  $place_payout = ($jackpot_total + $jackpot_addon) * 0.335;
  $roundup = $place_payout;
  $left = $roundup % 5;
  if ($left >= 2.5) {
    $payout = $roundup - $left + 5;
  } else {
    $payout = $roundup - $left;
  }
  echo floor($payout);
  $total_check += floor($payout);

  echo "</td>";
  echo "  </tr>";
  echo "  <tr>";
  echo "    <td align=\"right\">2<sup>nd</sup> Place&nbsp;&nbsp;</td>";
  echo "    <td>$&nbsp;</td><td align=\"right\">";
  $place_payout = ($jackpot_total + $jackpot_addon) * 0.195;
  $roundup = ceil($place_payout);
  $left = $roundup % 5;
  if ($left >= 2.5) {
    $payout = $roundup - $left + 5;
  } else {
    $payout = $roundup - $left;
  }
  echo floor($payout);
  $total_check += floor($payout);

  echo "</td>";
  echo "  </tr>";
  echo "  <tr>";
  echo "    <td align=\"right\">3<sup>rd</sup> Place&nbsp;&nbsp;</td>";
  echo "    <td>$&nbsp;</td><td align=\"right\">";
  $place_payout = ($jackpot_total + $jackpot_addon) * 0.15;
  $roundup = ceil($place_payout);
  $left = $roundup % 5;
  if ($left >= 2.5) {
    $payout = $roundup - $left + 5;
  } else {
    $payout = $roundup - $left;
  }
  echo floor($payout);
  $total_check += floor($payout);

  echo "</td>";
  echo "  </tr>";
  echo "  <tr>";
  echo "    <td align=\"right\">4<sup>th</sup> Place&nbsp;&nbsp;</td>";
  echo "    <td>$&nbsp;</td><td align=\"right\">";
  $place_payout = ($jackpot_total + $jackpot_addon) * 0.10;
  $roundup = ceil($place_payout);
  $left = $roundup % 5;
  if ($left >= 2.5) {
    $payout = $roundup - $left + 5;
  } else {
    $payout = $roundup - $left;
  }
  echo floor($payout);
  $total_check += floor($payout);

  echo "</td>";
  echo "  </tr>";
  echo "  <tr>";
  echo "    <td align=\"right\">5<sup>th</sup> Place&nbsp;&nbsp;</td>";
  echo "    <td>$&nbsp;</td><td align=\"right\">";
  $place_payout = ($jackpot_total + $jackpot_addon) * 0.07;
  $roundup = ceil($place_payout);
  $left = $roundup % 5;
  if ($left >= 2.5) {
    $payout = $roundup - $left + 5;
  } else {
    $payout = $roundup - $left;
  }
  echo floor($payout);
  $total_check += floor($payout);

  echo "</td>";
  echo "  </tr>";

  echo "  <tr>";
  echo "    <td align=\"right\">6<sup>th</sup> Place&nbsp;&nbsp;</td>";
  echo "    <td>$&nbsp;</td><td align=\"right\">";
  $place_payout = ($jackpot_total + $jackpot_addon) * 0.040;
  $roundup = ceil($place_payout);
  $left = $roundup % 5;
  if ($left >= 2.5) {
    $payout = $roundup - $left + 5;
  } else {
    $payout = $roundup - $left;
  }
  echo floor($payout);
  $total_check += floor($payout);

  echo "</td>";
  echo "  </tr>";
  echo "  <tr>";
  echo "    <td align=\"right\">7<sup>th</sup> Place&nbsp;&nbsp;</td>";
  echo "    <td>$&nbsp;</td><td align=\"right\">";
  $place_payout = ($jackpot_total + $jackpot_addon) * 0.035;
  $roundup = ceil($place_payout);
  $left = $roundup % 5;
  if ($left >= 2.5) {
    $payout = $roundup - $left + 5;
  } else {
    $payout = $roundup - $left;
  }
  echo floor($payout);
  $total_check += floor($payout);

  echo "</td>";
  echo "  </tr>";
  echo "  <tr>";
  echo "    <td align=\"right\">8<sup>th</sup> Place&nbsp;&nbsp;</td>";
  echo "    <td>$&nbsp;</td><td align=\"right\">";
  $place_payout = ($jackpot_total + $jackpot_addon) * 0.030;
  $roundup = ceil($place_payout);
  $left = $roundup % 5;
  if ($left >= 2.5) {
    $payout = $roundup - $left + 5;
  } else {
    $payout = $roundup - $left;
  }
  echo floor($payout);
  $total_check += floor($payout);

  echo "</td>";
  echo "  </tr>";
  echo "  <tr>";
  echo "    <td align=\"right\">9<sup>th</sup> Place&nbsp;&nbsp;</td>";
  echo "    <td>$&nbsp;</td><td align=\"right\">";
  $place_payout = ($jackpot_total + $jackpot_addon) * 0.025;
  $roundup = ceil($place_payout);
  $left = $roundup % 5;
  if ($left >= 2.5) {
    $payout = $roundup - $left + 5;
  } else {
    $payout = $roundup - $left;
  }
  echo floor($payout);
  $total_check += floor($payout);

  echo "</td>";
  echo "  </tr>";
  echo "  <tr>";
  echo "    <td align=\"right\">10<sup>th</sup> Place&nbsp;&nbsp;</td>";
  echo "    <td>$&nbsp;</td><td align=\"right\">";
  $place_payout = ($jackpot_total + $jackpot_addon) * 0.02;
  $roundup = ceil($place_payout);
  $left = $roundup % 5;
  if ($left >= 2.5) {
    $payout = $roundup - $left + 5;
  } else {
    $payout = $roundup - $left;
  }
  echo floor($payout);
  $total_check += floor($payout);

  echo "</td>";
  echo "  </tr>";
  echo "  <tr>";
  echo "    <td align=\"right\">&nbsp;</td>";
  echo "    <td>$&nbsp;</td><td align=\"right\">$total_check</td>";
  echo "  </tr>";
  echo "</table>";
}

// echo "</div>\n";

echo "<script type=\"text/javascript\" src=\"modify.js\"></script>\n";

?>