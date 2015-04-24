<?php
include "header.html";
include "config.php";
if(isset($_GET['id'])){								//get the idea of logged in user 
	$id = intval($_GET['id']);
	$dn1 = mysql_fetch_array(mysql_query('select count(id) as nb1, name, position from categories where id="'.$id.'" group by id'));
	if($dn1['nb1']>0){								//proceed only if there is some data
			if(isset($_SESSION['username']) and $_SESSION['username']==$admin){
			?>
			<?php
			if(isset($_POST['confirm'])){			//proceed when deletion of data is confirmed
			if(mysql_query('delete from categories where id = "'.$id.'"') and mysql_query('delete from topics where parent = "'.$id.'"') and mysql_query('update categories set position = position - 1 where position > "'.$dn1['position'].'"')) 
			{
			?>
			<div class="container">
 				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 gray-bg">
    			<div class="fof">
        		<div class="container  error-inner wow flipInX">
            	<h1>The topic have successfully been deleted.</h1>
            	<p class="text-center">Go to questions</p>
            	<a class="btn btn-info" href="index.php">YES</a>
        		</div>
        		</div>
    			</div>
			</div>	<?php
			}
			else
			{
				header('Location: error.php');
			}
			}
			else {										//deletion of category confirmation
			?>
			<form action="delete_category.php?id=<?php echo $id; ?>" method="post">
			<div class="container">
 			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 gray-bg">
    		<div class="fof">
     	   	<div class="container  error-inner wow flipInX">
			<h1>Are you sure you want to delete this category and all its topics ?</h1>
            <input type="hidden" name="confirm" value="true" />
    		<input class="btn btn-info" type="submit" value="Yes" /> <input class="btn btn-info" type="button" value="No" onclick="javascript:history.go(-1);" />
   			</div>
        	</div>
    		</div>
			</div>
   			</form>
			<?php
			}}
			else{
				header('Location: no_auth.php');
			}
		}
	else{
		header('Location: no_category.php');
	}
}
else{
	header('Location: no_id.php');
}
?>
<?php
include "footer.html";
?>