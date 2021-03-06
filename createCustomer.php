<?php
require_once 'Connection.php';
require_once 'CustomerTableGateway.php';

$id = session_id();
if ($id == "") {
    session_start();
}

require 'ensureUserLoggedIn.php';

$connection = Connection::getInstance();
$gateway = new CustomerTableGateway($connection);

$name = filter_input(INPUT_POST, 'name',     FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$address = filter_input(INPUT_POST, 'address',  FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$mobile = filter_input(INPUT_POST, 'mobile', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email',   FILTER_SANITIZE_EMAIL);
$branchId   = filter_input(INPUT_POST, 'branch_id', FILTER_SANITIZE_NUMBER_INT);
if ($branchId == -1) {
    $branchId = NULL;
}

$id = $gateway->insertCustomer($name, $address, $mobile, $email, $branchId);
require_once 'Customer.php';
require_once 'Connection.php';
require_once 'CustomerTableGateway.php';

$id = session_id();
if ($id == "") {
    session_start();
}

require 'ensureUserLoggedIn.php';

$connection = Connection::getInstance();
$gateway = new CustomerTableGateway($connection);

$name = $_POST['name'];

$address = $_POST['address'];

$mobile = $_POST['mobile'];

$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$emailValid = filter_var($email, FILTER_VALIDATE_EMAIL);


$id = $gateway->insertCustomer($name, $address, $mobile, $email);

header('Location: viewCustomers.php');
