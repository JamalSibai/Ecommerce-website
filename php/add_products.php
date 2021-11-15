<?php
include "connection.php";
session_start();


if(isset($_POST["name"]) && $_POST["name"] != "" && strlen($_POST["name"])) {
    $name = $_POST["name"];
}else{
    die ("Enter a valid input");
}

if(isset($_POST["quantity"]) && $_POST["quantity"] != "" && strlen($_POST["quantity"])) {
    $quantity = $_POST["quantity"];
}else{
    die ("Enter a valid input");
}



if(isset($_POST["description"]) && $_POST["description"] != "" ) {
    $description = $_POST["description"];
}else{
    die ("Enter a valid input");
}

    $stmt = $connection->prepare("Select stores_id from users u, stores s where u.id = s.users_id and u.email =  ?");
    $stmt->bind_param('s', $_SESSION["login-email"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $row2 = $result-> fetch_assoc();
    $storeid = $row2["stores_id"];


    


    if(strlen($name)>20){
        session_start();
        $_SESSION["alerts"] = "The product name it too long";
        header("Location:../add_products.php");
    }else{
        $x = $connection->prepare("INSERT INTO `products` (`name`, `description`, `quantity`, `stores_id`) VALUES (?, ?, ?, ?)");
        $x->bind_param("ssss", $name, $description, $quantity, $storeid);
        $x->execute();
        $result2 = $x->get_result();
        
    }

    $stmt1 = $connection->prepare("Select * from products where name = ? and description = ?");
    $stmt1->bind_param('ss', $name,$description);
    $stmt1->execute();
    $result2 = $stmt1->get_result();
    $row3 = $result2-> fetch_assoc();
    $productid = $row3["id"];

    if(isset($_FILES['my_image'])){
        $img_name = $_FILES['my_image']['name'];
        $img_size = $_FILES['my_image']['size'];
        $tmp_name = $_FILES['my_image']['tmp_name'];
        $error = $_FILES['my_image']['error'];
    
        if ($error === 0) {
            if ($img_size > 125000) {
                session_start();
                $_SESSION["alerts"] = "Sorry, your file is too large.";
                header("Location:../add_products.php");
            }else {
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ex);
    
                $allowed_exs = array("jpg", "jpeg", "png"); 
    
                if (in_array($img_ex_lc, $allowed_exs)) {
                    $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
                    $img_upload_path = '../uploads/'.$new_img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);
    
                    // Insert into Database
                    $y_image = $connection->prepare("INSERT INTO `images` (`image`,`product_id`) VALUES (?,?)");
                    $y_image ->bind_param("ss", $new_img_name,$productid);
                    $y_image ->execute();
                    $result2 = $y_image->get_result();
                    header("Location:../add_products.php");

                    
                }
            }
        }else {
            session_start();
            $_SESSION["alerts"] = "unknown error occurred!";
            header("Location:../add_products.php");
        }
    }else{
        die ("Enter a valid input");
    }
?>