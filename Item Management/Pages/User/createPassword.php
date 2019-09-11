<?php
$email = '';
$operation = 0;
//0=new password
//1=update password
//2=forgot password
if (isset($_GET['id'])) {
    $email = $_GET['id'];
}
if (isset($_GET['operation'])) {
    $operation = $_GET['operation'];
}
include_once '../../Actions/UserAction.php';
if ($operation == 1) {
    if(isset($_SESSION['email']))
    include_once '../../header.php';
    else   header("location:logout.php");
} else {
    session_destroy();
}

$funObj = new UserAction();

if (isset($_POST["createPassword"])) {
    $email = $funObj->escape_string($_POST['email']);
    $password = $funObj->escape_string($_POST['password']);
    $con_password = $funObj->escape_string($_POST['con_password']);

    $field = array(
        'Email' => $email,
        'Password' => $password,
    );
    if ($funObj->required_validation($field)) {
        if ($funObj->checkEqual($password, $con_password)) {

            $user = $funObj->CreatePassword($email, $password);
            if ($user) {
                // Registration Success
                header("location:logout.php");
            } else {
                $message = $funObj->error;
            }
        } else {
            $message = $funObj->error;
        }

    } else {
        $message = $funObj->error;
    }
}

?>
<?php if (!isset($_SESSION['email'])) {?>
<!DOCTYPE html>
<html>

<head>
    <title>Item Management</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="shortcut icon" href="logo.gif">
</head>

<body>
    <br />
    <div class="container w-25" style="width:500px">
        <h3>Create Password</h3><br />
        <?php } else {?>
        <div class="container float-left w-50">
            <?php }?>
            <?php
if (!(($email != '' && $funObj->isNewUserExist($email) && $operation == 0) || ($operation == 1 && isset($_SESSION['email'])) || ($operation == 2 && $funObj->isLinkExpired($email)))) {
    echo '<label class="text-danger"> Invalid Link!</label>';
} else {

    if (isset($message)) {
        echo '<label class="text-danger">' . $message . '</label>';
    }
    ?>
            <form method="post" autocomplete="off">
                <label>Email</label>
                <input type="text" name="email" value="<?php echo $email ? $email : $_SESSION['email']; ?>"
                    class="form-control" placeholder="Enter Email" readonly />
                <br />
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter Password"
                    autocomplete="new-password" />
                <br />
                <label>Confirm Password</label>
                <input type="password" name="con_password" class="form-control" placeholder="Re-enter Confirm Password"
                    autocomplete="new-password" />
                <br />
                <input type="submit" name="createPassword" class="btn btn-info"
                    value="<?php if ($operation != 0) {
        echo "Update Password";
    } else {
        echo "Create Password";
    }
    ?>" />
            </form>
            <?php }?>
        </div>
        <br />
</body>

</html>