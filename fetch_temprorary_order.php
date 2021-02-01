<?php

$connection = new mysqli("localhost", "root", "", "online_store_db");
$sqlCommand = $connection->prepare("select id, name, price,  email, amount from temprorary_place_order inner join electronic_products on electronic_products.id = temprorary_place_order.product_id where email=?");
$sqlCommand->bind_param("s", $_GET["email"]);
$sqlCommand->execute();

$temporderarray = array();
$sqlResult = $sqlCommand->get_result();
while ($row=$sqlResult->fetch_assoc()) {
    array_push($temporderarray, $row);
}

echo json_encode($temporderarray);