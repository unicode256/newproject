<?php
ob_start();
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '12042001');
define('DB', 'exp_users');

/*function sendMessage($to_id, $from_id, $msg){
$query_1 = "SELECT `id` FROM `dialog` WHERE `send` = '$from_id' AND `recieve` = '$to_id' OR `send` = '$to_id' AND `recieve` = '$from_id'";

$result_1 = mysqli_query($CONNECT, $query_1) or die ('Ошибка запроса к серверу 11');

if (mysqli_num_rows($result_1) == 0){
	$query_2 = "INSERT INTO `dialog` (`status`, `send`, `recieve`) VALUES (0, $from_id, $to_id)";
	$result_2 = mysqli_query($CONNECT, $query_2) or die ('Ошибка запроса к серверу 2');
	$did = mysqli_insert_id($CONNECT);
} else {
	$row = mysqli_fetch_array($result_1);
	$did = $row['id'];
	$query_2 = "UPDATE `dialog` SET `status` = 0, `send` = '$from_id', `recieve` = '$to_id' WHERE `id` = '$did'";
	$result_2 = mysqli_query($CONNECT, $query_2) or die ('Ошибка запроса к серверу 3');
}
$query_3 = "INSERT INTO `message` (did, user, text, date) VALUES ($did, $from_id, '$message', NOW())";
$reult_3 = mysqli_query($CONNECT, $query_3) or die ('Ошибка запроса к серверу 4');
}*/

/*function sendMessage($id1, $id2, $msg){

$row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `id` FROM `dialog` WHERE `recieve` = '$id2' AND `send` = '$id1' OR `recieve` = '$id1' AND `send` = '$id2'"));

if($row){
$did = row['id'];
mysqli_query($CONNECT, "UPDATE `dialog` SET `status` = 0, `send` = '$id1', `resieve` = '$id2' WHERE `id` = '$did'");
} else {

mysqli_query($CONNECT, "INSERT INTO `dialog` VALUES ('', 0, $id1, $id2)");
$did = mysqli_insert_id($CONNECT);
}

mysqli_query($CONNECT, "INSERT INTO `message` VALUES ('', $did, $id1, $id2, '$msg', NOW())");
mysqli_close($CONNECT);
}*/

?>


