<?php
$host = "127.0.0.1";
$port = 3306;
$username = "username";
$password = "password";
$database = "restaurant";

$db = new PDO("mysql:host=$host;port=$port",
               $username,
               $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$db->exec("CREATE DATABASE IF NOT EXISTS `$database`");
$db->exec("use `$database`");

function tableExists($dbh, $id)
{
    $results = $dbh->query("SHOW TABLES LIKE '$id'");
    if(!$results) {
        return false;
    }
    if($results->rowCount() > 0) {
        return true;
    }
    return false;
}

$exists = tableExists($db, "reservations");

if (!$exists) {

    //create the database
    $db->exec("CREATE TABLE IF NOT EXISTS reservations (
        id INTEGER  PRIMARY KEY AUTO_INCREMENT NOT NULL,
        name TEXT,
        start DATETIME,
        end DATETIME,
        table_id VARCHAR(30))");

    $db->exec("CREATE TABLE locations (
        id INTEGER  PRIMARY KEY NOT NULL,
        name VARCHAR(200)  NULL)");

    $db->exec("CREATE TABLE tables (
        id INTEGER  PRIMARY KEY AUTO_INCREMENT NOT NULL,
        name VARCHAR(200)  NULL,
        location_id INTEGER  NULL)");

    $items = array(
        array('id' => '1', 'name' => 'Indoors'),
        array('id' => '2', 'name' => 'Terrace'),
    );
    $insert = "INSERT INTO locations (id, name) VALUES (:id, :name)";
    $stmt = $db->prepare($insert);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':name', $name);
    foreach ($items as $m) {
      $id = $m['id'];
      $name = $m['name'];
      $stmt->execute();
    }

    $items = array(
        array('location_id' => '1', 'name' => 'Table 1', 'seats' => 2),
        array('location_id' => '1', 'name' => 'Table 2', 'seats' => 2),
        array('location_id' => '1', 'name' => 'Table 3', 'seats' => 2),
        array('location_id' => '1', 'name' => 'Table 4', 'seats' => 4),
        array('location_id' => '2', 'name' => 'Table 5', 'seats' => 4),
        array('location_id' => '2', 'name' => 'Table 6', 'seats' => 6),
        array('location_id' => '2', 'name' => 'Table 7', 'seats' => 4),
        array('location_id' => '2', 'name' => 'Table 8', 'seats' => 4),
    );
    $insert = "INSERT INTO tables (location_id, name) VALUES (:location_id, :name)";
    $stmt = $db->prepare($insert);
    $stmt->bindParam(':location_id', $location_id);
    $stmt->bindParam(':name', $name);
    foreach ($items as $m) {
      $location_id = $m['location_id'];
      $name = $m['name'];
      $stmt->execute();
    }

}