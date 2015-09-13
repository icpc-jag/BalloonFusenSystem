<title>Balloon Fusen System</title>
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

$q = query($pdo,
    'SELECT problem_name, team_id, state FROM ac WHERE contest_name = ?',
    array($_GET['contest_name'])
);
$stands = array();
$problems = array();
foreach ($q as $x) {
    $problem_name = substr($x['problem_name'], -1);
    $team_id = $x['team_id'];
    $state = $x['state'];
    if (!isset($stands[$team_id])) {
        $stands[$team_id] = array();
    }
    $stands[$team_id][$problem_name] = true;
    $problems[$problem_name] = true;
}
$problems = array_keys($problems);
sort($problems);

$res = array();
$q = query($pdo, 'SELECT team_id, team_name, visible FROM team WHERE contest_name = ?', array($_GET['contest_name']));
foreach ($q as $x) {
    $team_id = $x['team_id'];
    $team_name = htmlspecialchars($x['team_name'], ENT_QUOTES, 'UTF-8', true);
    $visible = intval($x['visible']);
    $n = 0;
    $prob = array();
    foreach ($problems as $y) {
        if (isset($stands[$team_id][$y])) {
            $prob[] = array($y, '1');
            ++ $n;
        } else {
            $prob[] = array($y, '');
        }
    }
    $res[] = array(
        'team_id' => $team_id,
        'team_name' => $team_name,
        'visible' => $visible,
        'prob' => $prob,
        'total' => $n,
    );
}

function cmp($a, $b)
{
    if ($a['visible'] != $b['visible']) {
        return ($a['visible'] > $b['visible']) ? -1 : 1;
    }
    if ($a['total'] != $b['total']) {
        return ($a['total'] > $b['total']) ? -1 : 1;
    }
    if ($a['team_id'] != $b['team_id']) {
        return ($a['team_id'] > $b['team_id']) ? -1 : 1;
    }
    return 0;
}
usort($res, 'cmp');

echo '<table border="1" cellpadding="2">';
echo '<tr>';
echo "<td>-</td>";
foreach ($problems as $y) {
    echo "<th>{$y}</th>";
}
echo "<td>total</td>";
echo '</tr>';
foreach ($res as $x) {
    $team_id = $x['team_id'];
    $team_name = $x['team_name'];
    $v = 1 - $x['visible'];
    echo '<tr>';
    echo "<td><a href=\"switch.php?contest_name={$contest_name}&team_id={$team_id}&visible={$v}\">$team_name</a></td>";
    foreach ($x['prob'] as $y) {
        echo "<td>{$y[1]}</td>";
    }
    echo "<td>{$x['total']}</td>";
    echo '</tr>';
}
echo '</table>';
