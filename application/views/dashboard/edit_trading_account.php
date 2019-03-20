<?php defined('BASEPATH') OR exit('No direct script access allowed');
 $id=$this->uri->segment(3);
?>
<style>
	.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: green;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
	</style>
<div class="container">
	<div class="row">
		
		<div class="col-md-12">
			<div class="page-header">
				<h1>Edit Trading Account</h1>
			</div>
			
			<form action="" id="editAccount" method="POST">
				<input type="hidden" class="form-control" id="userid" value="<?= $id?>" name="id"/>
				<div id="form-error" class="alert alert-danger" style="display:none" >
                  Please fill all the fields.
                 </div>
                 <div id="success-msg" style="display:none;" class="alert alert-success">
               <strong>Success!</strong> Trading account updated succesfully.
               </div>
				<div class="form-group">
					<label for="username">Account Name</label>
					<input type="text"  class="form-control" id="aname" value="<?= $account ?>" name="aname" placeholder="Enter a account name">
				</div>
				<div class="form-group">
					<label for="akey">Key</label>
					<input type="text" class="form-control" id="akey" value="<?= $key ?>" name="akey" placeholder="Enter account key">
					<span class="error" style="display:none;color:red"></span>
				</div>
				<div class="form-group">
					<label for="skey">Secret Key</label>
					<input type="text" class="form-control" id="skey" value="<?= $secret_key ?>" name="skey" placeholder="Enter account secret key">
					<span class="error" style="display:none;color:red"></span>
				</div>
				
				<div class="form-group">
					<p style="color:#333"><strong>Enable Account</strong></p>
				<label class="switch">
				<?php if($active){ $checked='checked'; $value=1; }else{ $checked=''; $value=0;}?>
                    <input name="account-status" type="checkbox" value="<?= $value;?>" <?=$checked ?> >
                     <span class="slider round"></span>
               </label>
				</div>
				
				<div class="form-group">
					<input id="btn-update"  onclick="return updateAccountdata();" type="button" class="btn btn-default" value="Update">
				</div>
				
			</form>
		</div>
	</div><!-- .row -->
</div><!-- .container -->
<script>
	function updateAccountdata(){
		
		var name= $('#aname').val();
	    var key=  $('#akey').val();
		var skey=  $('#skey').val();
		
		if(!name  || !key || !skey)
		{
			$('#form-error').show();
			$('#success-msg').hide();
			return false;
			}else{
				$('#form-error').hide();
				$.ajax({
                    type : "POST",
                    url : "<?php echo base_url(); ?>trading_account/update",
                    data : $("#editAccount").serialize(),
                    success : function(response) {
						$('#form-error').hide();
                        $('#success-msg').show();
                        var url= "<?php echo base_url();?>trading_accounts";
                        setInterval(function(){window.location.replace(url);},3000);
                    }
                });
				
}
		
		
		}
	</script>
