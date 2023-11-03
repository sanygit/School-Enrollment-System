<?php
include 'db_connect.php';
$qry = $conn->query("SELECT * from settings limit 1");
if($qry->num_rows > 0){
	foreach($qry->fetch_array() as $k => $val){
		$meta[$k] = $val;
	}
}
 ?>
<nav class="navbar navbar-light fixed-top bg-dark" >
  <div class="container-fluid mt-2 ">
  	<div class="col-lg-12">
  			<img src="assets/img/<?php echo isset($meta['img_path']) ? $meta['img_path']:'' ?>" class="float-left" alt="" width="35" height="35">
  		<div class="col-md-4 float-left">
  			<h4 class="text-white"><?php echo isset($meta['name']) ? $meta['name']:'' ?></h4>
  		</div>
	  	<div class="col-md-2 float-right">
	  		<a href="ajax.php?action=logout" class=" text-white"><?php echo $_SESSION['login_name'] ?> <i class="fa fa-power-off"></i></a>
	    </div>
    </div>
  </div>
  
</nav>