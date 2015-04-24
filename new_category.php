<?php
    include "header.html";
	include "config.php";
	if(isset($_SESSION['username']) and $_SESSION['username']==$admin){
?>
<div class="container">
<?php
$nb_new_pm = mysql_fetch_array(mysql_query('select count(*) as nb_new_pm from pm where ((user1="'.$_SESSION['userid'].'" and user1read="no") or (user2="'.$_SESSION['userid'].'" and user2read="no")) and id2="1"'));
$nb_new_pm = $nb_new_pm['nb_new_pm'];
?>
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
		<h2>Name the category</h2> 
	</div>
	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
		<a href="index.php" class="btn-sm btn-primary">List of Category</a>
		<a href="messages.php" class="btn-sm btn-primary">Message&nbsp;<span class="badge"><?php echo $nb_new_pm; ?></span></a>  
		<a href="login.php" class="btn-sm btn-primary">Log Out</a>
	</div>
</div>
<?php
	if(isset($_POST['name'], $_POST['description']) and $_POST['name']!=''){
		$name = $_POST['name'];
		$description = $_POST['description'];
		$name = mysql_real_escape_string($name);
		$description = mysql_real_escape_string($description);
		if(mysql_query('insert into categories (id, name, description, position) select ifnull(max(id), 0)+1, "'.$name.'", "'.$description.'", count(id)+1 from categories '))	
		{
			header('Location: category_success.php');
		}
		else{
			header('Location: category_failure.php');
		}
	}
	else{
?>
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<form action="new_category.php" method="post"><br />
		<input class="form-control" type="text" name="name" id="name"  />
    	<textarea class="form-control" name="description" id="description" cols="70" rows="6"></textarea>
    	<input class="btn-sm btn-primary post" type="submit" value="Create" / >
		</form>
   </div>
</div>
<?php
	}
?>
</div>
<?php
	}else{
		header('Location: no_auth.php');
	}
?>
<?php
	include "footer.html";
?>