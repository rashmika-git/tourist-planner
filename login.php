<?php include 'db.php';

$error="";

if(isset($_POST['login'])){

$email=$_POST['email'];
$password=$_POST['password'];

$stmt=$conn->prepare("SELECT * FROM users WHERE email=?");
$stmt->bind_param("s",$email);
$stmt->execute();

$result=$stmt->get_result();
$user=$result->fetch_assoc();

if($user && password_verify($password,$user['password'])){

$_SESSION['user']=$user['username'];

header("Location: index.php");

}else{

$error="Invalid email or password";

}
}
?>

<!DOCTYPE html>
<html>

<head>

<title>User Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="assets/css/style.css">

<style>
.login-card{
max-width:420px;
margin:auto;
margin-top:100px;
padding:35px;
border-radius:18px;
background:rgba(255,255,255,0.95);
box-shadow:0 15px 40px rgba(0,0,0,.25);
}
</style>

</head>

<body>

<?php include 'navbar.php'; ?>

<div class="login-card">

<h3 class="text-center mb-4">Login to Planner</h3>

<?php if($error!=""){ ?>

<div class="alert alert-danger">
<?php echo $error; ?>
</div>

<?php } ?>

<form method="POST">

<input
name="email"
type="email"
class="form-control mb-3"
placeholder="Enter email"
required>

<input
name="password"
type="password"
class="form-control mb-3"
placeholder="Enter password"
required>

<button
name="login"
class="btn btn-success w-100">

Login

</button>

</form>

<p class="text-center mt-3">

Don't have an account?

<a href="register.php">Register here</a>

</p>

</div>

</body>
</html>