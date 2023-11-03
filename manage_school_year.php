<?php 

include 'db_connect.php';
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM school_year where id=".$_GET['id']);
	foreach ($qry->fetch_array() as $key => $value) {
		$meta[$key] = $value;
	}
}
?>

<div class="container-fluid">
	<form action="" id="manage-school_year">
		<input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
		<div class="form-group">
			<label for="school_year" class="control-label">School Year</label>
			<input type="text" id="school_year" name="school_year" class="form-control" value="<?php echo isset($meta['school_year']) ? $meta['school_year'] : '' ?>" required>
		</div>
	</form>
</div>
<script>
	$('#manage-school_year').submit(function(e){
		e.preventDefault();

		start_load()
		$.ajax({
			url:'ajax.php?action=save_school_year',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
			},
			success:function(resp){
				resp = JSON.parse(resp)
				if(resp.status == 1){
					$('.modal').modal('hide')
					end_load()
					alert_toast('Data successfully saved','success');
					load_tbl()

				}else{
					end_load()
					alert_toast(resp.msg,'danger');

				}
			}
		})

	})
</script>