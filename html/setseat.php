<?php
require_once(dirname(__FILE__).'/common.php');

$contest_name = $_GET['contest_name'];
if (!isset($_POST['team_id'])) {
    echo 'team is not selected';
    exit(1);
}
$team_id = $_POST['team_id'];
$seat = $_POST['seat'];
$pass_code = $_POST['pass_code'];

if (!preg_match('/^[0-9]{0,8}$/D', $seat)) {
    echo 'invalid seat';
    exit(1);
}

$pdo = getPDO();

$q = query($pdo, 'SELECT 1 FROM team WHERE contest_name = ? AND team_id = ?', array($contest_name, $team_id));
$found = false;
foreach ($q as $x) {
    $found = true;
}
if (!$found) {
    echo 'invalid contest name or team id';
    exit(1);
}
$q = query($pdo, 'SELECT pass_code FROM contest WHERE contest_name = ?', array($contest_name));
$contest_pass_code = false;
foreach ($q as $x) {
    $contest_pass_code = $x['pass_code'];
}
if ($pass_code !== $contest_pass_code) {
    echo 'pass code is wrong';
    exit(1);
}

query($pdo, 'UPDATE team SET seat = ? WHERE contest_name = ? AND team_id = ?', array($seat, $contest_name, $team_id));

header("Location: /ranking.php?contest_name={$contest_name}");
