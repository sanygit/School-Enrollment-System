<?php
include 'db_connect.php';
$qry = $conn->query("SELECT * from settings limit 1");
if($qry->num_rows > 0){
	foreach($qry->fetch_array() as $k => $val){
		$meta[$k] = $val;
	}
}
 ?>
<div class="container-fluid">
	
	<div class="card col-lg-12">
		<div class="card-body">
			<form action="" id="manage-settings">
				<div class="form-group">
					<label for="name" class="control-label">School Name</label>
					<input type="text" class="form-control" id="name" name="name" value="<?php echo isset($meta['name']) ? $meta['name'] : '' ?>" required>
				</div>
				<div class="form-group">
					<label for="address" class="control-label">School Address</label>
					<textarea name="address" class="form-control"><?php echo isset($meta['address']) ? $meta['address'] : '' ?></textarea>
				</div>
				<div class="form-group">
					<label for="" class="control-label">School Logo</label>
						<div>
						<img src="assets/img/<?php echo isset($meta['img_path']) ? $meta['img_path'] : '' ?>" alt="" class="img-field">

						<br>
							<div class="input-group mb-3 col-md-5">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="">Upload</span>
							  </div>
							  <div class="custom-file">
							    <input type="file" name="img" class="custom-file-input" id="img" aria-describedby="" accept="image/*" onchange="displayImg(this,$(this))">
							    <label class="custom-file-label" for="img">Choose file</label>
							  </div>
							</div>
						</div>
				</div>
				<center>
					<button class="btn btn-info btn-primary btn-block col-md-2">Save</button>
				</center>
			</form>
		</div>
	</div>

<script>

	$('#manage-settings').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_settings',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST', 
			error:err=>{
				console.log(err)
			},
			success:function(resp){
				if(resp == 1){
					alert_toast('Data successfully saved.','success')
					end_load()
				}
			}
		})

	})
	function displayImg(input,_this) {
			    if (input.files && input.files[0]) {
			        var reader = new FileReader();
			        reader.onload = function (e) {
			        	_this.parent().parent().parent().find('.img-field').attr('src', e.target.result);
            			_this.siblings('label').html(input.files[0]['name'])
            			_this.siblings('input[name="fname"]').val('<?php echo strtotime(date('y-m-d H:i:s')) ?>_'+input.files[0]['name'])
            			var p = $('<p></p>')
			            
			        }

			        reader.readAsDataURL(input.files[0]);
			    }
			}
</script>
<style>
	img.img-field {
	max-width: 20vw;
	max-height: 11vh;
	}
</style>
</div>