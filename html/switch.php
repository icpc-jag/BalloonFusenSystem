<?php
require_once(dirname(__FILE__).'/common.php');

$contest_name = $_GET['contest_name'];

$pdo = getPDO();

$q = query($pdo, 'SELECT 1 FROM contest WHERE contest_name = ?', array($contest_name));
$found = false;
foreach ($q as $x) {
    $found = true;
}
if (!$found) {
    echo 'invalid contest name';
    exit(1);
}

query($pdo, 'UPDATE team SET visible = ? WHERE contest_name = ? AND team_id = ?', array(
    intval($_GET['visible']),
    $_GET['contest_name'],
    $_GET['team_id'],
));
header("Location: /ranking.php?contest_name={$contest_name}");
