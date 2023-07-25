<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?PHP

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

?>

<script type="text/javascript" src="jquery.js"></script>
<script type='text/javascript' src='jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="jquery.autocomplete.css" />

<script type="text/javascript">
$().ready(function() {
  $("#p_name_0").autocomplete("get_name.php", {
    width: 260,
    matchContains: true,
    mustMatch: true,
    selectFirst: false
  });
  $("#p_name_0").result(function(event, data, formatted) {
    $("#p_id_num_0").val(data[1]);
  });
});

$().ready(function() {
  $("#p_name_1").autocomplete("get_name.php", {
    width: 260,
    matchContains: true,
    mustMatch: true,
    selectFirst: false
  });
  $("#p_name_1").result(function(event, data, formatted) {
    $("#p_id_num_1").val(data[1]);
  });
});

$().ready(function() {
  $("#p_name_2").autocomplete("get_name.php", {
    width: 260,
    matchContains: true,
    mustMatch: true,
    selectFirst: false
  });
  $("#p_name_2").result(function(event, data, formatted) {
    $("#p_id_num_2").val(data[1]);
  });
});

$().ready(function() {
  $("#p_name_3").autocomplete("get_name.php", {
    width: 260,
    matchContains: true,
    mustMatch: true,
    selectFirst: false
  });
  $("#p_name_3").result(function(event, data, formatted) {
    $("#p_id_num_3").val(data[1]);
  });
});

$().ready(function() {
  $("#p_name_4").autocomplete("get_name.php", {
    width: 260,
    matchContains: true,
    mustMatch: true,
    selectFirst: false
  });
  $("#p_name_4").result(function(event, data, formatted) {
    $("#p_id_num_4").val(data[1]);
  });
});

$().ready(function() {
  $("#p_name_5").autocomplete("get_name.php", {
    width: 260,
    matchContains: true,
    mustMatch: true,
    selectFirst: false
  });
  $("#p_name_5").result(function(event, data, formatted) {
    $("#p_id_num_5").val(data[1]);
  });
});

$().ready(function() {
  $("#p_name_6").autocomplete("get_name.php", {
    width: 260,
    matchContains: true,
    mustMatch: true,
    selectFirst: false
  });
  $("#p_name_6").result(function(event, data, formatted) {
    $("#p_id_num_6").val(data[1]);
  });
});

$().ready(function() {
  $("#p_name_7").autocomplete("get_name.php", {
    width: 260,
    matchContains: true,
    mustMatch: true,
    selectFirst: false
  });
  $("#p_name_7").result(function(event, data, formatted) {
    $("#p_id_num_7").val(data[1]);
  });
});

$().ready(function() {
  $("#p_name_8").autocomplete("get_name.php", {
    width: 260,
    matchContains: true,
    mustMatch: true,
    selectFirst: false
  });
  $("#p_name_8").result(function(event, data, formatted) {
    $("#p_id_num_8").val(data[1]);
  });
});

$().ready(function() {
  $("#p_name_9").autocomplete("get_name.php", {
    width: 260,
    matchContains: true,
    mustMatch: true,
    selectFirst: false
  });
  $("#p_name_9").result(function(event, data, formatted) {
    $("#p_id_num_9").val(data[1]);
  });
});
</script>

<?PHP
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

 include("browser_detection.php");
 $version = browser_detection('number');

 $places_paid   = $_GET['places'];
 $enter_games   = $_POST['enter_games'];
    if(!ISSET($enter_games) || EMPTY($enter_games)) {$enter_games = 0;}
 
 include("dbinfo.php");

 mysql_connect($host,$username,$password);
 @mysql_select_db($database) or die("Unable to select database from point_entry.php");

 $change_month = array("01" => "January ",   "02" => "February ", "03" => "March ",    "04" => "April ",
                       "05" => "May",        "06" => "June ",     "07" => "July ",     "08" => "August ",
                       "09" => "September ", "10" => "October ",  "11" => "November ", "12" => "December ");

 $change_month2 = array("01" => "Jan.",      "02" => "Feb.", "03" => "Mar.", "04" => "Apr.",
                        "05" => "May ", "06" => "Jun.", "07" => "Jul.", "08" => "Aug.",
                        "09" => "Sep.",      "10" => "Oct.", "11" => "Nov.", "12" => "Dec.");

 $slash_replace = array("\"" => "&#34;", "'" => "&#39;", "," => "&#44;");

 $location_names = array("1" => "Topsail  ",
                         "2" => "Kenmount ",
                         "3" => "Water St.");

 $tourn_types = array(
                      "7" => "<b class=\"sd\">\$40 Freezeout</b>",
                      "2" => "<b class=\"ecw\">\$25-\$20-\$20</b>",
                      "4" => "<b>\$60 Freezeout</b>",
                      "8" => "<b>Playoffs</b>",
//                      "1" => "<b class=\"sd\" >\$25 Freezeout</b>",
//                      "3" => "<b class=\"raw\">\$45-\$40-\$40</b>",
//                      "5" => "<b class=\"snme\">\$100 Freezeout</b>",
//                      "6" => "<b class=\"sd\">\$25 PLO</b>",
                      );

 if (ISSET('t_date')) {         
   $t_date        = $_POST['t_date'];
   $t_location    = $_POST['t_location'];
   $t_type        = $_POST['t_type'];
   $td1           = $_POST['td1'];
   $td2           = $_POST['td2'];
   $td            = $td1.",".$td2;
   $entered       = $_POST['entered'];   
   $payout        = $_POST['payout'];
   $freerolls     = $_POST['freerolls'];
   if ($t_date > "2012-04-01") {
     if ($t_type == 2) {
       $points = ($payout * 0.025);
     } else if ($t_type == 7) {
       $points = (($payout + $freerolls * 40) * 0.025);
     } else if ($t_type == 4) {
       $points = (($payout + $freerolls * 60) * 0.025);
     }
   }
  
     $roundup = $points * 10000;
     $left = $roundup % 2500;
     if ($left >= 1250) {
       $points = round((($roundup - $left) / 10000) + 0.25, 2);
     } else {
       $points = round(($roundup - $left) / 10000, 2);
     }

   if ($t_type == 2 && $t_date <= "2012-04-01") {$points = $points / 1.5;} else
   if ($t_type == 3 && $t_date <= "2012-04-01") {$points = $points / 3.5;} else
   if ($t_type == 4 && $t_date <= "2012-04-01") {$points = $points / 2.5;}
   
   $places_paid   = $_POST['places_2'];
   $charity       = $_POST['charity'];
   $str8_flush    = $_POST['str8'];
   $insert        = $_POST['insert'];

   if ($insert != 1) {
     $tournament_query  = "INSERT INTO tournaments VALUES (
                           '', '$t_date', '$t_location', '$t_type', '$charity', '', '$td', '$entered',
                           '$payout', '$freerolls', '', '$str8_flush')"; 
     $tournament_result = mysql_query($tournament_query);
     if (!$tournament_result) {
       echo "<span style=\"color: #FFFFFF;\">Invalid Update Tournament Query:<br />". mysql_error()."</span>";
//     echo "$t_id, $t_date, $t_location, $t_type, $td, $points, $num_freerolls, $places_paid, $charity<br />";
     } else {
//     echo "$t_id, $t_date, $t_location, $t_type, $td, $points, $num_freerolls, $places_paid, $charity<br />";
     }
     
     $insert = 1;
   }

   $num = 0;
   $finish = 1;
   $cash_bubble = 0;

   while ($num < $places_paid) {
     $new_playername    = "new_playername_" .$num;
     $entry_player_name = $_POST[$new_playername];
     if ($entry_player_name == "" || EMPTY($entry_player_name)) {
       $player       = "p_name_".$num;
       $id_num       = "p_id_num_".$num;
       $split        = "split_".$num;
       $bubble       = "bubble_".$num;

       $entry_player_name = $_POST[$player];
       $entry_id_num      = $_POST[$id_num];
       $entry_split       = $_POST[$split];
       $entry_bubble      = $_POST[$bubble];

       list($entry_player_id, $entry_player_num) = split(",", $entry_id_num);

//       echo "$entry_player_id, $entry_player_num, $entry_player_name<br />\n";

     } else {
       $entry_player_name = strtr($entry_player_name, $slash_replace);
       $new_playernum    = "new_playernum_" .$num;
       $entry_player_num = $_POST[$new_playernum];
       $bonus_seat   = "bonus_seat_" .$num;
       $bubble       = "bubble_" .$num;
       $split        = "split_".$num;
       $entry_split  = $_POST[$split];
       $entry_bubble  = $_POST[$bubble];

       if ($entry_player_name == "" || EMPTY($entry_player_name)) {} else {
         $new_player_query = "INSERT INTO players VALUES
                              ('','$entry_player_name', '$entry_player_num','','','','')";
         $new_player_result = mysql_query($new_player_query);
         $entry_player_id   = mysql_insert_id();
       }

       if (!$new_player_result) {
         echo "Invalid query: ". mysql_error()."";
       }
     }

     if ($entry_player_name == "EXISTING PLAYERS" || EMPTY($entry_player_name) || $entry_player_name == "") {} else {
       $entry_player_name = strtr($entry_player_name, $slash_replace);
       $entry_points = $points;
       if($entry_bubble == 1 && $cash_bubble == 0) {
         $cash_bubble = 1;
       } else {
         if($entry_bubble == 0 && $cash_bubble == 1) {
           $cash_bubble = 2;
         }
       }
       if ($enter_games == 1) {
         $entry_query = "INSERT INTO points VALUES
                         ('', '$entry_player_id', '$entry_player_name', '$entry_player_num', '$t_date', '$t_location',
                          '$t_type', '0', '0', '0', '3')";
       } else {
         if ($entry_split == 1 && $finish == 1) {
         $entry_query = "INSERT INTO points VALUES
                         ('', '2886', 'Split', '$entry_player_num', '$t_date', '$t_location',
                          '$t_type', '$entry_points', '$finish', '$entry_bonus', '$cash_bubble')";
         
         }
         if ($entry_split == 1) {$new_finish = 4; $entry_points += 0.05;} else {$new_finish = $finish;}
         $entry_query = "INSERT INTO points VALUES
                         ('', '$entry_player_id', '$entry_player_name', '$entry_player_num', '$t_date', '$t_location',
                          '$t_type', '$entry_points', '$new_finish', '$entry_bonus', '$cash_bubble')";
       }  
       $entry_result = mysql_query($entry_query);
       if (!$entry_result) {
         echo "<span style=\"color: #FFFFFF;\">Invalid Player Query: ". mysql_error()."</span>";
       }
     }
   $finish++;
     if($finish == 11) {$enter_games = 1;}
   $num++;
   }

   echo "<span class=\"header2\" style=\"color: black;\">ENTRY COMPLETE</span><br />\n";
 }
 
 if (ISSET($_GET['places']) || $enter_games == 1) {

   $td_query     = "SELECT *
                    FROM players
                    WHERE td = 1
                    ORDER BY name ASC";
   $td_result    = mysql_query($td_query);
   $td_num       = mysql_numrows($td_result);

   echo "<form action=\"point_entry.php\" method=\"post\" autocomplete=\"off\">\n";
   echo "<div id=\"content\">\n";
   echo "<input type=\"hidden\" name=\"places_2\" value=\"$places_paid\" />\n";
   if ($enter_games == 1) {
     echo "<input type=\"hidden\" name=\"enter_games\" value=\"1\" />\n";
     echo "<input type=\"hidden\" name=\"t_date\"      value=\"$t_date\"     />\n";
     echo "<input type=\"hidden\" name=\"t_location\"  value=\"$t_location\" />\n";
     echo "<input type=\"hidden\" name=\"t_type\"      value=\"$t_type\"     />\n";
     echo "<input type=\"hidden\" name=\"insert\"      value=\"1\"     />\n";
//     echo "<input type=\"hidden\" name=\"points\"     value=\"$points\"     />\n";
   } else {
   
   echo "<table class=\"titles\" cellspacing=\"0\" cellpadding=\"1\">\n";
   echo "  <tr>\n";
   echo "    <td align=\"center\"><b>ENTER TOURNAMENT INFO</b><br />\n";
   echo "    <input class=\"large\" type=\"text\" name=\"t_date\" value=\"2014-MM-DD\"/></input>\n";
   echo "    <select name=\"t_location\">\n";
   echo "    <option value=\"0\" selected=\"selected\">SELECT A LOCATION</option>\n";

   echo "    <option value=\"1\">Topsail</option>\n";
   echo "    <option value=\"3\">Water St.</option>\n";

   echo "    </select>\n";

   echo "    <select name=\"t_type\">\n";
   echo "    <option value=\"0\" selected=\"selected\">TOURNAMENT TYPE</option>\n";

   echo "    <option value=\"7\">\$40 FO</option>\n";
   echo "    <option value=\"2\">\$25 RB</option>\n";
//   echo "    <option value=\"6\">\$25 PLO</option>\n";
//   echo "    <option value=\"3\">\$45-40-40</option>\n";
   echo "    <option value=\"4\">\$60 FO</option>\n";
   echo "    <option value=\"8\">Playoff</option>\n";

   echo "    </select>\n";

   echo "    <br /><b>CHARITY EVENT?</b> <input type=\"checkbox\" name=\"charity\" value=\"1\">\n";
   echo "    <b>DON'T INSERT?</b> <input type=\"checkbox\" name=\"insert\" value=\"1\"></td>\n";
   echo "  </tr>\n";
   echo "  <tr>\n";

   echo "    <td align=\"center\"><b>TOURNAMENT DIRECTOR(S)</b><br />\n";
   echo "    <select name=\"td1\">\n";
   echo "    <option value=\"0\" selected=\"selected\">SELECT A TD</option>\n";

   $k = 1;
   while ($k < $td_num) {
     $td_id   = mysql_result($td_result, $k, "id");
     $td_name = mysql_result($td_result, $k, "name");

     echo "    <option value=\"$td_id\">$td_name</option>\n";
     $k++;
   }

   echo "    </select>  \n";
   echo "    <select name=\"td2\">\n";
   echo "    <option value=\"0\" selected=\"selected\">SELECT A TD</option>\n";

   $j = 1;
   while ($j < $td_num) {
     $td_id   = mysql_result($td_result, $j, "id");
     $td_name = mysql_result($td_result, $j, "name");

      echo "    <option value=\"$td_id\">$td_name</option>\n";
     $j++;
   }

   echo "    </select></td>\n";
   echo "  </tr>\n";
   echo "  <tr>\n";
   echo "    <td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" style=\"border: 0px;\">\n";
   echo "      <tr>\n";
   echo "        <td align=\"center\"><b>POT TOTAL:</b>&nbsp;</td>\n";
   echo "        <td align=\"center\">&nbsp;<input class=\"med\" type=\"text\" name=\"payout\" /></td>\n";
   echo "        <td>&nbsp;&nbsp;&nbsp;</td>\n";
   echo "        <td align=\"center\"><b>FREEROLLS:</b>&nbsp;</td>\n";
   echo "        <td align=\"center\">&nbsp;<input class=\"small\" type=\"text\" name=\"freerolls\" /></td>\n";
   echo "        <td>&nbsp;&nbsp;&nbsp;</td>\n";
   echo "        <td align=\"center\"><b>JACKPOT ADD-ON:</b>&nbsp;</td>\n";
   echo "        <td align=\"center\">&nbsp;<input class=\"med\" type=\"text\" name=\"str8\" /></td>\n";
   echo "      </tr>\n";
   echo "    </table></td>\n";
   echo "  </tr>\n";
   echo "</table>\n";
   }
   echo "<table class=\"titles\" cellspacing=\"0\" cellpadding=\"1\">\n";
   echo "  <tr>\n";
   if ($enter_games == 0) {
     echo "    <td>&nbsp;</td>\n";
     echo "    <td>&nbsp;</td>\n";
   }  
   echo "    <td>&nbsp;</td>\n";
   echo "    <td>&nbsp; </td>\n";
   echo "    <td align=\"center\" valign=\"bottom\"><b>NEW PLAYER</b></td>\n";
   echo "    <td align=\"center\" valign=\"bottom\"><b>DOOLYS #</b></td>\n";
   if ($enter_games == 0) {
     echo "    <td>&nbsp;</td>\n";
     echo "    <td>&nbsp;</td>\n";
     echo "    <td>&nbsp;</td>\n";
   }  
//   echo "    <td align=\"center\" valign=\"bottom\"><b>Bonus<br />Seat</b></td>\n";
   echo "  </tr>\n";


   $g = 0;
   $place = 1;
   while ($g < $places_paid) {
     echo "  <tr>\n";
     if ($enter_games == 0) {
       if ($place == 1)  {echo "    <td>&nbsp;</td>\n    <td style=\"border-top: 2px solid black; border-left: 2px solid black;\">&nbsp;</td>\n";}
       if ($place == 2)  {echo "    <td align=\"right\">Split&nbsp;&mdash;</td>\n    <td style=\"border-left: 2px solid black;\">&nbsp;</td>\n";}
       if ($place == 3)  {echo "    <td>&nbsp;</td>\n    <td style=\"border-bottom: 2px solid black; border-left: 2px solid black;\">&nbsp;</td>\n";}
       if ($place == 4)  {echo "    <td>&nbsp;</td>\n    <td style=\"border-top: 2px solid black; border-left: 2px solid black;\">&nbsp;</td>\n";}
       if ($place == 5)  {echo "    <td>&nbsp;</td>\n    <td style=\"border-left: 2px solid black;\">&nbsp;</td>\n";}
       if ($place == 6)  {echo "    <td>&nbsp;</td>\n    <td style=\"border-left: 2px solid black;\">&nbsp;</td>\n";}
       if ($place == 7)  {echo "    <td align=\"right\">Bubble&nbsp;&mdash;</td>\n    <td style=\"border-left: 2px solid black;\">&nbsp;</td>\n";}
       if ($place == 8)  {echo "    <td>&nbsp;</td>\n    <td style=\"border-left: 2px solid black;\">&nbsp;</td>\n";}
       if ($place == 9)  {echo "    <td>&nbsp;</td>\n    <td style=\"border-left: 2px solid black;\">&nbsp;</td>\n";}
       if ($place == 10) {echo "    <td>&nbsp;</td>\n    <td style=\"border-bottom: 2px solid black; border-left: 2px solid black;\">&nbsp;</td>\n";}
     }
     echo "    <td align=\"center\">";
     if ($enter_games == 1) {echo "&nbsp";} else if ($place >= 4) {
       echo "<input type=\"checkbox\" name=\"bubble_$g\" value=\"1\">";
     } else if ($place < 4) {
       echo "<input type=\"checkbox\" name=\"split_$g\" value=\"1\">";
     } 
     echo "</td>\n";
     echo "    <td align=\"right\"><input type=\"hidden\" name=\"place_$g\" value=\"$place\" />"; if ($place < 10) {echo "  ";} echo "$place.\n";

       echo "    <input type=\"text\"   name=\"p_name_$g\"   id=\"p_name_$g\" />\n";
       echo "    <input type=\"hidden\" name=\"p_id_num_$g\" id=\"p_id_num_$g\" />\n";

     echo "    </td>\n";
     echo "    <td><input class=\"large\" type=\"text\" name=\"new_playername_$g\" /></td>\n";
     echo "    <td><input class=\"med\" type=\"text\" name=\"new_playernum_$g\" /></td>\n";
//     echo "    <td align=\"center\">"; if ($g > 0) {echo "<input type=\"checkbox\" name=\"bonus_seat_$g\" value=\"1\">";} else {echo "&nbsp;";} echo "</td>\n";

   if ($enter_games == 0) {
     echo "    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>\n";
     echo "    <td>&nbsp;</td>\n";
     echo "    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>\n";
   }  
     echo "  </tr>\n";
     $g++;
     $place++;
   }

   echo "  <tr>\n";
   echo "    <td align=\"center\" colspan=\"9\"><input type=\"submit\" value=\"Submit\" style=\"border-right: solid 1px #000000;\n";
   echo "     border-left: solid  1px #000000; border-top: solid 1px #000000; border-bottom: solid 1px #000000;\n";
   echo "     font-family: Times New Roman; font-size: 10pt; color: #000000; font-weight: bold; background-color: #FFFFFF\" /></td>\n";
   echo "  </tr>\n";
   echo "</table>\n";
   echo "</div>\n";
   echo "</form>\n";
 }
 
 if ($enter_games == 1) {
   echo "<a href=\"point_entry.php?places=10\">Click Here To Enter Another Tournament</a><br />\n";
   echo "<a href=\"point_totals.php\">Click Here To View The Standings</a>\n";
   
   $result_query     = "SELECT *
                        FROM points
                        WHERE date = '$t_date' AND location = '$t_location'
                        ORDER BY bubble ASC, finish ASC, id ASC";
   $result_result    = mysql_query($result_query);
   $result_num       = mysql_numrows($result_result);
   
   echo "<table border=\"1\" cellspacing=\"0\" cellpadding=\"0\">\n";
   echo "  <tr>\n";
   echo "    <td valign=\"top\"><table border=\"0\" cellspacing=\"0\" cellpadding=\"1\">\n";

   $r = 0;
   while ($r < $result_num) {
     $player_id   = mysql_result($result_result, $r, "player_id");
     $player_name = mysql_result($result_result, $r, "player_name");
     $player_fin  = mysql_result($result_result, $r, "finish");

     echo "      <tr>\n";
     echo "        <td align=\"right\">"; if ($player_fin == 0) {echo "&nbsp;&nbsp;";} else {echo "$player_fin"; echo ".&nbsp;";} echo "</td>";
     echo "        <td align=\"left\">$player_name &nbsp;&nbsp;</td>";
     echo "      </tr>\n";

     $r++;
     if ($r % 20 == 0) {
       echo "    </table></td>\n    <td valign=\"top\">";
       echo "    <table border=\"0\" cellspacing=\"0\" cellpadding=\"1\">";
     }
 
   }

   echo "    </table></td>\n";
   echo "  </tr>\n";
   echo "</table>\n";
  
 }
 
 mysql_close();
  
 echo "</center>\n";
 echo "</body>\n";
 echo "</html>\n";

?>