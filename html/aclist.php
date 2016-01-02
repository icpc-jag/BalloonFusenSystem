<title>Balloon Fusen System</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
.aclist p { margin-bottom: 2em; }
</style>
<div class="aclist">
<?php
require_once(dirname(__FILE__).'/common.php');

$contest_name = $_GET['contest_name'];
$name = urlencode($_GET['name']);

$pdo = getPDO();
auth($contest_name, $pdo);

$q = query($pdo, 'SELECT id, problem_name, team_name, seat, user_name, state FROM ac LEFT JOIN team USING(contest_name, team_id) WHERE contest_name = ? AND seat != "" ORDER BY id DESC', array($contest_name));
foreach ($q as $x) {
    $id = $x['id'];
    $problem_name = $x['problem_name'];
    $seat = $x['seat'];
    $team_name = htmlspecialchars($x['team_name'], ENT_QUOTES, 'UTF-8', true);
    $state = intval($x['state']);
    if ($state) {
        $user_name = htmlspecialchars($x['user_name'], ENT_QUOTES, 'UTF-8', true);
        echo "<p>{$seat} {$problem_name} <strong>{$team_name}</strong> {$user_name}</p>";
    } else {
        if (is_null($x['user_name'])) {
            $user_name = '<span style="color:red">★</span>';
            $force = '';
            $on_submit = '';
        } else {
            $user_name = htmlspecialchars($x['user_name'], ENT_QUOTES, 'UTF-8', true);
            $force = '&force=1';
            $on_submit = ' onsubmit="return confirm(\'Are you sure?\')"';
        }
        echo "<form method=\"post\" action=\"deliver.php?contest_name={$contest_name}&name={$name}&id={$id}{$force}\"{$on_submit}>";
        echo "<p>{$seat} {$problem_name} <strong>{$team_name}</strong> <button type=\"submit\">風船を配る</button> {$user_name}</p>";
        echo "</form>";
    }
}
?>
</div>
