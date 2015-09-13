<title>Balloon Fusen System</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php
require_once(dirname(__FILE__).'/common.php');

$name = urlencode($_GET['name']);

$pdo = getPDO();

$q = query($pdo, 'SELECT contest_name FROM contest', array());
foreach ($q as $x) {
    $contest_name = urlencode($x['contest_name']);
    echo "<p><a href=\"aclist.php?contest_name={$contest_name}&name={$name}\">{$contest_name}</a></p>";
}
