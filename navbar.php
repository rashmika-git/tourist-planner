<?php if(session_status() === PHP_SESSION_NONE){ session_start(); } ?>

<nav class="navbar navbar-expand-lg navbar-dark px-4 shadow-sm">

<a class="navbar-brand fw-bold text-success" href="index.php">
🌴 Tourist Planner
</a>

<button class="navbar-toggler" type="button"
data-bs-toggle="collapse"
data-bs-target="#navMenu">
<span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="navMenu">

<ul class="navbar-nav ms-auto align-items-center">

<li class="nav-item">
<a class="nav-link" href="index.php">Attractions</a>
</li>

<li class="nav-item">
<a class="nav-link" href="map.php">Map</a>
</li>

<li class="nav-item">
<a class="nav-link" href="planner.php">Planner</a>
</li>

<?php if(isset($_SESSION['user'])){ ?>

<li class="nav-item">
<span class="nav-link text-light">
Welcome <?php echo htmlspecialchars($_SESSION['user']); ?>
</span>
</li>

<li class="nav-item">
<a class="nav-link text-warning" href="logout.php">
Logout
</a>
</li>

<?php } else { ?>

<li class="nav-item">
<a class="nav-link" href="login.php">Login</a>
</li>

<li class="nav-item">
<a class="nav-link" href="register.php">Register</a>
</li>

<?php } ?>

<li class="nav-item">
<a class="nav-link text-info fw-semibold"
href="admin/login.php">
Admin
</a>
</li>

</ul>

</div>

</nav>