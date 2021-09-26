<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "registration";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $db);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
else{

 $uname = $_POST["username"];
 $password = $_POST["password"];
 $confirm_password = $_POST["confirm_password"];
 $first_name = $_POST["first_name"];
 $email = $_POST["email"];
 $errorMessage = array();
 $successMessage = "";

 if(empty($uname) || empty($password) || empty($confirm_password) || empty($first_name) || empty($email)){
     array_push($errorMessage, "empty values not allowed");
 }

 if(strcmp($password, $confirm_password) !=  0){
     array_push($errorMessage, "password doesnot match");
 }

 if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    array_push($errorMessage, "Invalid email format");
  }

  $sql = "select uname from user";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
    if(strcmp($row['uname'], $uname) == 0){
        array_push($errorMessage, "username already in use");
    break;
    }
  }
} 

  if(count($errorMessage) == 0){
    $sql = "insert into user (first_name, uname, password, email) values ('$first_name', '$uname', '$password', '$email')";
    
    if (mysqli_query($conn, $sql)) {
      $successMessage = "New record created successfully";
      header("Location: thankyou.php"); 
      exit();
    } else {
        array_push($errorMessage, mysqli_error($conn));
    }
  }
}

?>
<html>
<head>
<title>PHP User Registration Form</title>
<link href="./css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <form name="frmRegistration" method="post" action="">
        <div class="demo-table">
        <div class="form-head">Sign Up</div>
            
<?php
if (empty($errorMessage) && !empty($successMessage)) {
    ?>	
            <div class="success-message">
            <?php 
                echo $successMessage . "<br/>";
            ?>
            </div>
<?php
}
?>

<?php
if (! empty($errorMessage) && is_array($errorMessage)) {
    ?>	
            <div class="error-message">
            <?php 
            foreach($errorMessage as $message) {
                echo $message . "<br/>";
            }
            ?>
            </div>
<?php
}
?>
            <div class="field-column">
                <label>Username</label>
                <div>
                    <input type="text" class="demo-input-box"
                        name="username"
                        value="">
                </div>
            </div>
            
            <div class="field-column">
                <label>Password</label>
                <div><input type="password" class="demo-input-box"
                    name="password" value=""></div>
            </div>
            <div class="field-column">
                <label>Confirm Password</label>
                <div>
                    <input type="password" class="demo-input-box"
                        name="confirm_password" value="">
                </div>
            </div>
            <div class="field-column">
                <label>Display Name</label>
                <div>
                    <input type="text" class="demo-input-box"
                        name="first_name"
                        value="">
                </div>

            </div>
            <div class="field-column">
                <label>Email</label>
                <div>
                    <input type="text" class="demo-input-box"
                        name="email"
                        value="">
                </div>
            </div>
            <div class="field-column">
                <div class="terms">
                    <input type="checkbox" name="terms"> I accept terms
                    and conditions
                </div>
                <div>
                    <input type="submit"
                        name="register-user" value="Register"
                        class="btnRegister">
                </div>
            </div>
        </div>
    </form>
</body>
</html>