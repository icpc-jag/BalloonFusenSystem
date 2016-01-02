<title>Balloon Fusen System</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php
require_once(dirname(__FILE__).'/common.php');
$pdo = getPDO();
$q = query($pdo, 'SELECT contest_name FROM contest', array());
foreach ($q as $x) {
    $contest_name = $x['contest_name'];
    echo "<p><a href=\"ranking.php?contest_name={$contest_name}\">{$contest_name}</a></p>";
}
