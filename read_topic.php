<?php
    include "header.html";
	include "config.php";
	if(isset($_GET['id'])){
		$id=intval($_GET['id']);
		$dn1=mysql_fetch_array(mysql_query('select count(t.id) as nb1, t.title, t.parent, count(t2.id) as nb2, c.name from topics as t, topics as t2, categories as c where t.id="'.$id.'" and t.id2 = 1 and t2.id = "'.$id.'" and c.id=t.parent group by t.id'));
		if($dn1['nb1']>0)
		{
			
?>
<div class="container">
	<div class="row">
		<!-- This is the heading of the question -->
		<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 topic">
			<h3><?php echo $dn1['title']; ?></h3>
		</div>
		<!-- if user is logged in condition -->
		<?php
		$dn2 = mysql_query('select t.id2, t.authorid, t.message, t.timestamp, u.username as author, u.avatar from topics as t, users as u where t.id="'.$id.'" and u.id=t.authorid order by t.timestamp asc');
		?>
		<?php 
		if(isset($_SESSION['username']))
		{
			$nb_new_pm = mysql_fetch_array(mysql_query('select count(*) as nb_new_pm from pm where ((user1="'.$_SESSION['userid'].'" and user1read="no") or (user2="'.$_SESSION['userid'].'" and user2read="no")) and id2="1"'));
			$nb_new_pm = $nb_new_pm['nb_new_pm'];
		?>
		<div class="col-lg-1 col-md-1"></div>
		<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
		<a href="messages.php" class="btn-sm btn-primary">Message&nbsp;<span class="badge"><?php echo $nb_new_pm; ?></span></a>  
		<a href="login.php" class="btn-sm btn-primary">Log Out</a>
		</div>
		<?php
				} else {
		?>
		<!-- This section is displayed if the user is not logged in -->
		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
 		</div>
		<?php
		}
		?>
	</div>
	<div class="row">
		<!-- This is the detailed explanation of the problem -->
		<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
			 <span class="dropcap">
                Q
              </span>
		</div>
		<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
          <div class="row quest">
			<div class="bs-example">
            <table class="table table-hover">
              <tbody class="related">
              	<?php
				while($dnn2 = mysql_fetch_array($dn2))
				{
				?>
                <tr>
                  <td>
       					<?php echo $dnn2['message']; ?><br /><br />
         	          	<a href="profile.php?id=<?php echo $dnn2['authorid']; ?>">Author: <?php echo $dnn2['author']; ?></a><br />
       	          </td>
       	          <td>
                  </td>
                </tr>
                <?php
					}
				?>
              </tbody>
            </table>
            <table class="table table-hover">
              <tbody class="related">
                <tr>
      	          <td>
       	          	<?php
					if(isset($_GET['id'])) {
					$id = intval($_GET['id']);
					if(isset($_SESSION['username']))
					{
						$dn1 = mysql_fetch_array(mysql_query('select count(t.id) as nb1, t.title, t.parent, c.name from topics as t, categories as c where t.id="'.$id.'" and t.id2=1 and c.id=t.parent group by t.id'));
						if($dn1['nb1']>0)
						{
					?>
					<?php
					if(isset($_POST['message']) and $_POST['message']!='') {
					$message = $_POST['message'];
					if(get_magic_quotes_gpc())
					{
						$message = stripslashes($message);
					}
					$message = mysql_real_escape_string(bbcode_to_html($message));
					if(mysql_query('insert into topics (parent, id, id2, title, message, authorid, timestamp, timestamp2) select "'.$dn1['parent'].'", "'.$id.'", max(id2)+1, "", "'.$message.'", "'.$_SESSION['userid'].'", "'.time().'", "'.time().'" from topics where id="'.$id.'"') and mysql_query('update topics set timestamp2="'.time().'" where id="'.$id.'" and id2=1'))
					{
						header("location: read_topic.php");
						die();
					?>
					<?php
					}
					else
					{
						echo 'An error occurred while sending the message.';
					}}
					else
					{
					?>
					<form action="reply.php?id=<?php echo $id; ?>" method="post">
						<h3>Your answer</h3>
   						<textarea name="message" class="form-control" id="message" cols="70" rows="6"></textarea><br />
    					<button type="submit" class="btn btn-primary btn-sm post">Post</button>
					</form>
					<?php
					}
					?>
					</div>
					<?php
					}
					else
					{
						header('Location: no_topic.php');
					}}
					else
					{
					?>
					<?php
					}}
					else
					{
						echo '<h2>The ID of the topic you want to reply is not defined.</h2>';
					}
					?>
       	          </td>
                </tr>
              </tbody>
            </table>
          </div>
			</div>
			</div>
		<!-- This gives the details of the question -->
	
	    <?php if(!isset($_SESSION['username']))  {?>
  		 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 login-bg">
        <div class="form-wrapper">
            <form  action="login.php" class="form-signin wow fadeInUp" method="post">
            <h2 class="form-signin-heading">sign in to comment</h2>
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
    	<?php } else { ?>
    		<div class="col-lg-3 col-md-3 col-xs-12">
			<div class="row quest">
			<div class="bs-example">
            <table class="table table-hover">
              <tbody class="related">
                <tr>
                  <td>
                    Author: 
                  </td>
                  <td>
                  	Himanshu
                  	</td>
                </tr>
                <tr>
                  <td>
					Asked: 
                  </td>
                  <td>
                  	2014/05/04
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
			</div>
		<h3>Related Questions</h3>
		<div class="row quest">
		  <div class="bs-example">
            <table class="table table-hover">
              <tbody class="related">
                <tr>
                  <td>
                    <a href="#">ipsum dolor sit amet amet, consectetur adipiscing ?</a> 
                  </td>
                </tr>
                <tr>
                  <td>
                   <a href="#">Lorem ipsum dolor sit amet amet, consectetur adipiscing ?</a> 
                  </td>
                </tr>
                <tr>
                  <td>
                  	<a href="#">Lorem ipsum dolor sit amet amet, consectetur adipiscing ?</a>
                  </td>
                </tr>
                <tr>
                  <td>
                  	<a href="#">Lorem ipsum dolor sit amet amet, consectetur adipiscing ?</a>
                  </td>
                </tr>
                <tr>
                  <td>
                  	<a href="#">Lorem ipsum dolor sit amet amet, consectetur adipiscing ?</a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
			</div>
		</div>
    	<?php }?>
	</div>
</div>
<?php			
		}else{
			echo "This topic does not exist";
		}
	}else{
		echo "The id of the topic is not defined";
	}
?>
<?php
	include "footer.html";
?>