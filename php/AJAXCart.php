<?php
include "connection.php";
session_start();
$variable = $_POST;

foreach($variable as $name => $value){
    $nameid = explode(",",$name);
    $response = "order placed";
    for($i=0;$i<sizeof($nameid);$i = $i + 2){
    $id = $nameid[$i];
    $quantity = $nameid[$i+1];
    $stmt = $connection->prepare("Select * from products where id = ?;");
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result-> fetch_assoc();
    if((int)$row["quantity"] >= $quantity){
        
        $stmt1 = $connection->prepare("INSERT INTO sold_products 
        (user_id, product_id, quantity_sold )
        VALUES (?,?,?);");
        $stmt1->bind_param('sss', $_SESSION["login-id"], $id, $quantity);
        $stmt1->execute();

        $stmt2 = $connection->prepare("UPDATE products
        SET quantity = quantity - ?
        WHERE id = ?;");
        $stmt2->bind_param('ss', $quantity, $id);
        $stmt2->execute();
        echo $response."<br/>";

    }else{
        $response = "not enough products of ".$row["name"];
        echo $response;
    }
    
}
    
}

?>