<?php

$connection = new mysqli("localhost", "root", "", "online_store_db");
$check_login_info = $connection->prepare("insert into temprorary_place_order values(?, ?, ?)");
$check_login_info->bind_param("sii", $_GET["email"], $_GET["product_id"], $_GET["amount"]);
$check_login_info->execute();