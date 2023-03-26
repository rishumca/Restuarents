<?php
require_once '_db.php';

$db_locations = $db->query('SELECT * FROM locations ORDER BY name');

class Location {}
class Table {}

$locations = array();

foreach($db_locations as $location) {
  $g = new Location();
  $g->id = "location_".$location['id'];
  $g->name = $location['name'];
  $g->expanded = true;
  $g->cellsDisabled = true;
  $g->children = array();
  $locations[] = $g;

  $stmt = $db->prepare('SELECT * FROM tables WHERE location_id = :location ORDER BY name');
  $stmt->bindParam(':location', $location['id']);
  $stmt->execute();
  $db_tables = $stmt->fetchAll();

  foreach($db_tables as $table) {
    $r = new Table();
    $r->id = $table['id'];
    $r->name = $table['name'];
    $r->seats = $table['seats'];
    $g->children[] = $r;
  }
}

header('Content-Type: application/json');
echo json_encode($locations);
