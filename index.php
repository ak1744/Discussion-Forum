<!-- Author: Himanshu Kandpal -->
<?php
    include "header.html";
	include "config.php";
?>
<!-- Body content goes here -->
<div class="container">
	<div class="row">
		<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
			<?php
			if(!isset($_SESSION['username'])){	//check if the user is logged in or not
			?>
			<h2>Welcome</h2>
			<?php
			} else {
			?>
			<h2>Welcome <?php $username = $_SESSION['username']; echo $username; ?></h2>	 <!-- echo the name of the users -->
			<?php
			}
			?>	
		</div>
		<?php 
		// check if the user is logged in
		if(isset($_SESSION['username']))
		{
			// import the messages from the database
			$nb_new_pm = mysql_fetch_array(mysql_query('select count(*) as nb_new_pm from pm where ((user1="'.$_SESSION['userid'].'" and user1read="no") or (user2="'.$_SESSION['userid'].'" and user2read="no")) and id2="1"'));
			$nb_new_pm = $nb_new_pm['nb_new_pm'];
		?>
		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
		<!-- Display the no of received messages from the database -->
		<a href="new_category.php" class="btn-sm btn-primary">New Category</a>  
		<a href="messages.php" class="btn-sm btn-primary">Message&nbsp;<span class="badge"><?php echo $nb_new_pm; ?></span></a>  
		<a href="login.php" class="btn-sm btn-primary">Log Out</a>
		</div>
		<?php
        }
        ?>
        <!-- if the user is not logged in it will display blank space  -->
        <?php if(!isset($_SESSION['username'])) { ?>
		<div class="col-xs-12 xslog">
    	</div>
    	<?php } ?>
	</div>
	<!-- php condition to check login -->
	<?php
	if (isset($_SESSION['username'])) {
	?>
	<!--after condition if user is logged in begins -->
	<div class="row">
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			<div class="full-width-media-text">
		 		<blockquote>
		 		Here, anyone can ask a question and anyone can answer it if you know it. It's 100% free and no fee is required.
				</blockquote>
			</div>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"></div>
    </div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12">
			<div class="table-responsive">
            <table class="table table-bordered table-striped">
              <colgroup>
              	<!-- Will display this column if the user is logged in and the user is administrator -->
                <col class="col-xs-1">
                     <?php
               		 	if(isset($_SESSION['username']) and $_SESSION['username']==$admin){
               		 ?>
                <col class="col-xs-8">
                	 <?php
					 	} else {
              		 ?>
                <col class="col-xs-9">
              		 <?php
                	 	 } 
                	 ?>
                <col class="col-xs-1">
                
                <col class="col-xs-1">
                	 <?php
                		if(isset($_SESSION['username']) and $_SESSION['username']==$admin)
					 {
                	 ?>
                <col class="col-xs-1"/>
                	 <?php 
						 }
                	 ?>         
                </colgroup>
              <thead>
                <tr>
                  <th>
                    Category
                  </th>
                  <th>
                    Description
                  </th>
                  <th>
                  	Replies
                  </th>
                  <th>
                  	Author
                  </th>
                  <!-- Display the column if the user is logged in as admin -->
                  <?php
                  	if(isset($_SESSION['username']) and $_SESSION['username']==$admin){
                  ?>
                  <th>
                  	Action
                  </th>
                  	<?php
				  		}
                  	?>
                </tr>
              </thead>
              <tbody>
               <?php
               		// importing the topic, description and couting the no of replies from teh topics table
              		$query1 = 'select c.id, c.name, c.description, c.position, (select count(t.id) from topics as t where t.parent=c.id and t.id2 = 1) as topics, (select count(t2.id) from topics as t2 where t2.parent=c.id and t2.id2!=1) as replies from categories as c group by c.id order by c.position asc';
              		$dn1 = mysql_query($query1);
              		$nb_cats = mysql_num_rows($dn1);

					while($dnn1 = mysql_fetch_array($dn1)){
              	?>
                <tr>
                  <!-- Display the topics in the table -->
                  <td>
					<a href="list_topics.php?parent=<?php echo $dnn1['id']; ?>" ><?php echo htmlentities($dnn1['name'], ENT_QUOTES, 'UTF-8'); ?></a>
                  </td>
                  <!-- Display the description of the topics -->
                  <td>
                      <?php echo $dnn1['description']; ?>
                  </td>
                  <!-- Count the no of replies using $dnn1 and display it here -->
                  <td>
                  	<?php echo $dnn1['replies']; ?>
                  </td>
                  <!-- Since each topic can be created by the admin only  -->
                  <td>
                  	<?php echo "Admin"; ?>
                  </td>
                  <!-- Deleting and editing the category option will display if the user is logged in as the admin-->
                  	<?php
                  		if(isset($_SESSION['username']) and $_SESSION['username']==$admin){
                  	?>
                  <td>
                  	<!-- Will display delete and edit option if thw user is logged in as admin -->
					<a href="delete_category.php?id=<?php echo $dnn1['id'];?>"><img src="<?php echo $design; ?>/delete.png" alt="Delete" title="Delete"/></a>
					<a href="edit_category.php?id=<?php echo $dnn1['id']; ?>"><img src="<?php echo $design; ?>/more.png" alt="Edit" title="Edit"/></a>
 				  </td>     			
                 	 <?php
				 		 }
                	 ?>
                </tr>
                <?php
                	}
				?>
              </tbody>
            </table>
          </div>
		</div>
	</div>
		<?php
			} else {
		?>
	<!-- condition if user is not logged in begins -->
	<div class="row">
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			<div class="full-width-media-text">
		 	<blockquote>
		 	Here, anyone can ask a question and anyone can answer it if you know it. It's 100% free and no fee is required. Create your account or login now. 
			</blockquote>
			</div>
			<div class="table-responsive">
            <table class="table table-bordered table-striped">
             <colgroup>
             	<!-- column for category -->
                <col class="col-xs-1">
                <!-- column for description -->
                <col class="col-xs-9">
                <!-- column for replies -->
                <col class="col-xs-1">
                <!-- column to display the name of the author -->
                <col class="col-xs-1">
                </colgroup>
              <thead>
                <tr>
                  <th>
                    Category
                  </th>
                  <th>
                    Description
                  </th>
                  <th>
                  	Replies
                  </th>
                  <th>
                  	Author
                  </th>
                </tr>
              </thead>
              <tbody>
              	<?php
              		// Fetch the information about the topics, description, count of the no of replies and the author name from the topics table
              		$query1 = 'select c.id, c.name, c.description, c.position, (select count(t.id) from topics as t where t.parent=c.id and t.id2 = 1) as topics, (select count(t2.id) from topics as t2 where t2.parent=c.id and t2.id2!=1) as replies from categories as c group by c.id order by c.position asc';
              		// sends the query to the active database that is topics and store the values in the $dn1
              		$dn1 = mysql_query($query1);
              		// retrieves the no of rows from the result set that is $dn1
              		$nb_cats = mysql_num_rows($dn1);
					// will continues to fetch the result and till there are no data left 
					while($dnn1 = mysql_fetch_array($dn1)){
              	?>
                <tr>
                  <td>
					<a href="list_topics.php?parent=<?php echo $dnn1['id']; ?>" ><?php echo htmlentities($dnn1['name'], ENT_QUOTES, 'UTF-8'); ?></a>
                  </td>
                  <td>
                      <?php echo $dnn1['description']; ?>
                  </td>
                  <td>
                  	<?php echo $dnn1['replies']; ?>
                  </td>
                  <td>
                  	<?php echo "Admin"; ?>
                  </td>
                 </tr>
                <?php
                	}
				?>
              </tbody>
            </table>
          </div>
		</div>
		<?php if(!isset($_SESSION['username'])) { ?>
		 <!--Sign in if not logged in-->
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
    <?php } ?>
    <!--/ Sign in if not logged in-->
	</div>
		<?php	
			}
		?>
</div>
<?php
	include "footer.html";
?>