<?php
require_once(dirname(__FILE__).'/common.php');

$pdo = getPDO();

query($pdo, 'UPDATE ac SET state = 1 WHERE id = ?', array($_GET['id']));
$q = query($pdo, 'SELECT contest_name, user_name FROM ac WHERE id = ?', array($_GET['id']));
foreach ($q as $x) {
    $contest_name = $x['contest_name'];
    $name = urlencode($x['user_name']);
    header("Location: /aclist.php?contest_name={$contest_name}&name={$name}");
    exit(0);
}
echo 'not found';
