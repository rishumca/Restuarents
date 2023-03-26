<?php
require_once '_db.php';

$json = file_get_contents('php://input');
$params = json_decode($json);

$stmt = $db->prepare('SELECT * FROM reservations WHERE NOT ((end <= :start) OR (start >= :end))');
$stmt->bindParam(':start', $_GET['start']);
$stmt->bindParam(':end', $_GET['end']);
$stmt->execute();
$result = $stmt->fetchAll();

class Reservation {}
$reservations = array();

foreach($result as $row) {
  $e = new Reservation();
  $e->id = $row['id'];
  $e->text = $row['name'];
  $e->start = $row['start'];
  $e->end = $row['end'];
  $e->resource = $row['table_id'];
  $reservations[] = $e;
}

header('Content-Type: application/json');
echo json_encode($reservations);
