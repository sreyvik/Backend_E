<!DOCTYPE html>

<html>

<body>


<h2>Admin Login</h2>


<form method="POST"
action="/admin/login">

@csrf


<input 
type="email"
name="email"
placeholder="Email">


<br>


<input 
type="password"
name="password"
placeholder="Password">


<br>


<button>
Login
</button>


</form>


</body>

</html>