<?php
include_once '../../configurations/dbConnect.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class UserAction extends dbConnect
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

    public function Login($username, $password)
    {
        $sql = "SELECT * FROM users WHERE username = '" . $username . "' AND password = '" . $password . "'";
        // $user_data = mysqli_fetch_array($res);
        //print_r($user_data);
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_array();
            $_SESSION['login'] = true;
            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];
            // $_SESSION['email'] = $row['username'];
            return true;
        } else {
            $this->error = "Wrong Username or Password!";
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
            $sql = "SELECT * FROM users WHERE username = '" . $username . "' AND id!='" . $userId . "'";
            // $user_data = mysqli_fetch_array($res);
            //print_r($user_data);
            $result = $this->conn->query($sql);

            if ($result->num_rows > 0) {
                $this->error = "Username exists. Please try next username!";
                return false;
            }

            $sql = "UPDATE `users` SET `username`='" . $username . "',`role`='" . $role . "',`name`='" . $name . "',`address`='" . $address . "',`phone`='" . $phone . "',`email`='" . $email . "' WHERE id='" . $userId . "'";
        } else {
            $sql = "SELECT * FROM users WHERE username = '" . $username . "'";
            // $user_data = mysqli_fetch_array($res);
            //print_r($user_data);
            $result = $this->conn->query($sql);

            if ($result->num_rows > 0) {
                $this->error = "Username exists. Please try next username!";
                return false;
            }

            $sql = "INSERT INTO users(`username`, `role`,`name`,`address`,`email`,`phone`) values ('" . $username . "','" . $role . "','" . $name . "','" . $address . "','" . $email . "','" . $phone . "')";
        }

        // $user_data = mysqli_fetch_array($res);
        //print_r($user_data);
        $result = $this->conn->query($sql);

        if ($result) {
            //TODO: Email user with user for new password.
            if ($userId == "")
            $this->sendEmail($username,$email);
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
    public function CreatePassword($username, $password)
    {
        if (!$this->isUserExist($username)) {
            $this->error = "Error: Username does not exists!";
            return false;
        }
        if (isset($_SESSION['username']) && $_SESSION['username'] != $username) {
            $this->error = "Invalid Operation!";
            return false;
        }
      //  $password = md5($password); //if you need more security remove comment 
        $sql = "UPDATE  users SET `password`='" . $password . "' WHERE `username`= '" . $username . "'";
        // $user_data = mysqli_fetch_array($res);
        //print_r($user_data);
        $result = $this->conn->query($sql);

        if ($result) {
            if (isset($_SESSION['username'])) {
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

    public function isUserExist($username)
    {
        $sql = "SELECT * FROM users WHERE username = '" . $username . "'";
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

    public function isNewUserExist($username)
    {
        $sql = "SELECT * FROM users WHERE username = '" . $username . "' AND password IS NULL";
        // $user_data = mysqli_fetch_array($res);
        //print_r($user_data);
        $result = $this->conn->query($sql);

        if ($result->num_rows == 0) {
            return false;
        }

        return true;
    }

    function sendEmail($userId,$toEmail)
{

    $subject = "Account created! Please create Password.";

    $message = "
    <html>
    <head>
    <title>Create Password</title>
    </head>
    <body>
    <p>Hello " . $userId . ":</p>
    <p>
    <br/>
    Your account has been created. Please follow following link to create password. :<br/>
    <a href=\"http://localhost/Item%20Management/Pages/User/createpassword.php?id=".$userId."\">Click to here Create Password</a><br/>
    Or<br/>
    <a href=\"http://localhost/Item%20Management/Pages/User/createpassword.php?id=".$userId."\"> </a><br/>
    
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

    mail($toEmail, $subject, $message, $headers);

}

    public function escape_string($value)
    {

        return $this->conn->real_escape_string($value);
    }
}
