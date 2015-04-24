<?php
    include "header.html";
	include "config.php";
	if(isset($_GET['parent']))
	{
	$id = intval($_GET['parent']);
	{
?>
    <div class="gray-bg">
    <div class="fof">  
        <div class="container  error-inner wow flipInX">
            <h1>Sorry, there are no topics in this category.</h1>
            <p class="text-center">The Page you are looking for doesn't exist.</p>
            <a class="btn btn-info" href="index.php">GO BACK</a>
            <?php if(isset($_SESSION['username']) and $_SESSION['username']==$admin) { ?>
                  <a class="btn btn-info" href="new_topics.php?parent=<?php echo $id; ?>">CREATE ONE</a>
            <?php } ?>
        </div>
        </div>
    </div>
<?php }} ?>
<?php
	include "footer.html";
?>