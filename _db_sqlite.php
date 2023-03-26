<?php

date_default_timezone_set("UTC");

$db_exists = file_exists("daypilot.sqlite");

$db = new PDO('sqlite:daypilot.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (!$db_exists) {
    //create the database
    $db->exec("CREATE TABLE IF NOT EXISTS [reservations] (
        [id] INTEGER  PRIMARY KEY AUTOINCREMENT NOT NULL,
        [name] TEXT,
        [start] DATETIME,
        [end] DATETIME,
        [table_id] VARCHAR(30))");

    $db->exec("CREATE TABLE [locations] (
        [id] INTEGER  PRIMARY KEY AUTOINCREMENT NOT NULL,
        [name] VARCHAR(200)  NULL)");

    $db->exec("CREATE TABLE [tables] (
        [id] INTEGER  PRIMARY KEY AUTOINCREMENT NOT NULL,
        [name] VARCHAR(200)  NULL,
        [seats] INTEGER,
        [location_id] INTEGER  NULL)");

    $items = array(
        array('id' => '1', 'name' => 'Indoors'),
        array('id' => '2', 'name' => 'Terrace'),
    );
    $insert = "INSERT INTO [locations] (id, name) VALUES (:id, :name)";
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
    $insert = "INSERT INTO [tables] (location_id, name, seats) VALUES (:location_id, :name, :seats)";
    $stmt = $db->prepare($insert);
    $stmt->bindParam(':location_id', $location_id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':seats', $seats);
    foreach ($items as $m) {
      $location_id = $m['location_id'];
      $name = $m['name'];
      $seats = $m['seats'];
      $stmt->execute();
    }

}
