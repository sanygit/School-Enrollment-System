<?php 

include 'db_connect.php';
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM level_section where id=".$_GET['id']);
	foreach ($qry->fetch_array() as $key => $value) {
		$meta[$key] = $value;
	}
}
?>

<div class="container-fluid">
	<form action="" id="manage-level_section">
		<input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
		<div class="form-group">
			<label for="level" class="control-label">Level</label>
			<input type="text" id="level" name="level" class="form-control" value="<?php echo isset($meta['level']) ? $meta['level'] : '' ?>" required>
		</div>
		<div class="form-group">
			<label for="section" class="control-label">Section</label>
			<input type="text" id="section" name="section" class="form-control" value="<?php echo isset($meta['section']) ? $meta['section'] : '' ?>" required>
		</div>
	</form>
</div>
<script>
	$('#manage-level_section').submit(function(e){
		e.preventDefault();

		start_load()
		$.ajax({
			url:'ajax.php?action=save_level_section',
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