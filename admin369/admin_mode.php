<?php 
    session_start();
    
    if(isset($_SESSION["adm_mode"])){
        echo "ADM MODE OFF";
        unset($_SESSION["adm_mode"]);
    }else{
        echo"ADM MODE ON";
        $_SESSION["adm_mode"] = true;
    }
    
    header("Location: ./");
    exit();

?>