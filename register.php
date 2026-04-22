<?php include 'db.php';

$msg="";

if(isset($_POST['register'])){

$username=$_POST['username'];
$email=$_POST['email'];
$password=password_hash($_POST['password'],PASSWORD_DEFAULT);

$stmt=$conn->prepare("
INSERT INTO users(username,email,password)
VALUES(?,?,?)
");

$stmt->bind_param("sss",$username,$email,$password);

$stmt->execute();

$msg="Registration successful! Login now.";
}
?>

<!DOCTYPE html>
<html>

<head>

<title>User Registration</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="assets/css/style.css">

<style>
.register-card{
max-width:450px;
margin:auto;
margin-top:90px;
padding:35px;
border-radius:18px;
background:rgba(255,255,255,0.95);
box-shadow:0 15px 40px rgba(0,0,0,.25);
}
</style>

</head>

<body>

<?php include 'navbar.php'; ?>

<div class="register-card">

<h3 class="text-center mb-4">Create Account</h3>

<?php if($msg!=""){ ?>

<div class="alert alert-success">
<?php echo $msg; ?>
</div>

<?php } ?>

<form method="POST">

<input
name="username"
class="form-control mb-3"
placeholder="Username"
required>

<input
name="email"
type="email"
class="form-control mb-3"
placeholder="Email"
required>

<input
name="password"
type="password"
class="form-control mb-3"
placeholder="Password"
required>

<button
name="register"
class="btn btn-success w-100">

Register

</button>

</form>

<p class="text-center mt-3">

Already have an account?

<a href="login.php">Login here</a>

</p>

</div>

</body>
</html>