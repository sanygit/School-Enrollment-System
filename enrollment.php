<div class="container-fluid">
	<div class="card col-md-12">
		<div class="card-body">
			<div class="col-md-12">
				<button type="button" class="btn btn-primary btn-sm btn-block col-sm-2" id="new_student"><i class="fa fa-plus"></i> Enroll New Student</button>
			</div>
			<br>
			<div class="col-md-12">
				<table class="table table-bordered" id="student-tbl">
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th class="text-center">Name</th>
							<th class="text-center">Level Section</th>
							<th class="text-center">Adviser</th>
							<th class="text-center">Student Type</th>
							<th class="text-center">Action</th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table>
			</div>
			
		</div>
	</div>
	<style>
		.modal-dialog.large{
			width: 80%;
    		max-width: inherit;
		}
	</style>
	<script>
		$('#new_student').click(function(){
			uni_modal('Enroll','manage_enrollment.php','large');
		})
		window.load_tbl = function(){
			$('#student-tbl').dataTable().fnDestroy();
			$('#student-tbl tbody').html('<tr><td colspan="6" class="text-center">Please Wait...</td></tr>')
			$.ajax({
				url:'ajax.php?action=load_student',
				success:function(resp){
					if(typeof resp != undefined){
						resp = JSON.parse(resp)
						if(Object.keys(resp).length > 0){
							$('#student-tbl tbody').html('')
							var i = 1;
							Object.keys(resp).map(k=>{
								var tr = $('<tr></tr>')
								tr.append('<td>'+(i++)+'</td>')
								tr.append('<td>'+resp[k].name+'</td>')
								tr.append('<td>'+(resp[k].ls)+'</td>')
								tr.append('<td>'+(resp[k].fname)+'</td>')
								tr.append('<td>'+(resp[k].user_type)+'</td>')
								tr.append('<td><center><button class="btn btn-info btn-sm edit_student" data-id = "'+resp[k].id+'"><i class="fa fa-edit"></i> Edit</button><button class="btn btn-danger btn-sm remove_student" data-id = "'+resp[k].id+'"><i class="fa fa-trash"></i> Delete</button></center></td>')
								$('#student-tbl tbody').append(tr)
							})
						}else{
						$('#student-tbl tbody').html('<tr><td colspan="6" class="text-center">No Data...</td></tr>')
						}
					}
				},
				complete:function(){
					$('#student-tbl').dataTable()
					manage_student();
				}
			})
		}
		function manage_student(){
			$('.edit_student').click(function(){
				uni_modal("Edit Enrollment",'manage_enrollment.php?id='+$(this).attr('data-id'),'large')
			})
			$('.remove_student').click(function(){
				// console.log('REMOVE')
				_conf("Are you sure to delete this data?",'remove_student',[$(this).attr('data-id')])
			})
		}
		function remove_student($id){
			start_load()
			$.ajax({
				url:'ajax.php?action=remove_enroll',
				method:'POST',
				data:{id:$id},
				success:function(resp){
					if(resp == 1){
						alert_toast("Data successfully deleted.",'success');
						$('.modal').modal('hide')
						load_tbl()
						end_load();
					}
				}
			})
		}
		$(document).ready(function(){
			load_tbl()
		})
	</script>
	<style>
		img.img-field {
		    max-height: 30vh;
		    max-width: 27vw;
		}
	</style>
</div>