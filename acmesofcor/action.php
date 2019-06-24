<?php
session_start();
require 'init.php';

if(isset($_POST["username"])){
    $pass = md5($_POST["password"]);
    $query = "SELECT * FROM usuarios WHERE username = '".$_POST["username"]."' AND passw = '".$pass."'";
    $result = $mysqli->query($query);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()) { 
            $_SESSION["username"] = $row["username"];
            $_SESSION["userId"] = $row["Id_user"];
        }
        header("Location: index.php");
    }else{
        echo "No";
    }
}

if(isset($_POST["action"])){
    unset($_SESSION["username"]);
    unset($_SESSION["password"]);
}

if(isset($_POST["srcimg"])){
    if(isset($_SESSION["username"])){
        $userid = $_SESSION["userId"];
        $src = $_POST["srcimg"];
        $sql = "INSERT INTO favorites (id_user, img_src) VALUES ('$userid','$src')";
        $result = $mysqli->query($sql);
        echo 'True';
    }else{
        echo 'False';
    }    
}
?>