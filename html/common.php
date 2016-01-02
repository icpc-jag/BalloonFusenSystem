<?php
define('PDO_dsn', 'mysql:dbname=bfs;host=localhost;charset=utf8mb4');
function getPDO()
{
    return new PDO(PDO_dsn, 'hoge', 'hogehoge', array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ));
}

function get_data_type($v)
{
    if (is_bool($v)) {
        return PDO::PARAM_BOOL;
    } elseif (is_null($v)) {
        return PDO::PARAM_NULL;
    } elseif (is_int($v)) {
        return PDO::PARAM_INT;
    } else {
        return PDO::PARAM_STR;
    }
}

function query(PDO $pdo, $statement, array $param, $classname = null)
{
    $pdos = $pdo->prepare($statement);
    if (is_string($classname)) {
        $pdos->setFetchMode(PDO::FETCH_CLASS, $classname);
    }
    $i = 1;
    foreach ($param as $p) {
        if (!$pdos->bindValue($i++, $p, get_data_type($p))) {
            throw new Exception('PDOStatement::bindValue failure');
        }
    }
    if (!$pdos->execute()) {
        throw new Exception('PDOStatement::execute failure');
    }
    return $pdos;
}

function auth($contest_name, $pdo)
{
    session_start();
    if (!isset($_SESSION[$contest_name])) {
        echo 'login error';
        exit(1);
    }
    $staff_code = $_SESSION[$contest_name];

    $q = query($pdo, 'SELECT staff_code FROM contest WHERE contest_name = ?', array($contest_name));
    foreach ($q as $x) {
        $contest_staff_code = $x['staff_code'];
        if ($staff_code !== $contest_staff_code) {
            echo 'pass code is wrong';
            exit(1);
        } else {
            return true;
        }
    }
    echo 'invalid contest_name';
    exit(1);
}

function exception_error_handler($errno, $errstr, $errfile, $errline) {
    switch ($errno) {
        case E_STRICT:
            error_log("E_STRICT: {$errstr} on line {$errline} in file {$errfile}");
            break;
        default:
            throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
    }
}
set_error_handler("exception_error_handler");
