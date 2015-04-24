<?php
//This page let users create new topics
include "header.html";
include('config.php');
if(isset($_GET['parent']))
{
	$id = intval($_GET['parent']);
if(isset($_SESSION['username']))
{
	$dn1 = mysql_fetch_array(mysql_query('select count(c.id) as nb1, c.name from categories as c where c.id="'.$id.'"'));
if($dn1['nb1']>0)
{
?>
<div class="container">
<?php
$nb_new_pm = mysql_fetch_array(mysql_query('select count(*) as nb_new_pm from pm where ((user1="'.$_SESSION['userid'].'" and user1read="no") or (user2="'.$_SESSION['userid'].'" and user2read="no")) and id2="1"'));
$nb_new_pm = $nb_new_pm['nb_new_pm'];
?>
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
		<h2>Your Question</h2> 
	</div>
	<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
		<a href="messages.php" class="btn-sm btn-primary">Message&nbsp;<span class="badge"><?php echo $nb_new_pm; ?></span></a>  
		<a href="login.php" class="btn-sm btn-primary">Log Out</a>
	</div>
</div>
<?php
if(isset($_POST['message'], $_POST['title']) and $_POST['message']!='' and $_POST['title']!='')
{
	include('bbcode_function.php');
	$title = $_POST['title'];
	$message = $_POST['message'];
	if(get_magic_quotes_gpc())
	{
		$title = stripslashes($title);
		$message = stripslashes($message);
	}
	$title = mysql_real_escape_string($title);
	$message = mysql_real_escape_string(bbcode_to_html($message));
	if(mysql_query('insert into topics (parent, id, id2, title, message, authorid, timestamp, timestamp2) select "'.$id.'", ifnull(max(id), 0)+1, "1", "'.$title.'", "'.$message.'", "'.$_SESSION['userid'].'", "'.time().'", "'.time().'" from topics'))
	{
		header("Location: topic_success.php");
	?>
	<?php
	}
	else
	{
		header("Location: topic_failure.php");
	}
}
else
{
?>
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<form action="new_topics.php?parent=<?php echo $id; ?>" method="post"><br />
		<input class="form-control" type="text" name="title" id="title"  />
    	<textarea class="form-control" name="message" id="message" cols="70" rows="6"></textarea>
    	<input class="btn-sm btn-primary post" type="submit" value="Post" />
 		</form>
   </div>
</div>
<?php
}
?>
</div>
<?php
}
else
{
	header('Location: no_category.php');
}
}
else
{
	header("Location: error_login.php");
?>
<?php
}
}
else
{
	header('Location: no_id.php');
}
?>
<?php
include "footer.html";
?>