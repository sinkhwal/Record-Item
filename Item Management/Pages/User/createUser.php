<?php
include_once '../../header.php';
include_once '../../Actions/UserAction.php';
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    die();
}
$funObj = new UserAction();
$userId = '';
if (isset($_GET['id'])) {
    $userId = $_GET['id'];
}
$user = $funObj->GetUserByID($userId);
if (!$user && isset($user)) {
    $message = $funObj->error;
    header("location:userListing.php");
}

if (isset($_POST["createUser"])) {
    $id = $funObj->escape_string($_POST['id']);
    $name = $funObj->escape_string($_POST['name']);
    $address = $funObj->escape_string($_POST['address']);
    $email = $funObj->escape_string($_POST['email']);
    $phone = $funObj->escape_string($_POST['phone']);
    $username = $funObj->escape_string($_POST['username']);
    $role = $funObj->escape_string($_POST['role']);

    $field = array(
        'Email' => $email,
        'Name' => $name,
    );
    if ($funObj->required_validation($field)) {
        $user = $funObj->CreateUser($id, $name, $address, $email, $phone, $username, $role);
        if ($user) {
            // Registration Success
            header("location:userListing.php");
        } else {
            $message = $funObj->error;
        }
    } else {
        $message = $funObj->error;
    }
}

?>
<br>
<form method="post" class="float-left w-50">
    <?php
if (isset($message)) {
    echo '<br><label class="text-danger bs-linebreak">' . $message . '</label><br>';
}
?> <input name="id" type="hidden" value="<?php echo $userId; ?>">
                  <label>Email</label>
    <input type="text" name="email" value="<?php echo isset($_POST["email"]) ? $_POST["email"] : $user["email"] ?>"
        class="form-control" placeholder="Enter Email" <?php if($userId!='') echo "readonly"; ?> />
    <br />
    <label>Name</label>
    <input type="text" name="name" value="<?php echo isset($_POST["name"]) ? $_POST["name"] : $user["name"] ?>"
        class="form-control" placeholder="Enter Name" />
    <br />
    <label>Address</label>
    <input type="text" name="address"
        value="<?php echo isset($_POST["address"]) ? $_POST["address"] : $user["address"] ?>" class="form-control"
        placeholder="Enter Address" />
    <br />

    <label>Phone</label>
    <input type="text" name="phone" value="<?php echo isset($_POST["phone"]) ? $_POST["phone"] : $user["phone"] ?>"
        class="form-control" placeholder="Enter Phone" />
    <br />
    <label class="d-none">Username</label>
    <input type="text" name="username" 
        value="<?php echo isset($_POST["username"]) ? $_POST["username"] : $user["username"] ?>" class="form-control d-none"
        placeholder="Enter Username"
       />
    <br />
    <label>Role</label>

    <?php if (strtolower($_SESSION['email']) == "super@gmail.com" && strtolower($user["email"]) == "super@gmail.com") {?>
    <select name="role" class="form-control">
        <option value="Superadmin" <?php if ($user["role"] == "superadmin") {
    echo "selected";
}
    ?>>Superadmin</option>
    </select>
    <?php } else {?>
    <select name="role" class="form-control">
        <option value="Admin" <?php if ($user["role"] == "Admin") {
    echo "selected";
}
    ?>>Admin</option>
        <option value="User" <?php if ($user["role"] == "User") {
        echo "selected";
    }
    ?>>User</option>
    </select>

    <?php }?>
    <br />

    <input type="submit" name="createUser" class="btn btn-info"
        value="<?php if ($userId == "") {
    echo "Create User";
} else {
    echo "Update User";
}
?>" />
</form>
</div>
<br />
</body>

</html>