<?php

include_once "DB.php";
include_once "Customer.php";
include_once "Order.php";

Define("SELECT_CUSTOMER_ORDER", "SELECT customerName, phone, addressLine1, creditLimit FROM orders INNER JOIN customers ON orderNumber = :orderNumber AND customers.customerNumber = orders.customerNumber");
define("SELECT_PRODUCT_ORDER", "SELECT productName, quantityOrdered, priceEach FROM orderdetails INNER JOIN products ON orderdetails.productCode = products.productCode WHERE orderNumber = :orderNumber");
define("UPDATE_STATUS_ORDER", "update orders set status= :status where orderNumber=:orderNumber");

$id = $_GET["id"];
DB::getInstance();
//$order = new Order($id);
$data = ["orderNumber" => $id];
$customer = DB::getData(SELECT_CUSTOMER_ORDER, $data);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["status"])) {
//        $order = new Order($id, $_POST["status"]);
        $data1 = ["orderNumber" => $id, "status" => $_POST["status"]];
        DB::update(UPDATE_STATUS_ORDER, $data1);

        header("location: index.php");
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <table class="table table-dark">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Phone</th>
            <th scope="col">Address</th>
            <th scope="col">Credit Limit</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($customer as $key => $item): ?>
            <tr>
                <th scope="row"><?php echo $key ?></th>
                <td><?php echo $item->customerName ?></a></td>
                <td><?php echo $item->phone ?></td>
                <td><?php echo $item->addressLine1 ?></td>
                <td><?php echo $item->creditLimit ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div>
        <form method="post">
            <?php define("GET_STATUS", "SELECT status FROM orders GROUP BY status"); ?>
            <select name="status">
                <?php foreach ($status = DB::getData(GET_STATUS) as $key => $item): ?>
                    <option><?php echo $item->status; ?></option>
                <?php endforeach; ?>
            </select>
            <input type="submit" value="Update">
        </form>
    </div>
    <table class="table table-dark">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Product Name</th>
            <th scope="col">Quantity Ordered</th>
            <th scope="col">Price Each</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($listOrder = DB::getData(SELECT_PRODUCT_ORDER, $data) as $key => $item): ?>
            <tr>
                <th scope="row"><?php echo $key ?></th>
                <td><?php echo $item->productName ?></td>
                <td><?php echo $item->quantityOrdered ?></td>
                <td><?php echo $item->priceEach ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>
</body>
</html>
