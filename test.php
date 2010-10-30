<?php

$data = array();

$data = array();
$data['Bursley'] = array();
$data['Mojo'] = array();
$data['Bursley']['Breakfast'] = array('A', 'B', 'C');
$data['Bursley']['Lunch'] = array('D', 'E', 'F');
$data['Bursley']['Dinner'] = array('H', 'I', 'J');
$data['Mojo']['Breakfast'] = array('K', 'L', 'M');
$data['Mojo']['Lunch'] = array('N', 'O', 'P');
$data['Mojo']['Dinner'] = array('Q', 'R', 'S');

echo json_encode($data);

?>