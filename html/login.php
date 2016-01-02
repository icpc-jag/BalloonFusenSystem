<?php
require_once(dirname(__FILE__).'/common.php');

$contest_name = $_GET['contest_name'];
$staff_code = $_POST['staff_code'];
$name = urlencode($_POST['user_name']);

$pdo = getPDO();

$q = query($pdo, 'SELECT staff_code FROM contest WHERE contest_name = ?', array($contest_name));
$contest_staff_code = false;
foreach ($q as $x) {
    $contest_staff_code = $x['staff_code'];
}
if ($staff_code !== $contest_staff_code) {
    echo 'pass code is wrong';
    exit(1);
}

session_start();
$_SESSION[$contest_name] = $staff_code;

header("Location: /aclist.php?contest_name={$contest_name}&name={$name}");
