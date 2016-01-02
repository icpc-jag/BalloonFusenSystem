<?php
require_once(dirname(dirname(__FILE__)).'/html/common.php');

$pdo = getPDO();

$contest = explode("\n", file_get_contents('contest.txt'));
$contest_name = $contest[1];
$pass_code = $contest[2];
$staff_code = $contest[3];

query($pdo, 'INSERT IGNORE INTO contest(contest_name, pass_code, staff_code) VALUES (?, ?, ?)',
    array($contest_name, $pass_code, $staff_code)
);

$teams = explode("\n", file_get_contents('teams.tsv'));
foreach ($teams as $row) if ($row !== '') {
    list($team_id, $team_name) = explode("\t", $row);
    query($pdo,
        'INSERT INTO team(contest_name, team_id, team_name) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE team_name = ?',
        array($contest_name, $team_id, $team_name, $team_name)
    );
}

$q = query($pdo, 'SELECT problem_name, team_id FROM ac WHERE contest_name = ?', array($contest_name));
$a = array();
foreach ($q as $x) {
    $problem_name = $x['problem_name'];
    $team_id = $x['team_id'];
    if (!isset($a[$problem_name])) {
        $a[$problem_name] = array();
    }
    $a[$problem_name][$team_id] = true;
}

$ac = explode("\n", file_get_contents('ac.tsv'));
foreach ($ac as $row) if ($row !== '') {
    list($team_id, $problem_name) = explode("\t", $row);
    if (!isset($a[$problem_name][$team_id])) {
        query($pdo,
            'INSERT INTO ac(contest_name, problem_name, team_id) VALUES (?, ?, ?)',
            array($contest_name, $problem_name, $team_id)
        );
    }
}

$clar = file_get_contents('clar.txt');
query($pdo,
    'INSERT INTO clar(contest_name, clar_hash) VALUES (?, ?) ON DUPLICATE KEY UPDATE clar_hash = ?',
    array($contest_name, $clar, $clar)
);
