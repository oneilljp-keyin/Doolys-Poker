SELECT `t2`.`id` AS `player_id`, `t2`.`name` AS `player_name`,
COUNT(`t1`.`id`) as `total_games`,
(SUM(IF(`t1`.`finish` = 1, 1, 0)) / COUNT(`t1`.`player_id`)) as `first_percent`,
(SUM(IF(`t1`.`finish` >= 3, 1, 0)) / COUNT(`t1`.`player_id`)) as `top3_percent`,
(SUM(IF(`t1`.`finish` >= 5, 1, 0)) / COUNT(`t1`.`player_id`)) as `top5_percent`,
(SUM(IF(`t1`.`finish` >= 10, 1, 0)) / COUNT(`t1`.`player_id`)) as `final_percent`,
SUM(IF(`t1`.`finish` = 1, 1, 0)) as `first_place`,
SUM(IF(`t1`.`finish` = 2, 1, 0)) as `second_place`,
SUM(IF(`t1`.`finish` = 3, 1, 0)) as `third_place`,
SUM(IF(`t1`.`finish` = 4, 1, 0)) as `forth_place`,
SUM(IF(`t1`.`finish` = 5, 1, 0)) as `fifth_place`,
SUM(IF(`t1`.`finish` = 6, 1, 0)) as `sixth_place`,
SUM(IF(`t1`.`finish` = 7, 1, 0)) as `seventh_place`,
SUM(IF(`t1`.`finish` = 8, 1, 0)) as `eighth_place`,
SUM(IF(`t1`.`finish` = 9, 1, 0)) as `nineth_place`,
SUM(IF(`t1`.`finish` = 10, 1, 0)) as `tenth_place`,
SUM(IF(`t1`.`finish` > 10, 1, 0)) as `other_place`,
SUM(IF(`t1`.`bubble` = 1, 1, 0)) as `bubble`
FROM `points` AS `t1`
LEFT JOIN `players` AS `t2`
  ON `t1`.`player_id` = `t2`.`id`
GROUP BY `t2`.`id`
HAVING COUNT(`t1`.`player_id`) > 1 AND `total_games` > 0
ORDER BY `total_games` DESC, `name` ASC
LIMIT 25
