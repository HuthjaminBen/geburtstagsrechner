<?php
if(isset($_POST['signup-submit'])) {

    require 'database.intern.php';

    $username = $_POST['name_user'];
    $email = $_POST['mail_user'];
    $password = $_POST['pwd_user'];
    $password_2 = $_POST['pwd_user_2'];

    if (empty($username) || empty($email) || empty($password) || empty($password_2)) {
        header("Location: ../signup.php?error=emptyfield&name_user=".$username."&mail_user=".$email);
        exit();
    }
    else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)&&!filter_var($email, FILTER_VALIDATE_EMAIL)){
        header("Location: ../signup.php?error=invalidusernameandpassword");
    }
    else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)){
        header("Location: ../signup.php?error=invalidusername&mail_user=".$email);
        exit();
    }
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        header("Location: ../signup.php?error=invalidmailadress&name_user=".$username);
        exit();
    }
    else if ($password_2 !== $password) {
        header("Location: ../signup.php?error=missmatchpasswords&name_user=".$username."&mail_user=".$email);
        exit();
    }
    else {
        $sql_select ="SELECT users_name FROM tb_users WHERE users_name=?";
        $prepared_statement = mysqli_stmt_init($db_connection);
        if(!mysqli_stmt_prepare($prepared_statement, $sql_select)) {
            header("Location: ../signup.php?error=sql-error");
            exit();
        }
        else{
            mysqli_stmt_bind_param($prepared_statement,"s", $username);
            mysqli_stmt_execute($prepared_statement);
            mysqli_stmt_store_result($prepared_statement);
            $check = mysqli_stmt_num_rows($prepared_statement);
            if ($check > 0) {
                header("Location: ../signup.php?error=usernametaken&mail_user=".$email);
                exit();
            }
            else {
                $sql_insert ="INSERT INTO tb_users (users_name, users_email, users_password) VALUES (?, ?, ?)"; 
                $preparedstatement = mysqli_stmt_init($db_connection);
                if(!mysqli_stmt_prepare($preparedstatement, $sql_insert)) {
                    header("Location: ../signup.php?error=sql-error");
                    exit();
                }
                else {

                    mysqli_stmt_bind_param($preparedstatement,"sss", $username, $email, $password);
                    mysqli_stmt_execute($preparedstatement);
                    header("Location: ../index.php?signup=successful");
                }
            }
        }
        mysqli_stmt_close($preparedstatement); 
        mysqli_stmt_close($prepared_statement);
        mysqli_close($db_connection);
    }

}
else {
    header("Location: ../signup.php?");
    exit();
}

