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
// echo "<center>\n";
 echo "&nbsp;<br />\n";
 echo "&nbsp;<br />\n";
 echo "&nbsp;<br />\n";
 
 echo "<table class=\"titles\" cellspacing=\"0\" cellpadding=\"1\">\n";
 echo "  <tr>\n";
 echo "    <td align=\"center\" width=\"50\"><b>PLYRS</b></td>\n";
 echo "    <td align=\"center\" width=\"50\"><b>ENVLP</b></td>\n";
 echo "    <td align=\"center\" width=\"50\"><b>4PLAY</b></td>\n";
 echo "    <td align=\"center\" width=\"50\"><b>CASH</b></td>\n";
 echo "    <td align=\"center\" width=\"50\"><b>1<span class=\"sup\">st</span></b></td>\n";
 echo "    <td align=\"center\" width=\"50\"><b>2<span class=\"sup\">nd</span></b></td>\n";
 echo "  </tr>\n";
 
 $places_array = array("3" => "3<span class=\"sup\">rd</span>",
                        "4" => "4<span class=\"sup\">th</span>",
                        "5" => "5<span class=\"sup\">th</span>",
                        "6" => "6<span class=\"sup\">th</span>",
                        "7" => "7<span class=\"sup\">th</span>",
                        "8" => "8<span class=\"sup\">th</span>",
                        "9" => "9<span class=\"sup\">th</span>",
                       "10" => "10<span class=\"sup\">th</span>");

 $percentages[2] = array("0.60", "0.40", "0.00", "0.00", "0.00", "0.00", "0.00",  "0.00",  "0.00",  "0.00");
 $percentages[3] = array("0.50", "0.30", "0.20", "0.00", "0.00", "0.00", "0.00",  "0.00",  "0.00",  "0.00");
 $percentages[4] = array("0.40", "0.30", "0.20", "0.10", "0.00", "0.00", "0.00",  "0.00",  "0.00",  "0.00");
 $percentages[5] = array("0.40", "0.25", "0.15", "0.11", "0.09", "0.00", "0.00",  "0.00",  "0.00",  "0.00");
 $percentages[6] = array("0.37", "0.22", "0.15", "0.11", "0.08", "0.07", "0.00",  "0.00",  "0.00",  "0.00");
 $percentages[7] = array("0.30", "0.20", "0.15", "0.11", "0.09", "0.08", "0.07",  "0.00",  "0.00",  "0.00");
 $percentages[8] = array("0.30", "0.20", "0.14", "0.10", "0.08", "0.07", "0.06",  "0.05",  "0.00",  "0.00");
 $percentages[9] = array("0.29", "0.19", "0.12", "0.10", "0.08", "0.07", "0.06",  "0.05",  "0.04",  "0.00");
 $percentages[10] = array("0.29", "0.19", "0.12", "0.10", "0.08", "0.07", "0.055", "0.045", "0.035", "0.025");
 
// echo "<pre>";
// print_r($places_array);
// echo "</pre>";

// echo "<pre>";
// print_r($percentages);
// echo "</pre>";

 $b = 5;
 $buyin = 20;
 $places = 2;
 while ($b <= 150) {
   $fourplay = $b / 5;
      list($fpwhole, $fpinteger) = explode('.', $fourplay, 2);
      $fourplay = $fpwhole * 5;    
   $envelope       = (($b * $buyin) * 0.125) + ($fpinteger * 5);
   $cash           = ($b * $buyin) - $envelope - $fourplay;
   $cash_remainder = ($cash / 5);
 
//   echo "<b>$b</b> - <b>Envelope</b>: $envelope - 4-play: $fourplay - Payout Cash: $cash - $cash_remainder - ";

   list($whole, $integer) = explode('.', $cash_remainder, 2);
   $cash_remainder = $cash - ($whole * 5);

   echo "  <tr>\n";
   echo "    <td align=\"center\">$b</td>\n";
   echo "    <td align=\"center\">$$envelope</td>\n";
   echo "    <td align=\"center\">$$fourplay</td>\n";   

//   echo "$whole - $integer - $cash_remainder - ";

   if ($cash_remainder != 0) {
     if ($cash_remainder >= 2.5) {
       $cash     = $cash     + (5 - $cash_remainder);
       $envelope = $envelope - (5 - $cash_remainder);
     } else {
       $cash     = $cash     - $cash_remainder;
       $envelope = $envelope + $cash_remainder;
     }
     echo "$envelope - $cash\n";
   }

   echo "    <td align=\"center\">$$cash($cash_remainder)</td>\n";

/*   $payouts = 0;
   while ($payouts < $places) {
     $payout_percent = $percentages[$places][$payouts];
     $money          = $cash * $payout_percent;
     $over_under     = ($money / 5);
     list($whole2, $integer2) = explode('.', $over_under, 2);
     $over_under     = ($money - ($whole2 * 5)) + ($integer2 * 0.5);;
     if ($over_under >= 2.5) {
       $money     = $money + (5 - $over_under);
     } else {
       $money     = $money - $over_under;
     }

     echo "    <td align=\"center\">$$money($over_under)</td>\n";     

     $payouts++;
   }

   if (($b % 10) == 0 && $b != 10) {
     $places++;
     $position = $places_array[$places];
     echo "  <td align=\"center\"><b>$position</b></td>\n";
   }
*/
   $b++;
//   echo "  </tr>\n"; 
   echo "  <br />\n";
 }

 echo "</table>\n";
 echo "</center>\n";
 echo "</body>\n";
 echo "</html>\n";
?>
