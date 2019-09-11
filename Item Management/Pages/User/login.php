<?php

include_once '../../Actions/UserAction.php';

$funObj = new UserAction();
if (isset($_POST["login"])) {
    $email = $funObj->escape_string($_POST['email']);
    $password = $funObj->escape_string($_POST['password']);

    $field = array(
        'Email' => $email,
        'Password' => $password,
    );
    if ($funObj->required_validation($field)) {
        $user = $funObj->Login($email, $password);
        if ($user) {
            // Registration Success
            header("location:../../Pages/item/itemlisting.php");
        } else {
            $message = $funObj->error;
        }
    } else {
        $message = $funObj->error;
    }
}

else if (isset($_POST["forgot"])) {
    $email = $funObj->escape_string($_POST['email']);
  //  $password = $funObj->escape_string($_POST['password']);

    $field = array(
        'Email' => $email,
       // 'Password' => $password,
    );
    if ($funObj->required_validation($field)) {
        $user = $funObj->ForgotPassword($email);
        if ($user) {
            // Forgot password link Success
            $message = $funObj->error;
        } else {
            $message = $funObj->error;
        }
    } else {
        $message = $funObj->error;
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Item Management</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="shortcut icon" href="../../logo.gif">
</head>

<body>

    <div class="container" style="width:500px; height:100vh;">

        <form method="post" autocomplete="off">

            <div class="modal-content  align-items-center" style="margin-top: 150px!important;">

                <div class="modal-body">

                    <div class="modal-header">
                        <h3 class="modal-title align-middle text-center text-uppercase"><strong>User Login</strong></h3>

                        <label>Email</label>
                        <input type="text" name="email" class="form-control" placeholder="Enter Email" />
                        <br />
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter Password"
                            autocomplete="new-password" />
                        <br />

                        <input type="submit" name="login" class="btn btn-secondary btn-block text-uppercase"
                            value="Login" />
                           

                    </div>
               
                    <?php
if (isset($message)) {
    echo '<div class="modal-header"><label class="text-danger font-weight-normal">' . $message . '</label></div>';
}?>
                </div>     <input type="submit" name="forgot" class="btn btn-link text-uppercase"
                            value="Forgot Password" />
            </div>
    </div>

    </form>
    <br />
</body>

</html>