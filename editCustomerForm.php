<?php
require_once 'Connection.php';
require_once 'CustomerTableGateway.php';
require_once 'BranchTableGateway.php';

$id = session_id();
if ($id == "") {
    session_start();
}

require 'ensureUserLoggedIn.php';

if (!isset($_GET) || !isset($_GET['id'])) {
    die('Invalid request');
}
$id = $_GET['id'];

$connection = Connection::getInstance();
$gateway = new CustomerTableGateway($connection);
$gatewayBranch = new BranchTableGateway($connection);

$customers = $gateway->getCustomerById($id);
if ($customers->rowCount() !== 1) {
    die("Illegal request");
}
$customer = $customers->fetch(PDO::FETCH_ASSOC);

$branches = $gatewayBranch->getBranches();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Asset Management Agency</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,200,100,300,500,600,700,900,800' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Goudy+Bookletter+1911' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/component.css" />
    <link rel="stylesheet" type="text/css" href="css/content.css" />
    <script src="js/modernizr.custom.js"></script>
</head>

<body id="page-top" class="index">
    
    <?php
        if (!isset($username)) {
            $username = '';
        }
    ?>

        <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top navbar-shrink">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll navSmall">
                <!--<img src="../images/logo.png" class="logo">-->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-mainText mainTextFirst hidden-sm navText" style="margin-left:5px;" href="home.php">Aperture<br></a>
                <a class="navbar-mainText hidden-sm navText" style="margin-left:5px;" href="home.php">Asset Management</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navSmall" id="navbar-collapse-1">>
                <ul class="nav navbar-nav navbar-left">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li>
                        <a class="page-scroll" href="viewCustomers.php">Customers</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="viewBranches.php">Branches</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="viewProperties.php">Properties</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <i class="fa fa-search fa-2x" href="#"></i>
                    </li>
                    <li>
                    </li>
                     <li>
                            <button type="button" class="signButton" onclick="document.location.href = 'index.php'">Sign Out</button>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
        
    <section id="editCustomer">
        <div class="container">
            <div class="row">
                <form class="form-horizontal col-lg-9 col-lg-offset-3"  id="editCustomerForm" name="editCustomerForm" action="editCustomer.php" method="POST">
                    <input type="hidden" name="CustomerID" value="<?php echo $id; ?>" />
                    <table class="table-striped col-lg-6" border="0">
                        <tbody>
                            <tr class="subheadings">
                                <td>Name</td>
                                <td>
                                    <input class="form-control" type="text" name="name" value="<?php
                                        if (isset($_POST) && isset($_POST['name'])) {
                                            echo $_POST['name'];
                                        }
                                        else echo $customer['name'];
                                    ?>" />
                                    <span id="nameError" class="error"></span>
                                </td>
                            </tr>
                            <tr class="subheadings">
                                <td>Address</td>
                                <td>
                                    <input class="form-control" type="text" name="address" value="<?php
                                        if (isset($_POST) && isset($_POST['address'])) {
                                            echo $_POST['address'];
                                        }
                                        else echo $customer['address'];
                                    ?>" />
                                    <span id="addressError" class="error"></span>
                                </td>
                            </tr>
                            <tr class="subheadings">
                                <td>Email</td>
                                <td>
                                    <input class="form-control" type="text" name="email" value="<?php
                                        if (isset($_POST) && isset($_POST['email'])) {
                                            echo $_POST['email'];
                                        }
                                        else echo $customer['email'];
                                    ?>" />
                                    <span id="emailError" class="error"></span>
                                </td>
                            </tr>
                            <tr class="subheadings">
                                <td>Mobile</td>
                                <td>
                                    <input class="form-control" type="text" name="mobile" value="<?php
                                        if (isset($_POST) && isset($_POST['mobile'])) {
                                            echo $_POST['mobile'];
                                        }
                                        else echo $customer['mobile'];
                                    ?>" />
                                    <span id="mobileError" class="error"></span>
                                </td>
                            </tr>
                            <tr class="subheadings">
                                <td>Branch</td>
                                <td>
                                    <select name="branch_id">
                                        <option class="form-control" value="-1">No branch</option>
                                        <?php
                                        $b = $branches->fetch(PDO::FETCH_ASSOC);
                                        while ($b) {
                                            $selected = "";
                                            if ($b['branch_id'] == $customer['branch_id']) {
                                                $selected = "selected";
                                            }
                                            echo '<option value="' . $b['branch_id'] . '" ' . $selected . '>' . $b['address'] . '</option>';
                                            $b = $branches->fetch(PDO::FETCH_ASSOC);
                                        }
                                        ?>
                                    </select>
                            <tr class="subheadings">
                                <td></td>
                                <td>
                                    <input class="btn btn-default" type="submit" value="Edit Customer" name="editCustomer" />
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </form>
            </div>
        </div>
    </section>
                
        
    <!-- Footer Section -->
    <footer class="footerStick">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <span class="copyright text-muted hidden-xs">Copyright</span>
                </div>
                <div class="col-md-4">
                    <ul class="list-group browse">
                        <a class="footerLinks" href="#page-top"><li class="list-group-item">Browse:</li>
                        <li class="list-group-item">Search</li>
                        <li class="list-group-item">Play</li>
                        <li class="list-group-item">Explore</li>
                        <li class="list-group-item">Question</li>
                        </a>
                    </ul>
                </div>
                <div class="col-md-4">
                    <ul class="list-inline quicklinks">
                        <li><a href="#">Privacy Policy</a>
                        </li>
                        <li><a href="#">Terms of Use</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    
    
    </body>
</html>
