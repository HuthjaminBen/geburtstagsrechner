<?php

if(isset($_POST['login-submit'])){

    require 'database.intern.php';
    $username = $_POST['name_user'];
    $password = $_POST['password_user'];

    if (empty($username) || empty($password)){
        header("location: ../index.php?error=emptyfield");
        exit();
    }
    else{
        $sql_select = "SELECT * FROM tb_users WHERE users_name=? OR users_email=?;";
        $statement = mysqli_stmt_init($db_connection);
        if (!mysqli_stmt_prepare($statement, $sql_select)){
            header("location: ../index.php?error=sql-error");
            exit();   
        }
        else {
           mysqli_stmt_bind_param($statement, "ss", $username, $username); 
           mysqli_stmt_execute($statement);
           $result = mysqli_stmt_get_result($statement);
           if ($data_set = mysqli_fetch_assoc($result)){
               // $password_check = password_verify($password, $row['users_password']);
                if ($data_set['users_password'] !== $password){
                    header("location: ../index.php?error=wrongpassword");
                    exit();  
                }
                else {
                    session_start();
                    $_SESSION['session_userid'] = $data_set['pk_users_id'];
                    $_SESSION['session_username'] = $data_set['users_name'];
                    $_SESSION['session_useremail'] = $data_set['users_email'];
                    header("location: ../index.php?loginsucessfully");
                    exit();  
                }
           }
           else{
                header("location: ../index.php?error=nosuchuser");
                exit();   
           }
        }

    }

}

else {
    header("location: ../index.php?pleaselogin");
    exit();
}