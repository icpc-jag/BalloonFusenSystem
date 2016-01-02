<?php
require_once(dirname(__FILE__).'/common.php');

$contest_name = $_GET['contest_name'];
$name = urlencode($_GET['name']);
$id = intval($_GET['id']);

$pdo = getPDO();
auth($contest_name, $pdo);

if (isset($_GET['force'])) {
    query($pdo, 'UPDATE ac SET user_name = ? WHERE id = ?', array($_GET['name'], $id));
} else {
    query($pdo, 'UPDATE ac SET user_name = ? WHERE id = ? AND user_name IS NULL', array($_GET['name'], $id));
}

$q = query($pdo, 'SELECT user_name FROM ac LEFT JOIN team USING(contest_name, team_id) WHERE id = ?', array($id));
foreach ($q as $x) {
    $user_name = $x['user_name'];
    if ($user_name !== $_GET['name']) {
        header("Location: /aclist.php?contest_name={$contest_name}&name={$name}");
        exit(0);
    } else {
        header("Location: /ac.php?contest_name={$contest_name}&name={$name}&id={$id}");
        exit(0);
    }
}
echo 'not found';
