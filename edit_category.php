<?php
include "header.html";
include "config.php";
if(isset($_GET['id'])){												//get the id of logged in user
	$id = intval($_GET['id']);										
	$dn1 = mysql_fetch_array(mysql_query('select count(id) as nb1, name, description from categories where id = "'.$id.'" group by id'));
	if($dn1['nb1']>0){
		if(isset($_SESSION['username']) and $_SESSION['username']==$admin){			//check if logged in user is admin or not
			if (isset($_POST['name'], $_POST['description']) and $_POST['name']!='') {
				$name = $_POST['name'];
				$description = $_POST['description'];
				$name = mysql_real_escape_string($name);
				$description = mysql_real_escape_string($description);
				if(mysql_query('update categories set name="'.$name.'", description="'.$description.'" where id="'.$id.'"'))
				{
					header('Location: category_edit_success.php');
				}
				else{
					header('Location: error_category.php');
				}
			} else {										//form to edit the category
			?>
			<div class="container">
			<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<form action="edit_category.php?id=<?php echo $id; ?>" method="post"><br />
			<input class="form-control" type="text" name="name" id="name" value="<?php echo htmlentities($dn1['name'], ENT_QUOTES, 'UTF-8'); ?>" />
    		<textarea class="form-control" name="description" id="description" cols="70" rows="6" value="<?php echo htmlentities($dn1['description'], ENT_QUOTES, 'UTF-8');?>"></textarea>
    		<input class="btn-sm btn-primary post" type="submit" value="Post" />
 			</form>
  		 	</div>
			</div>
			</div>
			<?php	
			}			
		}
		else{
			header('Location: no_auth.php');
		}
	}
	else{
		header('Location: no_category.php');
	}
}
else
{
	header('no_id.php');	
}
?>
<?php
include "footer.html";
?>