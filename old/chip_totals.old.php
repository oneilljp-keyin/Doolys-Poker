<?PHP

 include("dbinfo.php");

// @mysql_connect($host,$username,$password);
// @mysql_select_db($database) or die("Unable to select database from point_entry.php");

 function sort_total_points($x, $y) {if ($x[2] == $y[2]) return 0; else if ($x[2] < $y[2]) return 1; else return -1;}
 function sort_other_points($x, $y) {if ($x[4] == $y[4]) return 0; else if ($x[4] < $y[4]) return 1; else return -1;}
 function sort_name($x, $y)         {if ($x[1] == $y[1]) return 0; else if ($x[1] < $y[1]) return -1; else return 1;}
 function sort_table_seat($x, $y)   {if ($x[3] == $y[3]) return 0; else if ($x[3] < $y[3]) return -1; else return 1;}
 
 $slash_replace = array("\"" => "&#34;", "'" => "&#39;", "," => "&#44;");

 include("dates.php");

 $table_sort = $_GET['sort'];
 $chips      = $_GET['chips']; 

 $start_date = $_GET['startdate'];
 $end_date   = $_GET['enddate'];
 if (!ISSET($_GET['startdate'])) {
   $start_date = $playoff_start;
   $end_date   = $playoff_end;
 }
 
// echo "$start_date - $end_date<br />\n";

 $points_query     = "SELECT *
                      FROM points
                      WHERE date >= '$start_date'
                      AND date <= '$end_date'
                      AND player_id != '2886'
                      ORDER BY player_id ASC, date ASC";
 $points_result    = mysqli_query($conn, $points_query);
 $points_num       = mysqli_num_rows($points_result);
 
// echo "$points_num<br />\n";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php

 echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\"> \n";
 echo "<head>\n";
 echo "<link rel=\"stylesheet\" href=\"doolys.css\" type=\"text/css\" />\n";
 echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
 echo "<title>Dooly&#39;s Poker Playoffs</title>\n";

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

 $first_finishes = 0;   $other_finishes = 0;
 $first_points   = 0;   $other_points   = 0;   $total_points = 0;
 $first_chips    = 0;   $other_chips    = 0;

 $points_array = array();

 $id_check      = -1;
 $winners_check = 0;
 $other_check   = 0;
 $games_played  = 0;

 $multiplier    = 1;

 $k = 0;
 while ($rsk = mysqli_fetch_array($points_result)) {
   $id        = $rsk["player_id"];
   
   if ((($id_check != $id) || ($k + 1 == $points_num)) && $k != 0) {
     if ($games_played >= ($games_to_qualify)) {
       $points_array[] = array($id_check, $name, $total_points, $first_points, $other_points, $first_chips, $other_chips);
     }
     $total_points = 0;
     $first_points = 0;
     $other_points = 0;
     $first_chips  = 0;
     $other_chips  = 0;
     $multiplier   = 1;
     $points       = 0;
     $games_played = 0;
   }

   $name      = $rsk["player_name"];
   $date      = $rsk["date"];
   $mem_num   = $rsk["member"];
   $game_type = $rsk["game_type"];
   if ($game_type == 3 || $game_type == 4 || $game_type == 10 || $game_type == 15) {
     $games_played += 2;
   } else if ($game_type == 2 || $game_type == 11) {
     $games_played += 1.5;
   } else if ($game_type == 1) {
     $games_played += 0.75;
   } else if ($game_type == 7 || $game_type == 9 || $game_type == 12 || $game_type == 13 || $game_type == 14) {
     $games_played += 1;
   }
   
   
//   if ($date <= "2012-03-23") {
//     if ($game_type == 2) {$multiplier = 1.5;} else
//     if ($game_type == 3) {$multiplier = 3.5;} else
//     if ($game_type == 4) {$multiplier = 2.5;} else
//     if ($game_type == 5) {$multiplier = 5;   }
//   }
   $num_points =  $rsk["num_players"];
   $finish     =  $rsk["finish"];

   if ($mem_num > 0 && $finish != 0) {$points+=5;}
   if ($finish == 1) {$points+=10;} else
     if ($finish == 2) {$points+=7;} else 
       if ($finish == 3) {$points+=5;}
   if ($finish == 1) {
     $first_finishes++;
     $points += $num_points * $multiplier;
     $first_points += $points;
     $total_points += $points;
     $first_chips += $points * 15;
   } else {
     $other_finishes++;
     $points += ($num_points - $finish) * $multiplier;
     $other_points += $points;
     $total_points += $points;
     $other_chips += $points * 10;
   }

//   if($id == 56 ) {
//   echo "$name, $total_points, $first_points, $other_points, $first_chips, $other_chips<br />\n";
//   }

//   echo "<a href=\"player_info.php?id=$id\">$name ($games_played) [$points]</a><br />\n";

   if ($k + 1 == $points_num) {
     if ($games_played >= ($games_to_qualify)) {
       $points_array[] = array($id, $name, $total_points, $first_points, $other_points, $first_chips, $other_chips);
     }
     $total_points = 0;
     $first_points = 0;
     $other_points = 0;
     $first_chips  = 0;
     $other_chips  = 0;
     $multiplier   = 1;
     $points       = 0;
     $games_played = 0;
   }
   $k++;
   $id_check   = $id;
   $multiplier = 1;
   $points     = 0;
 }

// usort($points_array, 'sort_other_points');
// $top_40_points = $points_array[39][4];

 usort($points_array, 'sort_total_points');
 $qualify_points = $points_array[$tables_for_tournament * 10][2];
// $qualify_points = $points_array[$tables_for_tournament * 10 - 11][2];

// echo "<pre>\n";
// echo print_r($points_array);
// echo "</pre>\n";

 $array_num = count($points_array);
 
// echo "$array_num<br />\n";

 $chips_array = array();

 $chip_total = 0;
 $t = 0;
 while ($t < $array_num) {
   $display_id           = $points_array[$t][0];
   $display_name         = $points_array[$t][1];
   $display_total_points = $points_array[$t][2];
   $display_first_points = $points_array[$t][3];
   $display_other_points = $points_array[$t][4];
   $display_first_chips  = $points_array[$t][5];
   $display_other_chips  = $points_array[$t][6];

 //  if($display_id == 302 || $display_id == 395 || $display_id == 92) {} else {
   if($display_total_points >= $qualify_points && $display_total_points != 0) {
     $chip_total += $display_first_chips;
     $chip_total += $display_other_chips;

     $roundup2 = ceil($chip_total);
     $left2 = $roundup2 % 25;
     if ($left2 >= 12.5) {
       $chip_total2 = $roundup2 - $left2 + 25;
     } else {
       $chip_total2 = $roundup2 - $left2 + 25;
     }

     $chips_array[] = array($display_id, $display_name, $chip_total2);
     $chip_total2 = 0;
     $chip_total = 0;
   }
//  }

   $t++;
 }

// echo "</table>\n";

 usort($chips_array, 'sort_total_points');
 $chip_num = count($chips_array);

 $seat_array = array();

 $table = 1;
 $seat = 9;
 $v = 0;
 while ($v < $chip_num) {
   $display2_id          = $chips_array[$v][0];
   $display2_name        = $chips_array[$v][1];
   $display2_total_chips = $chips_array[$v][2];

   if($table < 10) {$table_seat = "0".$table;} else {$table_seat = $table;}
   if($seat < 10) {$table_seat = $table_seat."-0".$seat;} else {$table_seat = $table_seat."-".$seat;}

   $seat_array[] = array($display2_id, $display2_name, $display2_total_chips, $table_seat, $table, $seat);

   $table++;
   if ($table == $tables_for_tournament + 1) {$table = 1; $seat--;}

   $v++;
 }


// $seat_array[] = array('', 'Wild Card #1',    '0', '01-01', '1', '1');
// $seat_array[] = array('', 'Wild Card #2',    '0', '02-01', '2', '1');
// $seat_array[] = array('', 'Wild Card #3',    '0', '03-01', '3', '1');
// $seat_array[] = array('', 'Wild Card #4',    '0', '04-01', '4', '1');
// $seat_array[] = array('', 'Wild Card #5',    '0', '05-01', '5', '1');
// $seat_array[] = array('', 'Wild Card #6',    '0', '06-01', '6', '1');
// $seat_array[] = array('', 'Wild Card #7',    '0', '07-01', '7', '1');
// $seat_array[] = array('', 'Wild Card #8',    '0', '05-02', '5', '2');
// $seat_array[] = array('', 'Wild Card #9',    '0', '06-02', '6', '2');
// $seat_array[] = array('', 'Wild Card #10',    '0', '07-02', '7', '2');


// $seat_array[] = array('56',   'Bill Vaters',     '0', '06-02', '6', '2');
// $seat_array[] = array('144',  'Irene Batstone',  '0', '07-02', '7', '2');
// $seat_array[] = array('2521', 'Curtis Leshane',  '0', '08-02', '8', '2');
// $seat_array[] = array('2532', 'Andrew Miller',   '0', '09-02', '9', '2');
// $seat_array[] = array('2296', 'L.D. Luedee',     '0', '10-02', '10', '2');
// $seat_array[] = array('1521', 'Jonathan Marrie', '0', '11-02', '11', '2');
// $seat_array[] = array('2568', 'Shyla Ryan',      '0', '12-02', '12', '2');
// $seat_array[] = array('1700', 'Chris Doyle',     '0', '01-01', '1', '1');
// $seat_array[] = array('1244', 'Paul Murphy',     '0', '02-01', '2', '1');
// $seat_array[] = array('457',  'Paul Porter',     '0', '03-01', '3', '1');
// $seat_array[] = array('727',  'Glen Freake',     '0', '04-01', '4', '1');
// $seat_array[] = array('2315', 'Bryan Rutherford','0', '05-01', '5', '1');
// $seat_array[] = array('1667', 'Adam Harris',     '0', '06-01', '6', '1');
// $seat_array[] = array('1562', 'Kris Pike',       '0', '07-01', '7', '1');
// $seat_array[] = array('1767', 'Dave Caines',     '0', '08-01', '8', '1');
// $seat_array[] = array('98',   'Brian White',     '0', '09-01', '9', '1');
// $seat_array[] = array('2608', 'Chris Clarke',    '0', '10-01', '10', '1');
// $seat_array[] = array('264',  'Jim Power',       '0', '11-01', '11', '1');
// $seat_array[] = array('454',  'Paul Cuff',       '0', '12-01', '12', '1');


 if ($table_sort == "alpha") {

   echo "<a style=\"font-size: 22px;\" href=\"http://doolyspoker.johnny-o.net/chip_totals.php?sort=table"; if ($chips == 1) {echo "&chips=1";} echo "\">CLICK HERE to see Table/Seat List</a><br />(SEATING ARRANGEMENT MAY CHANGE WITHOUT NOTICE)<br />\n";

   echo "<table cellspacing=\"0\" cellpadding=\"0\" style=\"border: none;\">\n";
   echo "  <tr>\n";
   echo "    <td valign=\"top\" style=\"border-right: 2px solid #909090;\">\n";

   echo "    <table class=\"titles\" cellspacing=\"0\" cellpadding=\"1\" style=\"border: 1px solid #909090;\">\n";
   echo "      <tr>\n";
   echo "        <td align=\"left\" valign=\"bottom\">&nbsp;&nbsp;Name:&nbsp;&nbsp;</td>\n";
   echo "        <td align=\"center\" valign=\"bottom\">Chips</td>\n";
   echo "        <td align=\"center\" valign=\"bottom\" colspan=\"3\"><small>Table/<br />Seat</small></td>\n";
   echo "      </tr>\n";

   usort($seat_array, 'sort_name');
   $seat_num = count($seat_array);

   $w = 0;
   while ($w < $seat_num) {
     $display3_id          = $seat_array[$w][0];
     $display3_name        = $seat_array[$w][1];
     $display3_total_chips = $seat_array[$w][2];
     $display3_table_seat  = $seat_array[$w][3];
     $display3_table       = $seat_array[$w][4];
     $display3_seat        = $seat_array[$w][5];

     if ($display3_id == '') {} else {
     echo "      <tr>\n";
     echo "        <td align=\"left\">&nbsp;&nbsp;<a style=\"font-size: 10px;\" href=\"player_info.php?id=$display3_id\">"; if ($display3_id == 586) {echo "<small>";} echo "$display3_name"; if ($display3_id == 586) {echo "</small>";} echo "</a>&nbsp;&nbsp;</td>\n";
     echo "        <td align=\"right\"><span style=\"font-size: 10px;\">";
                   if ($chips == 1) {
                     echo $display3_total_chips;
                   } else {
                     echo $display3_total_chips+$start_stack;
                   } echo "</span></td>\n";
     echo "        <td align=\"right\" style=\"border-right: 0px solid;\">&nbsp;&nbsp;<span style=\"font-size: 10px;\">$display3_table</span></td>\n";
     echo "        <td align=\"center\" style=\"border-right: 0px solid; border-left: 0px solid;\"><span style=\"font-size: 10px;\">&nbsp;-&nbsp;</span></td>\n";
     echo "        <td align=\"right\" style=\"border-left: 0px solid;\"><span style=\"font-size: 10px;\">$display3_seat&nbsp;</span></td>\n";
     echo "      </tr>\n";
     }

     $w++;

     if ($w == ($tables_for_tournament * 5)) {
       echo "    </table>\n";
       echo "    </td>\n";
       echo "    <td valign=\"top\" style=\"border-right: 2px solid #909090;\">\n";
       echo "    <table class=\"titles\" cellspacing=\"0\" cellpadding=\"1\" style=\"border: 1px solid #909090;\">\n";
       echo "      <tr>\n";
       echo "        <td align=\"left\" valign=\"bottom\">&nbsp;&nbsp;Name:&nbsp;&nbsp;</td>\n";
       echo "        <td align=\"center\" valign=\"bottom\">Chips</td>\n";
       echo "        <td align=\"center\" valign=\"bottom\" colspan=\"3\"><small>Table/<br />Seat</small></td>\n";
       echo "      </tr>\n";
     }
    
   }

   echo "    </table>\n";
   echo "    </td>\n";
   echo "  </tr>\n";
   echo "</table>\n";

 }

 if ($table_sort == "table") {
   echo "<a style=\"font-size: 22px;\" href=\"http://doolyspoker.johnny-o.net/chip_totals.php?sort=alpha"; if ($chips == 1) {echo "&chips=1";} echo "\">CLICK HERE to see Alphabetical List</a><br />(SEATING ARRANGEMENT MAY CHANGE WITHOUT NOTICE)<br />\n";

   echo "<table cellspacing=\"0\" cellpadding=\"0\" style=\"border: none;\">\n";
   echo "  <tr>\n";
   echo "    <td valign=\"top\" style=\"border-right: 2px solid #909090;\">\n";
   echo "    <table class=\"titles\" cellspacing=\"0\" cellpadding=\"1\" style=\"border: 1px solid #909090;\">\n";

   usort($seat_array, 'sort_table_seat');
   $table_seat_num = count($seat_array);

   $table_num = 1;
   $seat_num = 1;

   echo "      <tr>\n";
   echo "        <td align=\"center\" colspan=\"3\"><span style=\"font-size: 18px;\">Table #$table_num</span></td>\n";
   echo "      <tr>\n";
   echo "      </tr>\n";
   echo "        <td align=\"center\"></td>\n";
   echo "        <td align=\"left\" width=\"100\">&nbsp;&nbsp;Name:&nbsp;&nbsp;</td>\n";
   echo "        <td align=\"center\" >&nbsp;&nbsp;Chips&nbsp;&nbsp;</td>\n";
   echo "      </tr>\n";

   $x = 0;

   while ($table_num <= $tables_for_tournament) {

     $display4_id          = $seat_array[$x][0];
     $display4_name        = $seat_array[$x][1];
     $display4_total_chips = $seat_array[$x][2];
     $display4_table_seat  = $seat_array[$x][3];
     $display4_table       = $seat_array[$x][4]; 
     $display4_seat        = $seat_array[$x][5];

//    echo "$display4_table - $display4_seat / $table_num - $seat_num\n";

     if ($display4_table == $table_num && $display4_seat == $seat_num) {
       echo "      <tr>\n";
       echo "        <td align=\"right\" style=\"border-right: 0px solid;\">$display4_seat</td>\n";
       echo "        <td align=\"left\">&nbsp;<a style=\"font-size: 10px;\" href=\"player_info.php?id=$display4_id\">"; if ($display4_id == 586) {echo "<small>";} echo "$display4_name"; if ($display4_id == 586) {echo "</small>";} echo "</a>&nbsp;</td>\n";
       echo "        <td align=\"right\"><span style=\"font-size: 10px;\">";
          if ($chips == 1) {
            echo $display4_total_chips;
          } else {
            echo $display4_total_chips+$start_stack;
          } echo "</span></td>\n";
       echo "      </tr>\n";
       $x++;
     } else {
       echo "      <tr>\n";
       echo "        <td align=\"right\" style=\"border-right: 0px solid;\">&nbsp;$seat_num</td>\n";
       echo "        <td align=\"left\">&nbsp;&nbsp;--&nbsp;&nbsp;</td>\n";
       echo "        <td align=\"center\">&nbsp;&nbsp;--&nbsp;&nbsp;</td>\n";
       echo "      </tr>\n";

     }

     $seat_num++;
     if ($seat_num == 10) {
       $table_num++; $seat_num = 1;
 
       echo "    </table>\n";

       echo "    </td>\n";

       if ($table_num == 3 || $table_num == 5 || $table_num == 7) {
         echo "  </tr>\n";
         echo "  <tr>\n";
       }

       if ($table_num != $tables_for_tournament + 1) {
         echo "    <td valign=\"top\" style=\"border-right: 2px solid #909090;\"  >\n";
       }
       if ($table_num != $tables_for_tournament + 1) {
         echo "    <table class=\"titles\" cellspacing=\"0\" cellpadding=\"1\" style=\"border: 1px solid #909090;\">\n";
         echo "      <tr>\n";
         echo "        <td align=\"center\" colspan=\"3\"><span style=\"font-size: 18px;\">Table #$table_num</span></td>\n";
         echo "      <tr>\n";
         echo "      </tr>\n";
         echo "        <td align=\"center\"></td>\n";
         echo "        <td align=\"left\" width=\"100\">&nbsp;&nbsp;Name:&nbsp;&nbsp;</td>\n";
         echo "        <td align=\"center\" >&nbsp;&nbsp;Chips&nbsp;&nbsp;</td>\n";
         echo "      </tr>\n";
       }


     }

   } 

   echo "      </tr>\n";
   echo "    </table></td>\n";
   echo "  </tr>\n";
   echo "</table>\n";

 }
 
  if ($table_sort == "seat") {
  
   usort($seat_array, 'sort_table_seat');
   $seat_num = count($seat_array);

   $w = 0;
   $x = $_GET['x'];

   echo "<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\"\" >\n";
   echo "  <tr>\n";


   while ($x < $seat_num) {

     if ($x == 0) {
     }

     $display6_id          = $seat_array[$x][0];
     $display6_name        = $seat_array[$x][1];
     $display6_extra_chips = $seat_array[$x][2];
     $display6_table       = $seat_array[$x][4];
     $display6_seat        = $seat_array[$x][5];

       echo "    <td align=\"center\" width=\"50%\" style=\"border: 1px solid;\">\n";
       echo "    <table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\">\n";
       echo "      <tr>\n";
       echo "        <td align=\"center\" ><br /><br /><br /><span class=\"mirror\" style=\"font-size: 55px;\" >Table: $display6_table<br />Seat: $display6_seat</span><br /><br /><br /></td>\n";
       echo "      </tr>\n";
//       echo "      <tr><td>&nbsp;</td></tr>\n";
       echo "      <tr>\n";
       echo "        <td align=\"center\" ><br /><br /><br /><span style=\"font-size: 55px;\" >$display6_name</span></br>\n";
       echo "                             <span style=\"font-size: 20px;\">Extra Chips: $display6_extra_chips</span><br /><br /><br /></td>\n";
       echo "      </tr>\n";
       echo "    </table>\n";
       echo "    </td>\n";

       $x++;
     
     if ($x % 2 == 0 && $x % 4 != 0) {
       echo "  </tr>\n";
       echo "  <tr>\n";
     } 

     if ($x % 4 == 0) {
       echo "  </tr>\n";
       echo "</table>\n";
       echo "<a href=\"?sort=seat&x=$x\">NEXT PAGE</a>\n";
//       echo "<div class=\"breakhere\"></div>\n";
//       echo "<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\">\n";
//       echo "  <tr>\n";
       
       $x = $seat_num;
     }
    
   }

 }


 echo "</center>\n";
 echo "<script type=\"text/javascript\" src=\"modify.js\"></script>\n";

?>