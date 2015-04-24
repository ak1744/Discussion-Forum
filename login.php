<!-- Author: Himanshu Kandpal -->
<?php
    // This page will help you proceed further with login
	
	include "config.php";
	include "header.html";
	if(isset($_SESSION['username'])) {
		unset($_SESSION['username'], $_SESSION['userid']);
		setcookie('username','', time()-100);
		setcookie('password','', time()-100);
		header('Location: index.php');
	} else {
		$ousername = '';
		if(isset($_POST['username'], $_POST['password'])){
			if(get_magic_quotes_gpc()){
				$ousername = stripcslashes($_POST['username']);
				$username = mysql_real_escape_string(stripcslashes($_POST['username']));
				$password = stripcslashes($_POST['password']);
			}
			else{
				$username = mysql_real_escape_string($_POST['username']);
				$password = $_POST['password'];
			}
			$req = mysql_query('select password,id from users where username="'.$username.'"');
			$dn = mysql_fetch_array($req);
			if($dn['password']==sha1($password) and mysql_num_rows($req)>0){
				$form = false;
				$_SESSION['username'] = $_POST['username'];
				$_SESSION['userid'] = $dn['id'];
				if (isset($_POST['memorize']) and $_POST['memorize']=='yes') {
					$one_month = time() + (60*60*24*30);
					setcookie('username', $_POST['username'], $one_month);
					setcookie('password', sha1($password), $one_month); 
				}
				header('Location: index.php');
		}
		else
		{
			$form = true;
			$message = 'The username or password are not good.';
		}
	}
	else
	{
		$form = true;
	}
	if($form)
	{
?>
  <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 gray-bg">
    <div class="fof">
        <div class="container  error-inner wow flipInX">
            <h1>Incorrect Login or Password.</h1>
            <p class="text-center">You need to try again or create a new account.</p>
        </div>
        </div>
  </div>
  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 wrong-lg">
    <div class="form-wrapper">
        <form  action="login.php" class="form-signin wow fadeInUp" method="post">
          <h2 class="form-signin-heading">sign in now</h2>
            <div class="login-wrap">
                <input type="text" name="username" id="username" class="form-control" placeholder="User ID" value="<?php echo htmlentities($ousername, ENT_QUOTES, 'UTF-8') ?>" autofocus>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                <label class="checkbox">
                    <input type="checkbox" name="memorize" id="memorize" value="remember-me"> Remember me
                    <span class="pull-right">
                        <a data-toggle="modal" href="#myModal"> Forgot Password?</a>
                    </span>
                </label>
                <button class="btn btn-lg btn-login btn-block" type="submit" value="Login">Sign in</button>
               	<?php
				if(isset($message))
					{
					echo '<div><code>'.$message.'</code></div>';
					}
				?>
                <div class="registration">
                    Don't have an account yet?
                    <a class="" href="registration.php">
                        Create an account
                    </a>
                </div>
            </div>
          </form>    
        </div>
    </div>
    <?php
	}
}
?>
<?php
include "footer.html";
?>
