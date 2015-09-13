<?php
require_once(dirname(__FILE__).'/common.php');

$pdo = getPDO();

if (isset($_GET['force'])) {
    $q = query($pdo, 'UPDATE ac SET user_name = ? WHERE id = ?', array($_GET['name'], $_GET['id']));
} else {
    $q = query($pdo, 'UPDATE ac SET user_name = ? WHERE id = ? AND user_name IS NULL', array($_GET['name'], $_GET['id']));
}

$q = query($pdo, 'SELECT user_name FROM ac LEFT JOIN team USING(contest_name, team_id) WHERE id = ?', array($_GET['id']));
foreach ($q as $x) {
    $user_name = $x['user_name'];
    if ($user_name !== $_GET['name']) {
        $name = urlencode($_GET['name']);
        header("Location: /aclist.php?contest_name={$contest_name}&name={$name}");
        exit(0);
    } else {
        $id = intval($_GET['id']);
        header("Location: /ac.php?id={$id}");
        exit(0);
    }
}
echo 'not found';
