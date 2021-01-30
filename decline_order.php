<?php

$connection = new mysqli("localhost", "root", "", "online_store_db");
$check_login_info = $connection->prepare("delete from temprorary_place_order where email=?");
$check_login_info->bind_param("s", $_GET["email"]);
$check_login_info->execute();
