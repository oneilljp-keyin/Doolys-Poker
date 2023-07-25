<?php
require_once "config.php";
$q = strtolower($_GET["q"]);
if (!$q) return;

$sql = "SELECT id, name, doolysnum FROM players WHERE name LIKE '%$q%'";
$rsd = mysqli_query($conn, $sql);
while($rs = mysqli_fetch_array($rsd)) {
	$player = $rs['name'];
	$player_id_num = $rs['id'].",".$rs['doolysnum'];
	echo "$player|$player_id_num\n";
}
?>