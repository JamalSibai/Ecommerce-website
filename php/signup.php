<?php
// functions
function number_check($phone){
    $pos = strpos($phone,"+961");
    if((strlen($phone)== 11 || strlen($phone)== 12) && $pos == 0){
        return true;
    }else{
        return false;
    }
}

function name_check($name){
    if(strlen($name)<3){
        return true;
    }
}

function email_check($email){
    $pos_dot = strripos($email,".");
    $pos_at = strripos($email,"@");
    if($pos_dot<$pos_at){
        return true;
    }
}

function pass_con($pass,$conf){
    if($pass == $conf && sizeof($_POST['password'])>5){
        return true;
    }
}
// end

include "connection.php";
if(isset($_POST["first_name"]) && $_POST["first_name"] != "" && strlen($_POST["first_name"])) {
    $first_name = $_POST["first_name"];
}else{
    die ("Enter a valid input");
}

if(isset($_POST["last_name"]) && $_POST["last_name"] != "" && strlen($_POST["last_name"])) {
    $last_name = $_POST["last_name"];
}else{
    die ("Enter a valid input");
}

if(isset($_POST["phone_number"]) && $_POST["phone_number"] != "" ) {
    $phone_number = $_POST["phone_number"];
}else{
    die ("Enter a valid input");
}

if(isset($_POST["email"]) && $_POST["email"] != "") {
    $email = $_POST["email"];
}else{
    die ("Enter a valid input");
}

if(isset($_POST["first_name"]) && $_POST["first_name"] != "" ) {
    $first_name = $_POST["first_name"];
}else{
    die ("Enter a valid input");
}

if(isset($_POST["password"]) && $_POST["password"] != "") {
    $password = hash('sha256', $_POST["password"]);
}else{
    die ("Enter a valid input");
}

if(isset($_POST["confirmpass"]) && $_POST["confirmpass"] != "") {
    $confirmpass = hash('sha256', $_POST["confirmpass"]);
}else{
    die ("Enter a valid input");
}

if(isset($_POST["usertype"]) && $_POST["usertype"] != "") {
    $usertype = $_POST["usertype"];
}else{
    die ("Enter a valid input");
}




    if(name_check($first_name) || name_check($last_name)){
        session_start();
        $_SESSION["alert"] = "First and Last name < 3 characters";
        header("Location:../signup.php");
    }else if ( number_check($phone_number) == false){
        session_start();
        $_SESSION["alert"] = "phone number not valid('+961')";
        header("Location:../signup.php");
    }else if(email_check($email)){
        session_start();
        $_SESSION["alert"] = "Email not valid";
        header("Location:../signup.php");
    }else if($password != $confirmpass && sizeof($_POST['password'])>5){
        session_start();
        $_SESSION["alert"] = "password invalid";
        header("Location:../signup.php");
    }else{

    $stmt = $connection->prepare("Select email from users where email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result-> fetch_assoc();
    if(empty($row["email"])){
        $x = $connection->prepare("INSERT INTO `users` (`first_name`, `last_name`, `phone`, `email`, `password`, `type`) VALUES (?, ?, ?, ?, ?, ?)");
        $x->bind_param("ssssss", $first_name, $last_name, $phone_number, $email, $password, $usertype);
        $x->execute();
        $result2 = $x->get_result();

    $stmt = $connection->prepare("Select id from users where email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result-> fetch_assoc();
    $id = $row["id"];

    $x = $connection->prepare("INSERT INTO `stores` (`users_id`) VALUES (?)");
    $x->bind_param("s", $id);
    $x->execute();
    $result2 = $x->get_result();
        header("Location:../login.php");
    }else{
        session_start();
        $_SESSION["flash"] = "Email already exists";
        header("Location:../signup.php");

    } 
}

    





























