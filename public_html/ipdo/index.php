<?php
include 'config.php';
include 'class.lpdo.php';
$db = new ipdo($config['Database']);
$table_product_details = 'product_details';

echo "<pre>";
//print_r($config);

// // Insert Data
// $data = array('product_name' => 'Test Prod', 'size' => '1', 'cost' => '4500');
// $r = $db->insert($table_product_details, $data);
// print_r($r);

// // Select 1 Data
// //$condition = array('id' => 1);
// $column = array('product_name');
// $rs = $db->get_rows($table_product_details, $condition, '', $column);
// print_r($rs);

// // Select All Data
// $rs = $db->get_rows($table_product_details);
// print_r($rs);

// // Update
// $data = array('product_name' => 'changed name', 'size' => '1', 'cost' => '4500');
// $condition = array('id' => 9);
// $rs = $db->update($table_product_details, $data, $condition);
// print_r($rs);

// // Delete
// $condition = array('id' => 9);
// $rs = $db->delete($table_product_details, $condition);
// print_r($rs);

// // where >/< 
// $condition = array('cost' => array(90, '>'));
// $rs = $db->get_rows($table_product_details, $condition);
// print_r($rs);

// // CustomQuery
// $rs = $db->cQuery("select * from $table_product_details where cost > 60");
// print_r($rs);

