<!-- Main component for a primary marketing message or call to action -->
<style type="text/css">
#table_id thead tr {
    color: #FFFFFF;
    text-shadow: 1px 1px 0 #227DBC;
	background-color:#227DBC;
}
</style>
<div class="jumbotron">
  <div class="operations-tab">
  	<table width="100%" border="0" cellspacing="3" cellpadding="1">
  <tr valign="baseline">
    <td width="9%"><h2>Users</h2>&nbsp;</td>
    <td width="34%"><div class="pagination"><?php echo $pagination_links;?></div>&nbsp;</td>
    <td width="23%"><div class="div-search"><form action="<?php echo base_url('members/dashboards/search/');?>" method="post" class="navbar-form navbar-right">
   <div class="input-group">
       <input type="Search" placeholder="Search by last name" class="form-control" name="txtSearch" id="txtSearch" />
       <div class="input-group-btn">
           <button class="btn btn-info">
           <span class="glyphicon glyphicon-search"></span>
           </button>
       </div>
   </div>
</form></div>&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="24%"><div class="add-user"><input type="button" value="ADD USER" class="btn btn-large btn-primary" id="addNewUser" name="addNewUser"/></div>&nbsp;</td>
  </tr>
</table> 	
  </div>  
  <div class="users-list">  
      <table id="table_id" class="table table-striped table-bordered">
        <thead>
              <tr>
                  <th width="193">First Name</th>
                  <th width="191">Last Name</th>
                  <th width="134">Birthdate</th>
                  <th width="593">phone number</th>
                  <th width="72">&nbsp;</th>
                  <th width="72">&nbsp;</th>
                  <th width="125">&nbsp;</th>
              </tr>
        </thead>
        <tbody> 
        	  <?php if(count($userDetailsArr)>0){ 
			  			foreach($userDetailsArr as $key =>$user){
							$birth_date	=	$user['birth_date'];
							$birth_date	=	date('m/d/Y',strtotime($birth_date));
			  ?>
              <tr>
                  <td><?php echo $user['first_name'];?></td>
                  <td><?php echo $user['last_name'];?></td>
                  <td><?php echo $birth_date;?></td>
                  <td><?php echo $user['phone'];?></td>
                  <td>&nbsp;<a href="<?php echo base_url('members/view-user').'/'.$user['user_id'];?>"><i class="glyphicon glyphicon-search"></i></a></td>
                  <td>&nbsp;<a href="javascript:editUser(<?php echo $user['user_id'];?>);"><i class="glyphicon glyphicon-pencil"></i></a></td>
                  <td>&nbsp;<a href="javascript:deleteUser(<?php echo $user['user_id'];?>);"><i class="glyphicon glyphicon-remove-sign"></i></a></td>
              </tr>
              <?php 	}
			  	}?>
        </tbody>
      </table>
  </div>
</div>
<script type="text/javascript">
	function editUser(id){		
		 $.ajax({
				type: "POST",
				dataType: "json",
				url: "<?php echo site_url('members/check-permission/edit/1')?>",
				data: {
					user_id:id
				},
				success: function (data) {
					if(data.status){
						window.location="<?php echo base_url('members/edit-user');?>/"+id;
					}else{
						//alert("You do not have enough permission to edit records.");	
						 bootbox.alert("You do not have enough permission to edit records.");
					}
				}
		});	
	}
	
	function deleteUser(id){	
		bootbox.confirm("Are you sure?", function(result) {
		  if(result){
			  window.location="<?php echo base_url('members/view-user-delete');?>/"+id;
		  }
		}); 
	
		/*if(confirm('Do you want to delete this record?')){
			window.location="<?php echo base_url('members/view-user-delete');?>/"+id;
		}*/
		
		
		 /* $.ajax({
				type: "POST",
				dataType: "json",
				url: "</?php echo site_url('members/delete-user')?>",
				data: {
					user_id:id
				},
				success: function (data) {
					if(data.status){
						alert(data.error_message);		
					}
				}
		});	*/
	}
</script>