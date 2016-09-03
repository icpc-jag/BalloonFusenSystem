<?php
require_once(dirname(__FILE__).'/common.php');

$contest_name = $_GET['contest_name'];

$pdo = getPDO();

$q = query($pdo,
    'SELECT count(1) AS cnt FROM ac LEFT JOIN team USING(contest_name, team_id) WHERE contest_name = ? AND seat <> ""',
    array($contest_name)
);
foreach ($q as $x) {
    $cnt_visible = $x['cnt'];
}

$q = query($pdo,
    'SELECT count(1) AS cnt FROM ac WHERE contest_name = ?',
    array($contest_name)
);
foreach ($q as $x) {
    $cnt_total = $x['cnt'];
}

$q = query($pdo,
    'SELECT clar_hash FROM clar WHERE contest_name = ?',
    array($contest_name)
);
$clar_hash = '';
foreach ($q as $x) {
    $clar_hash = $x['clar_hash'];
}

echo "{$cnt_visible} {$cnt_total} {$clar_hash}";
