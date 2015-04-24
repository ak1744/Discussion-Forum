<?php
include "header.html";
include('config.php');
if(isset($_GET['id']))									//get the id of the logged in user
{
	$id = intval($_GET['id']);
if(isset($_SESSION['username']))						//fetch the information if user is logged in or not
{
	$dn1 = mysql_fetch_array(mysql_query('select count(t.id) as nb1, t.title, t.parent, c.name from topics as t, categories as c where t.id="'.$id.'" and t.id2=1 and c.id=t.parent group by t.id'));
if($dn1['nb1']>0)										//proceed if there is some data
{
if($_SESSION['username']==$admin)
{
?>
<?php
if(isset($_POST['confirm']))							//confirming the deletion of data
{
	if(mysql_query('delete from topics where id="'.$id.'"'))
	{
	?>
	<div class="container">
 	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 gray-bg">
    <div class="fof">
        <div class="container  error-inner wow flipInX">
            <h1>The topic have successfully been deleted.</h1>
            <p class="text-center">Go to questions</p>
            <a class="btn btn-info" href="list_topics.php?parent=<?php echo $dn1['parent'];?>">YES</a>
        </div>
        </div>
    </div>
</div>	<?php
	}
	else
	{
		header('Location: error.php');						//if unsuccessfull to delete the data
	}
}
else
{
?>
<form action="delete_topic.php?id=<?php echo $id; ?>" method="post">
<div class="container">
 	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 gray-bg">
    <div class="fof">
        <div class="container  error-inner wow flipInX">
            <h1>Are you sure you want to delete this topic ?</h1>
            <input type="hidden" name="confirm" value="true" />
    		<input class="btn btn-info" type="submit" value="Yes" /> <input class="btn btn-info" type="button" value="No" onclick="javascript:history.go(-1);" />
        </div>
        </div>
    </div>
</div>

</form>
<?php
}}
else
{
	header('Location: no_auth.php');
}
}
else
{
	header('Location: error.php');
}
}
else
{
	header('Location: no_auth.php');
}
}
else
{
	header('Location: error.php');
}
?>
<?php
include "footer.html";
?>