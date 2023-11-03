<div class="container-fluid">
	<div class="card col-md-12">
		<div class="card-body">
			<div class="col-md-12">
				<button type="button" class="btn btn-primary btn-sm btn-block col-sm-2" id="new_level_section"><i class="fa fa-plus"></i> New Level and Section</button>
			</div>
			<br>
			<div class="col-md-12">
				<table class="table table-bordered" id="level_section-tbl">
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th class="text-center">Level</th>
							<th class="text-center">Section</th>
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
		$('#new_level_section').click(function(){
			uni_modal('New Level and Section','manage_level_section.php');
		})
		window.load_tbl = function(){
			$('#level_section-tbl').dataTable().fnDestroy();
			$('#level_section-tbl tbody').html('<tr><td colspan="4" class="text-center">Please Wait...</td></tr>')
			$.ajax({
				url:'ajax.php?action=load_level_section',
				success:function(resp){
					if(typeof resp != undefined){
						resp = JSON.parse(resp)
						if(Object.keys(resp).length > 0){
							$('#level_section-tbl tbody').html('')
							var i = 1;
							Object.keys(resp).map(k=>{
								var tr = $('<tr></tr>')
								tr.append('<td>'+(i++)+'</td>')
								tr.append('<td>'+resp[k].level+'</td>')
								tr.append('<td>'+resp[k].section+'</td>')
								tr.append('<td><center><button class="btn btn-info btn-sm edit_level_section" data-id = "'+resp[k].id+'"><i class="fa fa-edit"></i> Edit</button><button class="btn btn-danger btn-sm remove_level_section" data-id = "'+resp[k].id+'"><i class="fa fa-trash"></i> Delete</button></center></td>')
								$('#level_section-tbl tbody').append(tr)
							})
						}else{
						$('#level_section-tbl tbody').html('<tr><td colspan="4" class="text-center">No Data...</td></tr>')
						}
					}
				},
				complete:function(){
					$('#level_section-tbl').dataTable()
					manage_level_section();
				}
			})
		}
		function manage_level_section(){
			$('.edit_level_section').click(function(){
				uni_modal("Edit Level and Section",'manage_level_section.php?id='+$(this).attr('data-id'))
			})
			$('.remove_level_section').click(function(){
				// console.log('REMOVE')
				_conf("Are you sure to delete this data?",'remove_level_section',[$(this).attr('data-id')])
			})
		}
		function remove_level_section($id){
			start_load()
			$.ajax({
				url:'ajax.php?action=remove_level_section',
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