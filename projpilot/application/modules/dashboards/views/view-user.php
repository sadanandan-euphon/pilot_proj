      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <!--<h1>Navbar example</h1>
        <p>This example is a quick exercise to illustrate how the default, static navbar and fixed to top navbar work. It includes the responsive CSS and HTML, so it also adapts to your viewport and device.</p>
        <p>
          <a class="btn btn-lg btn-primary" href="../../components/#navbar">View navbar docs &raquo;</a>
        </p>-->
        <?php
			if($error){
				echo $message;
			}else{
				
			
		
			$user_id		= 	isset($userDetailsArr[0]->user_id)?$userDetailsArr[0]->user_id:0;
			$user_name		=	isset($userDetailsArr[0]->user_name)?$userDetailsArr[0]->user_name:'';
			$first_name		=	isset($userDetailsArr[0]->first_name)?$userDetailsArr[0]->first_name:'';
			$last_name		=	isset($userDetailsArr[0]->last_name)?$userDetailsArr[0]->last_name:'';	
			$email			=	isset($userDetailsArr[0]->email)?$userDetailsArr[0]->email:'';	
			$address		=	isset($userDetailsArr[0]->address)?$userDetailsArr[0]->address:'';
			$city			=	isset($userDetailsArr[0]->city)?$userDetailsArr[0]->city:'';
			$province		=	isset($userDetailsArr[0]->province)?$userDetailsArr[0]->province:'';
			$post_code		=	isset($userDetailsArr[0]->post_code)?$userDetailsArr[0]->post_code:'';
			$phone			=	isset($userDetailsArr[0]->phone)?$userDetailsArr[0]->phone:'';
			$birth_date		=	isset($userDetailsArr[0]->birth_date)?$userDetailsArr[0]->birth_date:'';
			
			if($birth_date!='' && $birth_date!='0000-00-00'){
				$birthDateArr	=	explode('-',$birth_date);				
				$birth_date		=	$birthDateArr[1].'/'.$birthDateArr[2].'/'.$birthDateArr[0];
			}
			
			if($user_id > 0){
				
			}
			$read_only	=	'readonly="true"';
			$disabled	=	'disabled="true"';
			
		?>
        
        <form id="frmUserDetails" name="frmUserDetails" method="post" action="">
        <fieldset ><legend>User Details</legend>
        	<table width="100%" border="0" cellspacing="3" cellpadding="1">
              <tr>
                <td width="14%">First Name</td>
                <td width="28%"><input type="text" name="txtFirstName" id="txtFirstName" class="form-control" value="<?php echo $first_name;?>" <?php echo $read_only;?>></td>
                <td width="10%">&nbsp;<input name="hidOperation" id="hidOperation" type="hidden" value="<?php echo $operation;?>"><input name="hidUserId" id="hidUserId" type="hidden" value="<?php echo $user_id;?>"></td>
                <td width="19%">User Id</td>
                <td width="29%"> <input type="text" name="txtUserId" id="txtUserId" class="form-control" value="<?php echo $user_name;?>" readonly="true" ></td>
              </tr>
              <tr>
                <td>Last Name</td>
                <td> <input type="text" name="txtLastName" id="txtLastName" class="form-control" value="<?php echo $last_name;?>" <?php echo $read_only;?>></td>
                <td>&nbsp;</td>
                <td>Password</td>
                <td><input type="password" name="txtPassword" id="txtPassword" class="form-control" readonly="true"></td>
              </tr>
              <tr>
                <td>Email</td>
                <td> <input type="text" name="txtEmail" id="txtEmail" class="form-control" value="<?php echo $email;?>" <?php echo $read_only;?>></td>
                <td>&nbsp;</td>
                <td>User Role</td>
                <td><select name="sltUserRole" id="sltUserRole" class="form-control" <?php echo $disabled;?>>
                  <?php if($roleOptions){
					echo $roleOptions;
				}?>
                </select></td>
              </tr>
              <tr>
                <td>Address</td>
                <td><textarea name="txtAddress" id="txtAddress" cols="45" rows="2" class="form-control" <?php echo $read_only;?>><?php echo $address;?></textarea></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>City</td>
                <td> <input type="text" name="txtCity" id="txtCity" class="form-control" value="<?php echo $city;?>" <?php echo $read_only;?>></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>Province</td>
                <td><select name="sltProvince" id="sltProvince" class="form-control" <?php echo $disabled;?>><?php if($provinceOptions){
					echo $provinceOptions;
				}?>
                </select></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>Postal code</td>
                <td><input type="text" name="txtPostCode" id="txtPostCode" class="form-control" value="<?php echo $post_code;?>" <?php echo $read_only;?>></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>phone</td>
                <td><input type="text" name="txtPhone" id="txtPhone" class="form-control" value="<?php echo $phone;?>" <?php echo $read_only;?>></td>
                <td>&nbsp;</td>
                <td>Birth date</td>
                <td><input type="text" name="txtBirthDate" id="txtBirthDate" class="form-control" style="width:100px;" value="<?php echo $birth_date;?>" <?php echo $read_only;?>></td>
              </tr>
            </table>        
        </fieldset>     
         <input type="button" value="EDIT USER" class="btn btn-large btn-primary" id="editUser" name="editUser"/>
         <input name="btnCancel" type="button" value="Cancel" class="btn btn-large btn-primary" style="margin-right:10px" onclick="history.go(-1);"/>
         </form>
         
		 
		 <?php	}
		?>
      </div>
    <script type="text/javascript">
	$(document).ready(function() {
		$('#editUser').click(function(){
			$.ajax({
				type: "POST",
				dataType: "json",
				url: "<?php echo site_url('members/check-permission/edit/1')?>",
				data: {
					
				},
				success: function (data) {
					if(data.status){
							window.location="<?php echo base_url('members/edit-user').'/'.$user_id;?>";
						}else{
							//alert("You do not have enough permission to edit records.");	
							 bootbox.alert("You do not have enough permission to edit records.");
						}
					}
			});	
			
		});
		
	});
	</script>