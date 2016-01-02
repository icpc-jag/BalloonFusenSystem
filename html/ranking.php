<title>Balloon Fusen System</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
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
$q = query($pdo, 'SELECT team_id, team_name, seat FROM team WHERE contest_name = ?', array($_GET['contest_name']));
foreach ($q as $x) {
    $team_id = $x['team_id'];
    $team_name = htmlspecialchars($x['team_name'], ENT_QUOTES, 'UTF-8', true);
    $seat = htmlspecialchars($x['seat'], ENT_QUOTES, 'UTF-8', true);
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
        'seat' => $seat,
        'visible' => $seat !== '',
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

echo "<form method=\"post\" action=\"setseat.php?contest_name={$contest_name}\">";
echo '<p><label>seat number: <input type="text" name="seat" pattern="[0-9]{0,8}"></label></p>';
echo '<p><label>pass code: <input type="text" name="pass_code"></label></p>';
echo '<p><input type="submit" value="set seat number"></p>';
echo '<table border="1" cellpadding="2">';
echo '<tr><td></td><th>team name</th><th>seat</th><th>total</th>';
foreach ($problems as $y) {
    echo "<th>{$y}</th>";
}
echo '</tr>';
foreach ($res as $x) {
    $team_id = $x['team_id'];
    $team_name = $x['team_name'];
    $seat = $x['seat'];
    echo '<tr>';
    echo "<td><input type=\"radio\" name=\"team_id\" value=\"{$team_id}\"></td>";
    echo "<td>{$team_name}</td>";
    echo "<td>{$seat}</td>";
    echo "<td>{$x['total']}</td>";
    foreach ($x['prob'] as $y) {
        echo "<td>{$y[1]}</td>";
    }
    echo '</tr>';
}
echo '</table>';
echo '</form>';
echo "<form method=\"post\" action=\"login.php?contest_name={$contest_name}\">";
echo '<p><label>your name: <input type="text" name="user_name"></label></p>';
echo '<p><input type="password" name="staff_code"><input type="submit" value="staff login"></p>';
echo '</form>';
