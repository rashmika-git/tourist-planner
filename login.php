<?php
include '../db.php';

$error="";

if(isset($_POST['login'])){

$username=$_POST['username'];
$password=$_POST['password'];

$stmt=$conn->prepare("SELECT * FROM admin WHERE username=?");
$stmt->bind_param("s",$username);
$stmt->execute();

$result=$stmt->get_result();
$admin=$result->fetch_assoc();

if($admin && password_verify($password,$admin['password'])){

$_SESSION['admin']=$admin['username'];

header("Location: dashboard.php");
exit();

}else{

$error="Invalid admin credentials";

}
}
?>

<!DOCTYPE html>
<html>

<head>

<title>Admin Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="../assets/css/style.css">

<style>
.admin-card{
max-width:420px;
margin:auto;
margin-top:110px;
padding:35px;
border-radius:18px;
background:rgba(255,255,255,0.95);
box-shadow:0 15px 40px rgba(0,0,0,.25);
}
</style>

</head>

<body>

<div class="admin-card">

<h3 class="text-center mb-4">
🔐 Admin Login
</h3>

<?php if($error!=""){ ?>

<div class="alert alert-danger">
<?php echo $error; ?>
</div>

<?php } ?>

<form method="POST">

<input
name="username"
class="form-control mb-3"
placeholder="Admin Username"
required>

<input
type="password"
name="password"
class="form-control mb-3"
placeholder="Password"
required>

<button
name="login"
class="btn btn-success w-100">

Login as Admin

</button>

</form>

<p class="text-center mt-3">

Return to

<a href="../index.php">Home</a>

</p>

</div>

</body>
</html>