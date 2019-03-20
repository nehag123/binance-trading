<?php defined('BASEPATH') OR exit('No direct script access allowed');
 //print_r($user);
 $name=$user->username;
 ?>
<div class="container">
	<div class="row">
		
		<div class="col-md-12">
			<div class="page-header">
				<h1>Edit User</h1>
			</div>
			
			<form action="" id="edituser" method="POST">
				<input type="hidden" class="form-control" id="userid" value="<?=isset($user->id)?$user->id:'' ?>" name="userid"/>
				<div id="uname-error" style="display:none" class="alert alert-warning">
                    <strong>Warning!</strong> Username is already exists.
                 </div>
                 <div id="success-msg" style="display:none;" class="alert alert-success">
               <strong>Success!</strong> User updated succesfully.
               </div>
				<div class="form-group">
					<label for="username">Username</label>
					<input type="text" onfocusout="return checkUser('<?php echo $name ?>')" class="form-control" id="uname" value="<?=isset($user->username)?$user->username:'' ?>" name="username" placeholder="Enter a username">
				</div>
				<div class="form-group">
					<label for="email">Email</label>
					<input type="email" class="form-control" id="uemail" value="<?=isset($user->email)?$user->email:'' ?>" name="email" placeholder="Enter your email">
					<span class="error" style="display:none;color:red"></span>
				</div>
				<div class="form-group">
					<label for="email">Role</label>
					<select class="form-control" id="roles" onload="return checkUserAccount();" onchange="return changeRoles();" name="user_role">
						<?php $role= $user->user_role;
	                         				
  						?>
						<option <?php if($role==1){ echo "selected";} ?> value="1">Developer</option>
						<option <?php if($role==2){ echo "selected";} ?> value="2">Trader</option>
						<option <?php if($role==3){ echo "selected";} ?> value="3">User</option>
					</select>
				</div>
				
				<div class="form-group" id="binance-section" style="display:none">
					<label for="email">Binance Trading Account Name</label>
					<select class="form-control" name="trading_account" id="trading_account" >
						<?php foreach($accounts as $account){
							if($account['id']==$user->trading_account)
							{  
								$selected='selected';
								}else{
									$selected=' ';
									}
							?>
						<option <?php if($selected){echo $selected; }?> value="<?= $account['id'];?>"><?= $account['account_name'];?></option>
					    <?php } ?>
					</select>
					<span class='trading-error' style="display:none;color:red">Please select one trading account</span>
				</div>
				
				<div class="form-group">
					<input id="btn-update" onclick="return updatedata();" type="button" class="btn btn-default" value="Update">
				</div>
				
				<div id="form-error" class="alert alert-danger" style="display:none" >
                  Please fill all the fields.
             </div>
				
			</form>
		</div>
	</div><!-- .row -->
</div><!-- .container -->

<script>
	
	// Check Is Trader on Load
	
	function checkUserAccount(){
		var role= $('#roles').val();
			if(role ==2){
				$('#binance-section').show();
			}else{
				 $('#binance-section').hide();
			}
		
		}
	
	// show binance section
	
	function changeRoles(){
	var selectedRole = $('#roles').children("option:selected"). val();
	if(selectedRole == 2)
	{  
		 $('#binance-section').show();
		}else{
		     
			$('#binance-section').hide();
			}
	}
	
	// Validate Email
	
	function ValidateEmail(email) {
        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return expr.test(email);
    };
    
    // Check user exists or not
    
    function checkUser(name){
		 var name= $('#uname').val();
		 
		    $.ajax({
                    type : "POST",
                    url : "<?php echo base_url(); ?>/user/checkUserExists",
                    data : {username:name},
                    success : function(response) {
                        if(response ==1)
                        {
							$('#uname-error').show();
							$('#form-error').hide();
							return false;
							
							}else{
								$('#uname-error').hide();
								return true;
								}
                    }
                });
		
		}
	// Update user
	
	function updatedata(){
		
		var uname= $('#uname').val();
	    var email= $('#uemail').val();
		var checkemail= ValidateEmail(email);
		if(checkemail==false)
		{
			$('.error').html('Please enter valid email');
			$('.error').show();
			$('#form-error').hide();
			 return false;
			}else{
				$('.error').hide();
				}
		if(!uname  || !email || checkemail == false)
		{
			$('#form-error').show();
			$('#success-msg').hide();
			return false;
			}else{
				$('#form-error').hide();
				$('#uname-error').hide();
				$.ajax({
                    type : "POST",
                    url : "<?php echo base_url(); ?>user/update",
                    data : $("#edituser").serialize(),
                    success : function(response) {
						$('#uname-error').hide();
                        $('#success-msg').show();
                        var url= "<?php echo base_url();?>users";
                        setInterval(function(){window.location.replace(url);},3000);
                    }
                });
				
				}
		
		
		}
</script>
