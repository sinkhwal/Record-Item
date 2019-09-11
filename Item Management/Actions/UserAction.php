<?php
include_once '../../configurations/dbConnect.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class UserAction extends DbConnect
{
    public $error;
    public function __construct()
    {
        parent::__construct();
    }
    public function UserRegister($username, $password)
    {
        $password = md5($password);
        // $qr = mysqli_query($conn,"INSERT INTO users(`username`, `role`,`name`,`address`,`email`,`phone`) values ('".$username."','".$role."','".$name."','".$address."','".$email."','".$phone."')") or die(mysql_error());
        // return $qr;

    }
    public function required_validation($field)
    {
        $count = 0;
        foreach ($field as $key => $value) {
            if (empty($value)) {
                $count++;
                $this->error .= "<p>* " . $key . " is required</p>";
            }
        }

        if ($count == 0) {
            return true;
        }
    }

    public function checkEqual($password, $con_password)
    {

        if ($password !== $con_password) {
            $this->error .= "Confirm password doesn't match!";
            return false;
        }

        //  if ($count == 0) {
        return true;
        // }
    }

    public function Login($email, $password)
    {
        $sql = "SELECT * FROM users WHERE email = '" . $email . "' AND password = MD5(CONCAT('" . $password . "',id))";
        // $user_data = mysqli_fetch_array($res);
        //print_r($user_data);
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_array();
            $_SESSION['login'] = true;
            $_SESSION['id'] = $row['id'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['role'] = $row['role'];
            // $_SESSION['email'] = $row['username'];
            return true;
        } else {
            $this->error = "Wrong Username or Password!";
            return false;
        }

    }

    public function ForgotPassword($email)
    {
        $sql = "SELECT * FROM users WHERE email = '" . $email . "'";

        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_array();
            $name = $row['name'];

            $sql = "UPDATE  users SET `forgot_password_request_date`='" .date('Y-m-d H:i:s'). "' WHERE `email`= '" . $email . "'";
            // $user_data = mysqli_fetch_array($res);
            //print_r($user_data);
            $result = $this->conn->query($sql);
    
            if ($result) {
           
                    $this->error = "Forgot Password request successful. Please check email!";
    
                    $operation=2;//forgot password

                    $this->sendEmail($name, $email, $operation);
                    
                return true;
            } else {
                $this->error = "Password Create Unsuccessful!";
                return false;
            }

        } else {
            $this->error = "Email does not exist!";
            return false;
        }

    }
/**
 * Create user by super admin.
 * First check if username exists.
 */
    public function CreateUser($userId, $name, $address, $email, $phone, $username, $role)
    {
        if ($userId != "") {
            //check if username is changed and present in database for some other user.
            $sql = "SELECT * FROM users WHERE username = '" . $email . "' AND id!='" . $userId . "'";
            // $user_data = mysqli_fetch_array($res);
            //print_r($user_data);
            $result = $this->conn->query($sql);

            if ($result->num_rows > 0) {
                $this->error = "Email exists. Please try next email address!";
                return false;
            }

            $sql = "UPDATE `users` SET `username`='" . $username . "',`role`='" . $role . "',`name`='" . $name . "',`address`='" . $address . "',`phone`='" . $phone . "',`email`='" . $email . "' WHERE id='" . $userId . "'";
        } else {
            $sql = "SELECT * FROM users WHERE email = '" . $email . "'";
            // $user_data = mysqli_fetch_array($res);
            //print_r($user_data);
            $result = $this->conn->query($sql);

            if ($result->num_rows > 0) {
                $this->error = "Email exists. Please try next email!";
                return false;
            }

            $sql = "INSERT INTO users(`username`, `role`,`name`,`address`,`email`,`phone`) values ('" . $username . "','" . $role . "','" . $name . "','" . $address . "','" . $email . "','" . $phone . "')";
        }

        // $user_data = mysqli_fetch_array($res);
        //print_r($user_data);
        $result = $this->conn->query($sql);

        if ($result) {
            //TODO: Email user with user for new password.
            if ($userId == "") {
                $operation = 0; // for new user
                $this->sendEmail($name, $email, $operation);
            }

            return true;
        } else {
            $this->error = "Create Unsuccessful!";
            return false;
        }

    }

    /**
     * Create password by new user.
     * first validated if user exists or not.
     */
    public function CreatePassword($email, $password)
    {
        if (!$this->isUserExist($email)) {
            $this->error = "Error: Email does not exists!";
            return false;
        }
        if (isset($_SESSION['email']) && $_SESSION['email'] != $email) {
            $this->error = "Invalid Operation!";
            return false;
        }

        $sql = "UPDATE  users SET `password`=MD5(CONCAT('" . $password . "',id)), `forgot_password_request_date`= Null WHERE `email`= '" . $email . "'";
        // $user_data = mysqli_fetch_array($res);
        //print_r($user_data);
        $result = $this->conn->query($sql);

        if ($result) {
            if (isset($_SESSION['email'])) {
                $this->error = "Password changed successfully!";
            } else {
                $this->error = "Password created successfully. You can login now!";

            }

            return true;
        } else {
            $this->error = "Password Create Unsuccessful!";
            return false;
        }

    }

    public function isUserExist($email)
    {
        $sql = "SELECT * FROM users WHERE email = '" . $email . "'";
        // $user_data = mysqli_fetch_array($res);
        //print_r($user_data);
        $result = $this->conn->query($sql);

        if ($result->num_rows == 0) {
            return false;
        }

        return true;
    }

    public function GetUsers()
    {
        $sql = "SELECT id,username,role,name,address,phone,email FROM users";
        // $user_data = mysqli_fetch_array($res);
        //print_r($user_data);
        $result = $this->conn->query($sql);

        return $result;
    }

    public function GetUserById($id)
    {
        //if tried to accessed other user from from url
        if (strtolower($_SESSION["role"]) == "user" && $id != $_SESSION["id"]) {
            $this->error = "Unauthorized action!";
            return false;
        }
        //if tried to accessed superadmin user from from url
        if (strtolower($_SESSION["role"]) == "admin" && $id == $this->GetSuperAdminId()) {
            $this->error = "Unauthorized action!";
            return false;
        }

        $sql = "SELECT id,username,role,name,address,phone,email FROM users WHERE `id` = '" . $id . "'";
        // $user_data = mysqli_fetch_array($res);
        //print_r($user_data);
        $result = $this->conn->query($sql);

        $row = $result->fetch_array();
        return $row;
    }

    public function GetSuperAdminId()
    {
        $sql = "SELECT * FROM users WHERE role = 'Superadmin'";
        // $user_data = mysqli_fetch_array($res);
        //print_r($user_data);
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_array();
            return $row['id'];
        } else {
            return -1;
        }

    }

    public function DeleteUser($userId)
    {
        $sql = "DELETE  FROM users WHERE `id`='" . $userId . "'";
        // $user_data = mysqli_fetch_array($res);
        //print_r($user_data);
        $result = $this->conn->query($sql);

        return $result;
    }

    public function isNewUserExist($email)
    {
        $sql = "SELECT * FROM users WHERE email = '" . $email . "' AND password IS NULL";
        // $user_data = mysqli_fetch_array($res);
        //print_r($user_data);
        $result = $this->conn->query($sql);

        if ($result->num_rows == 0) {
            return false;
        }

        return true;
    }

    public function isLinkExpired($email)
    {
        //check for 3 days
        $sql = "SELECT * FROM users WHERE email = '" . $email . "' AND  (forgot_password_request_date is Null OR DATEDIFF(CURDATE(),forgot_password_request_date) > 3) ";
        // $user_data = mysqli_fetch_array($res);
        //print_r($user_data);
        $result = $this->conn->query($sql);

        if ($result->num_rows == 0) {
            //expired
            return true;
        }

        return false;
    }

    public function sendEmail($name, $email, $operation)
    {

        $subject = "Account created! Please create Password.";

        $message = "
    <html>
    <head>
    <title>Create Password</title>
    </head>
    <body>
    <p>Hello " . $name . ":</p>
    <p>
    <br/>
    Your account has been created. Please follow following link to create password. :<br/>
    <a href=\"http://localhost/Item%20Management/Pages/User/createpassword.php?id=" . $email . "&operation=" . $operation . "\">Click to here Create Password</a><br/>
    Or<br/>
    Paste following url in browser.<br/>
    http://localhost/Item%20Management/Pages/User/createpassword.php?id=" . $email . "&operation=" . $operation . "
    <br/><br/>


    Thank you,
    <br/>

    PLEASE DO NOT reply to this e-mail. The e-mails sent to this e-mail address are not monitored.

    </p>
    </body>
    </html>
    ";

        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // More headers
        $headers .= 'From: <latech@example.com>';
        //$headers .= 'Cc: myboss@example.com' . "\r\n";

        mail($email, $subject, $message, $headers);

    }

    public function escape_string($value)
    {

        return $this->conn->real_escape_string($value);
    }
}
