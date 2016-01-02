<?php
require_once(dirname(__FILE__).'/common.php');

$contest_name = $_GET['contest_name'];
$name = urlencode($_GET['name']);
$id = intval($_GET['id']);

$pdo = getPDO();
auth($contest_name, $pdo);

query($pdo, 'UPDATE ac SET state = 1 WHERE id = ?', array($id));

header("Location: /aclist.php?contest_name={$contest_name}&name={$name}");
