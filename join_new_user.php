<?php

$connection = new mysqli("localhost", "root", "", "online_store_db");

// if email already exists, do not add the user again
$emailCheckSQLCommand = $connection->prepare("select * from app_users_table where email=?");
$emailCheckSQLCommand->bind_param("s", $_GET["email"]);
$emailCheckSQLCommand->execute();
$emailResult = $emailCheckSQLCommand->get_result();

if($emailResult->num_rows == 0) {
    $sqlCommand = $connection->prepare("insert into app_users_table values(?,?,?)");
    $sqlCommand->bind_param("sss", $_GET["email"], $_GET["username"], $_GET["password"]);
    $sqlCommand->execute();
    echo "A user added successfully";
} else {
    echo "A user with this Email address already exists";
}

// // http://localhost//android_ecommerce/insert_product.php?email=hello@mail.com&username=Jhon&password=123456