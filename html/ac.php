<title>Balloon Fusen System</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php
require_once(dirname(__FILE__).'/common.php');

$contest_name = $_GET['contest_name'];
$name = urlencode($_GET['name']);
$id = intval($_GET['id']);

$pdo = getPDO();
auth($contest_name, $pdo);

$q = query($pdo, 'SELECT problem_name, seat, team_name FROM ac LEFT JOIN team USING(contest_name, team_id) WHERE id = ?', array($id));
foreach ($q as $x) {
    $problem_name = $x['problem_name'];
    $seat = $x['seat'];
    $team_name = htmlspecialchars($x['team_name'], ENT_QUOTES, 'UTF-8', true);
    echo "<form method=\"post\" action=\"done.php?contest_name={$contest_name}&name={$name}&id={$id}\">";
    echo "<p>problem: <strong>{$problem_name}</strong></p>";
    echo "<p>seat: <strong>{$seat}</strong></p>";
    echo "<p>team: <strong>{$team_name}</strong></p>";
    echo "<p><button type=\"submit\">done</button></p>";
    echo "</form>";
    exit(0);
}
echo 'not found';
