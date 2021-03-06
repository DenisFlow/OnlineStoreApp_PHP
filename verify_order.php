<?php

$connection = new mysqli("localhost", "root", "", "online_store_db");
$getTemproraryOrdersCommand = $connection->prepare("select * from temprorary_place_order where email=?");
$getTemproraryOrdersCommand->bind_param("s", $_GET["email"]);
$getTemproraryOrdersCommand->execute();

$temporaryOrdersResult = $getTemproraryOrdersCommand->get_result();

$populateInvoiceWithEmailCommand = $connection->prepare("insert into invoice(email) values(?)");
$populateInvoiceWithEmailCommand->bind_param("s", $_GET["email"]);
$populateInvoiceWithEmailCommand->execute();

$getLatestInvoiceNumberCommand = $connection->prepare("select max(invoice_num) as latest_invoice_num from invoice where email=?");
$getLatestInvoiceNumberCommand->bind_param("s", $_GET["email"]);
$getLatestInvoiceNumberCommand->execute();
$invoice_number_result = $getLatestInvoiceNumberCommand->get_result();
$row_invoiceNumber = $invoice_number_result->fetch_assoc();

while ($row = $temporaryOrdersResult->fetch_assoc()) {
    $populateInvoiceDetailsCommand = $connection->prepare("insert into invoice_details values (?,?,?)");
    $populateInvoiceDetailsCommand->bind_param("iii", $row["product_id"], $row_invoiceNumber["latest_invoice_num"], $row["amount"]);
    $populateInvoiceDetailsCommand->execute();

    $deleteTempOrdersCommand = $connection->prepare("delete from temprorary_place_order where email=?");
    $deleteTempOrdersCommand->bind_param("s", $_GET["email"]);
    $deleteTempOrdersCommand->execute();
}

echo $row_invoiceNumber["latest_invoice_num"];