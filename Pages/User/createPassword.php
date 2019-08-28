<?php
include_once '../../Actions/UserAction.php';
if(isset($_SESSION['username']))
include_once '../../index.php';

$userId = '';
if (isset($_GET['id'])) {
    $userId = $_GET['id'];
}

$funObj = new UserAction();

if (isset($_POST["createPassword"])) {
    $username = $funObj->escape_string($_POST['username']);
    $password = $funObj->escape_string($_POST['password']);
    $con_password = $funObj->escape_string($_POST['con_password']);

    $field = array(
        'Username' => $username,
        'Password' => $password,
    );
    if ($funObj->required_validation($field)) {
        if ($funObj->checkEqual($password, $con_password)) {

            $user = $funObj->CreatePassword($username, $password);
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
<?php if(!isset($_SESSION['username'])) {?>
<!DOCTYPE html>
<html>

<head>
    <title>Item Management</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>

<body>
    <br />
    <div class="container w-25" style="width:500px">
        <h3>Create Password</h3><br />
        <?php } else {?>
        <div class="container float-left w-50">
            <?php } ?>
            <?php
if(!(($userId != '' && $funObj->isNewUserExist($userId))|| isset($_SESSION['username']))) {
    echo '<label class="text-danger"> Invalid Link!</label>';
} else {

    if (isset($message)) {
        echo '<label class="text-danger">' . $message . '</label>';
    }
    ?>
            <form method="post" autocomplete="off">
                <label>Username</label>
                <input type="text" name="username" value="<?php echo $userId?$userId:$_SESSION['username']; ?>"
                    class="form-control" placeholder="Enter Username" readonly />
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
                    value="<?php if(isset($_SESSION['username'])) echo "Update Password"; else echo "Create Password"; ?>" />
            </form>
            <?php }?>
        </div>
        <br />
</body>

</html>