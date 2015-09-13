<title>Balloon Fusen System</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php
require_once(dirname(__FILE__).'/common.php');

$pdo = getPDO();

$q = query($pdo, 'SELECT problem_name, team_name FROM ac LEFT JOIN team USING(contest_name, team_id) WHERE id = ?', array($_GET['id']));
foreach ($q as $x) {
    $problem_name = $x['problem_name'];
    $team_name = htmlspecialchars($x['team_name'], ENT_QUOTES, 'UTF-8', true);
    $id = intval($_GET['id']);
    echo "<form method=\"post\" action=\"done.php?id={$id}\">";
    echo "<p>problem: <strong>{$problem_name}</strong></p>";
    echo "<p>team: <strong>{$team_name}</strong></p>";
    echo "<p><button type=\"submit\">done</button></p>";
    echo "</form>";
    exit(0);
}
echo 'not found';
