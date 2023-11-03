<div class="container-fluid">
	<div class="card col-md-12">
		<div class="card-body">
			<div class="col-md-12">
				<button type="button" class="btn btn-primary btn-sm btn-block col-sm-2" id="new_school_year"><i class="fa fa-plus"></i> Academic Year</button>
			</div>
			<br>
			<div class="col-md-12">
				<table class="table table-bordered" id="school_year-tbl">
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th class="text-center">Academic Year</th>
							<th class="text-center">Default</th>
							<th class="text-center">Action</th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table>
			</div>
			
		</div>
	</div>
	<script>
		$('#new_school_year').click(function(){
			uni_modal('New Academic Year','manage_school_year.php');
		})
		window.load_tbl = function(){
			$('#school_year-tbl').dataTable().fnDestroy();
			$('#school_year-tbl tbody').html('<tr><td colspan="4" class="text-center">Please Wait...</td></tr>')
			$.ajax({
				url:'ajax.php?action=load_school_year',
				success:function(resp){
					if(typeof resp != undefined){
						resp = JSON.parse(resp)
						if(Object.keys(resp).length > 0){
							$('#school_year-tbl tbody').html('')
							var i = 1;
							Object.keys(resp).map(k=>{
								var tr = $('<tr></tr>')
								tr.append('<td>'+(i++)+'</td>')
								tr.append('<td>'+resp[k].school_year+'</td>')
								if(resp[k].is_on == 1)
									tr.append('<td><center><div class="badge badge-success" data-id="'+resp[k].id+'">Yes</div></center></td>');
								else
									tr.append('<td><center><div class="badge badge-info switch" data-id="'+resp[k].id+'">No</div></center></td>');
									
								tr.append('<td><center><button class="btn btn-info btn-sm edit_school_year" data-id = "'+resp[k].id+'"><i class="fa fa-edit"></i> Edit</button><button class="btn btn-danger btn-sm remove_school_year" data-id = "'+resp[k].id+'"><i class="fa fa-trash"></i> Delete</button></center></td>')
								$('#school_year-tbl tbody').append(tr)
							})
						}else{
						$('#school_year-tbl tbody').html('<tr><td colspan="4" class="text-center">No Data...</td></tr>')
						}
					}
				},
				complete:function(){
					$('#school_year-tbl').dataTable()
					manage_school_year();
				}
			})
		}
		function manage_school_year(){
			$('.edit_school_year').click(function(){
				uni_modal("Edit Level and Section",'manage_school_year.php?id='+$(this).attr('data-id'))
			})
			$('.remove_school_year').click(function(){
				// console.log('REMOVE')
				_conf("Are you sure to delete this data?",'remove_school_year',[$(this).attr('data-id')])
			})
			$('.switch').click(function(){
				// console.log('REMOVE')
				_conf("Are you sure making this data as the default Academic Year?",'switch_year',[$(this).attr('data-id')])
			})
		}
		function remove_school_year($id){
			start_load()
			$.ajax({
				url:'ajax.php?action=remove_school_year',
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
		function switch_year($id){
			start_load()
			$.ajax({
				url:'ajax.php?action=switch_year',
				method:'POST',
				data:{id:$id},
				success:function(resp){
					if(resp == 1){
						alert_toast("Academic Year succe updated.",'success');
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
		.switch {
			cursor: pointer;
		}
	</style>
</div>