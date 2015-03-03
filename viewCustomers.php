<?php
require_once 'Connection.php';
require_once 'CustomerTableGateway.php';
require_once 'BranchTableGateway.php';
require 'ensureUserLoggedIn.php';

$connection = Connection::getInstance();
$gateway = new CustomerTableGateway($connection);
$gatewayBranch = new BranchTableGateway($connection);
$statement = $gateway->getCustomers();
$statementBranch = $gatewayBranch->getBranches();
?>
<!DOCTYPE html>
<html>
    <head>
        
        
        <meta charset="UTF-8">
        <link href="css/Style.css" rel="stylesheet">
        <script type="text/javascript" src="js/customer.js"></script>
        <script type="text/javascript" src="js/branch.js"></script>
        <link href='http://fonts.googleapis.com/css?family=Arvo:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Great+Vibes|Nunito:400,700|Raleway:400,700,800,600,500|Yanone+Kaffeesatz:400,700' rel='stylesheet' type='text/css'>
        <title>Asset Management Agency</title>
    </head>
    <body>
        <?php require 'toolbar.php' ?>
        <?php require 'header.php' ?>
        <?php require 'mainMenu.php' ?>
        
        <table class="customer">
            <thead>
            <th class="cListHead">
                Customer List
            </th>
            <tr class="subheadings">
                    <th class="testing">Name</th>
                    <th class="testing">Address</th>
                    <th class="testing">Mobile</th>
                    <th class="testingEmail">Email</th>
                    <th class="testing">Branch</th>
                </tr>
            </thead>
            <tbody class="attr">
                <?php
                $row = $statement->fetch(PDO::FETCH_ASSOC);
                while ($row) {
                    echo '<td>' . $row['name'] . '</td>';
                    echo '<td>' . $row['address'] . '</td>';
                    echo '<td>' . $row['mobile'] . '</td>';
                    echo '<td>' . $row['email'] . '</td>';
                    echo '<td>' . $row['bankAddress'] . '</td>';
                    echo '<td>'
                    . '<a class="tableProps tablePropsFirst" href="viewCustomer.php?id='.$row['Customer ID'].'">View</a> '
                    . '<a class="tableProps" href="editCustomerForm.php?id='.$row['Customer ID'].'">Edit</a> '
                    . '<a class="deleteCustomer tableProps" href="deleteCustomer.php?id='.$row['Customer ID'].'">Delete</a> '
                    . '</td>';
                    echo '</tr>';
                    $row = $statement->fetch(PDO::FETCH_ASSOC);
                }
                ?>
            </tbody>
        </table>
        <p><a class="createHome" href="createCustomerForm.php">Create Customer</a></p>
        <?php require 'footer.php'; ?>
    </body>
</html>
