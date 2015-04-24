<?php
include "header.html";
include('config.php');
if(isset($_GET['id']))
{
	$id = intval($_GET['id']);
if(isset($_SESSION['username']))
{
	$dn1 = mysql_fetch_array(mysql_query('select count(t.id) as nb1, t.title, t.parent, c.name from topics as t, categories as c where t.id="'.$id.'" and t.id2=1 and c.id=t.parent group by t.id'));
if($dn1['nb1']>0)
{
?>
<?php
if(isset($_POST['message']) and $_POST['message']!='')
{
	include('bbcode_function.php');
	$message = $_POST['message'];
	if(get_magic_quotes_gpc())
	{
		$message = stripslashes($message);
	}
	$message = mysql_real_escape_string(bbcode_to_html($message));
	if(mysql_query('insert into topics (parent, id, id2, title, message, authorid, timestamp, timestamp2) select "'.$dn1['parent'].'", "'.$id.'", max(id2)+1, "", "'.$message.'", "'.$_SESSION['userid'].'", "'.time().'", "'.time().'" from topics where id="'.$id.'"') and mysql_query('update topics set timestamp2="'.time().'" where id="'.$id.'" and id2=1'))
	{
	?>
	<div class="container">
	<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 gray-bg">
    <div class="fof">
        <div class="container  error-inner wow flipInX">
            <h3>The Message have successfully been sent.</h3>
            <a href="read_topic.php?id=<?php echo $id; ?>" class="btn btn-info">GO BACK TO THE TOPIC</a>
        </div>
        </div>
    </div>
    </div>
    </div>
	<?php
	}
	else
	{
		echo 'An error occurred while sending the message.';
	}
}
else
{
?>

<?php
}
?>
<?php
}
else
{
	echo '<h2>The topic you want to reply doesn\'t exist.</h2>';
}
}
else
{
?>
<h2>You must be logged to access this page.</h2>
<div class="box_login">
	<form action="login.php" method="post">
		<label for="username">Username</label><input type="text" name="username" id="username" /><br />
		<label for="password">Password</label><input type="password" name="password" id="password" /><br />
        <label for="memorize">Remember</label><input type="checkbox" name="memorize" id="memorize" value="yes" />
        <div class="center">
	        <input type="submit" value="Login" /> <input type="button" onclick="javascript:document.location='signup.php';" value="Sign Up" />
        </div>
    </form>
</div>
<?php
}
}
else
{
	echo '<h2>The ID of the topic you want to reply is not defined.</h2>';
}
?>
<?php
include "footer.html";
?>