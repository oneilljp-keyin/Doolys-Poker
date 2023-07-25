<?php

include("dbinfo.php");

$root_src = $_SERVER['HTTP_HOST'] == "localhost"
  ? "http://localhost/joww/"
  : "https://wrestling.johnny-o.net/";

echo "<!DOCTYPE html>\n";
echo "<html lang=\"en\">\n";
echo "  <head>\n";
echo "    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\n";
echo "    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" >\n";
echo "    <link href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css\" 
                rel=\"stylesheet\" integrity=\"sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD\" crossorigin=\"anonymous\">\n";
echo "    <link rel=\"stylesheet\" type=\"text/css\" href=\"";
if (isset($level)) echo ".";
echo "./css.css\"   >\n";
echo "    <link href=\"./favicon.ico\" rel=\"icon\" type=\"image/x-icon\" >\n";
echo "    <link href=\"./icon-32.png\" rel=\"icon\" type=\"image/png\" >\n";
echo "    <title>Dooly&#39; Poker Stats</title>\n";
echo "  </head>\n";

echo "  <body>\n";
echo "    <div id=\"root\">\n";
echo "      <div class=\"main-container p-0\">\n";
echo "        <div class=\"table-responsive-sm\">\n";
echo "          <table class=\"table table-sm table-dark table-striped table-hover table-borderless left-white\">\n";
echo "            <thead>\n";
echo "              <tr class=\"top-white\">\n";
echo "                <th scope=\"col\" >&nbsp;</th>\n";
echo "                <th scope=\"col\" >Name</th>\n";
echo "                <th scope=\"col\" class=\"text-center left-white\" >Total<br>Games</th>\n";
echo "                <th scope=\"col\" class=\"text-center left-grey\"  >Win %</th>\n";
echo "                <th scope=\"col\" class=\"text-center\"            >Top 3 %</th>\n";
echo "                <th scope=\"col\" class=\"text-center\"            >Top 5 %</th>\n";
echo "                <th scope=\"col\" class=\"text-center left-grey\"  >Bubble %</th>\n";
echo "                <th scope=\"col\" class=\"text-center\"            >Final Table %</th>\n";
echo "              </tr>\n";
echo "            </thead>\n";
echo "            <tbody>\n";

$record_query =
  "SELECT `t2`.`id` AS `player_id`, `t2`.`name` AS `player_name`,
        COUNT(`t1`.`id`) as `total_games`,
        (SUM(IF(`t1`.`finish` =  1,  1, 0)) / COUNT(`t1`.`player_id`)) as `first_percent`,
        (SUM(IF(`t1`.`finish` >= 3,  1, 0)) / COUNT(`t1`.`player_id`)) as `top3_percent`,
        (SUM(IF(`t1`.`finish` >= 5,  1, 0)) / COUNT(`t1`.`player_id`)) as `top5_percent`,
        (SUM(IF(`t1`.`bubble` =  1,  1, 0)) / COUNT(`t1`.`player_id`)) as `bubble_percent`,
        (SUM(IF(`t1`.`finish` >= 10, 1, 0)) / COUNT(`t1`.`player_id`)) as `final_percent`
FROM `points` AS `t1`
LEFT JOIN `players` AS `t2`
  ON `t1`.`player_id` = `t2`.`id`
GROUP BY `t2`.`id`
HAVING COUNT(`t1`.`player_id`) > 1 AND `total_games` > 0
ORDER BY `total_games` DESC, `name` ASC
LIMIT 50";

$record_result = $conn->query($record_query);

$n = 1;
while ($row = $record_result->fetch_assoc()) {
  echo "              <tr>\n";
  echo "                <td class=\"text-start\">$n.</td>\n";
  echo "                <td class=\"text-start left-white\"  ><a href=\"" . $root_src . "details.php?id=" . $row['player_id'] . "&amp;name=" . $row['player_name'] . "\">" . $row['player_name'] . "</a></td>\n";
  echo "                <td class=\"text-center left-grey\"  >" . $row['total_games'] . "</td>\n";
  echo "                <td class=\"text-center left-white\" >" . sprintf('%.1f', $row['first_percent'] * 100) . "</td>\n";
  echo "                <td class=\"text-center left-grey\"     >" . sprintf('%.1f', $row['top3_percent'] * 100) . "</td>\n";
  echo "                <td class=\"text-center\"             >" . sprintf('%.1f', $row['top5_percent'] * 100) . "</td>\n";
  echo "                <td class=\"text-center\"               >" . sprintf('%.1f', $row['bubble_percent'] * 100) . "</td>\n";
  echo "                <td class=\"text-center\"             >" . sprintf('%.1f', $row['final_percent'] * 100) . "</td>\n";
  echo "              <tr>\n";
  $n++;
}

echo "            </tbody>\n";
echo "          </table>\n";
echo "        </div>\n";
echo "      </div>\n";
echo "    </div>\n";
echo "  </body>\n";
echo "</html>\n";
