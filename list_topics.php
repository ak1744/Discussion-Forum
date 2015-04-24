<!-- Author: Himanshu Kandpal -->
<?php
    include "header.html";
	include "config.php";
	if(isset($_GET['parent']))										//get the id of the category to which the topic belongs to 
	{
	$id = intval($_GET['parent']);
	$dn1 = mysql_fetch_array(mysql_query('select count(c.id) as nb1, c.name,count(t.id) as topics from categories as c left join topics as t on t.parent="'.$id.'" where c.id="'.$id.'" group by c.id'));
	if($dn1['nb1']>0)
	{
?>
<div class="container">
	<!-- Menu Section begins -->
	<div class="row">
		<?php 
		$dn2 = mysql_query('select t.id, t.title, t.authorid, u.username as author, count(r.id) as replies from topics as t left join topics as r on r.parent="'.$id.'" and r.id=t.id and r.id2!=1  left join users as u on u.id=t.authorid where t.parent="'.$id.'" and t.id2=1 group by t.id order by t.timestamp2 desc');
		if(mysql_num_rows($dn2)>0) {						//section to show if there is some data in the category
		?>
		<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
			<h2>Pick A Question</h2>
		</div>
		<?php } else { ?>									<!-- section to show if there is no data in the category -->
		<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
			<h2>There are no topics in this category</h2>
		</div>
		<?php
		}
		if(isset($_SESSION['username']))
		{
		$nb_new_pm = mysql_fetch_array(mysql_query('select count(*) as nb_new_pm from pm where ((user1="'.$_SESSION['userid'].'" and user1read="no") or (user2="'.$_SESSION['userid'].'" and user2read="no")) and id2="1"'));
		$nb_new_pm = $nb_new_pm['nb_new_pm'];
		?>
		<?php include "headbar.html"; ?>
		<?php
		} 
		?>
	</div>
	<!-- If user is logged in begins -->

	<div class="row">
			<?php
			if(mysql_num_rows($dn2)>0){
			if(isset($_SESSION['username'])){
			?>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<?php } else { ?>
			<div class="col-lg-8 col-md-8 col-sm-;12 col-xs-12">
			<?php } ?>
			<div class="table-responsive">
            <table class="table table-bordered table-striped">
              <colgroup>
				<?php
               	 	if(isset($_SESSION['username']) and $_SESSION['username']==$admin){
               	?>
                <col class="col-xs-9">
                	 <?php
					 	} else {
              		 ?>
                <col class="col-xs-10">
              		 <?php
                	 	 } 
                	 ?>
                <col class="col-xs-1">
                <col class="col-xs-1">
                	 <?php
                		if(isset($_SESSION['username']) and $_SESSION['username']==$admin) {
                	 ?>
                <col class="col-xs-1"/>
                	 <?php 
						 }
                	 ?>               
                </colgroup>
              <thead>

                <tr>
                  <th>
                    Question
                  </th>
                  <th>
                  	Replies
                  </th>
                  <th>
                  	Author
                  </th>
                  <!-- if user is admin or not -->
                  	<?php
                  		if(isset($_SESSION['username']) and $_SESSION['username']==$admin){
                  	?>
                  <th>
                  	Action
                  </th>
                  	<?php
				  		}
                  	?>
                  <!-- if user is admin or not condition ends -->
                </tr>
              </thead>
              <tbody>
             	<?php
					while($dnn2 = mysql_fetch_array($dn2)){
              	?>
                <tr>
                  <td>
					<a href="read_topic.php?id=<?php echo $dnn2['id']; ?>"><?php echo htmlentities($dnn2['title'], ENT_QUOTES, 'UTF-8'); ?></a>
                  </td>
                  <td>
                  	<?php echo $dnn2['replies']; ?>
                  </td>
                  <td>
                  	<a href="profile.php?id=<?php echo $dnn2['authorid']; ?>"><?php echo htmlentities($dnn2['author'], ENT_QUOTES, 'UTF-8') ?></a>
                  </td>
                  <!-- if user is admin or not bedign -->
                  <!-- if user is admin or not begin -->
                  	<?php
                  		if(isset($_SESSION['username']) and $_SESSION['username']==$admin){
                  	?>
                  <td>
                  	<a href="delete_topic.php?id=<?php echo $dnn2['id']; ?>"><img src="images/delete.png" alt="Delete"/></a>
				  </td>     			
                 	 <?php
				 		 }
                	 ?>
                  <!-- if user is admin or not condition ends -->
                </tr>
                <?php
                	}
				?>
              </tbody>
            </table>
          </div>	
		</div>
		<?php if(!isset($_SESSION['username'])) { ?>
		 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 login-bg">
		 <div class="form-wrapper">
            <form  action="login.php" class="form-signin wow fadeInUp" method="post">
            <h2 class="form-signin-heading">sign in now</h2>
            <div class="login-wrap">
                <input type="text" name="username" id="username" class="form-control" placeholder="User ID" autofocus>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                <label class="checkbox">
                    <input type="checkbox" name="memorize" id="memorize" value="remember-me"> Remember me
                    <span class="pull-right">
                        <a data-toggle="modal" href="#myModal"> Forgot Password?</a>
                    </span>
                </label>
                <button class="btn btn-lg btn-login btn-block" type="submit" value="Login">Sign in</button>
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
		</div>
	</div>
	<!-- If user is logged in ends -->
	<?php } ?>
	<?php
	} // second level if ends
	else{
	?>
			<div class="row">
			<div class="col-lg-3 col-md-3"></div>
			<div class=" wow flipInX col-lg-6 col-md-6">
				<img  src="images/empty.jpg" width="auto" height="400px"/>
			</div>
			<div class="col-lg-3 col-md-3"></div>
			<div class="col-sm-12 col-xs-12"></div>
			</div>
	<?php
	}
	} // Top level if ends
	else{
		header('Location: error.php');
	}}
?>
<?php
	include "footer.html";
?>