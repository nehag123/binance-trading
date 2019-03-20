<?php defined('BASEPATH') OR exit('No direct script access allowed');
 $id=$this->uri->segment(3);
?>
<style>
	.reg-errors p {
    color: #000;
}
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
		<?php if (validation_errors()) : ?>
			<div class="col-md-12">
				<div class="alert alert-danger reg-errors" role="alert">
					<?= validation_errors() ?>
				</div>
			</div>
		<?php endif; ?>
		<?php if (isset($error)) : ?>
			<div class="col-md-12 register-errors">
				<div class="alert alert-danger reg-errors" role="alert">
					<?= $error ?>
				</div>
			</div>
		<?php endif; ?>
		<div class="col-md-12">
			<div class="page-header">
				<h1>Add New Trading Account</h1>
			</div>
			
			<form action="" id="addAccount" method="POST">
				<div id="form-error" class="alert alert-danger" style="display:none" >
                  Please fill all the fields.
                 </div>
                 <div id="success-msg" style="display:none;" class="alert alert-success">
               <strong>Success!</strong> Trading account has been created succesfully.
               </div>
				<div class="form-group">
					<label for="account-name">Account Name</label>
					<input type="text"  class="form-control" id="account-name" value="" name="account-name" placeholder="Enter a account name">
				</div>
				<div class="form-group">
					<label for="account-key">Key</label>
					<input type="text" class="form-control" id="account-key" value="" name="account-key" placeholder="Enter account key">
					<span class="error" style="display:none;color:red"></span>
				</div>
				<div class="form-group">
					<label for="secret-key">Secret Key</label>
					<input type="text" class="form-control" id="secret-key" value="" name="secret-key" placeholder="Enter account secret key">
					
				</div>
				
				<div class="form-group">
					<p style="color:#333"><strong>Enable Account</strong></p>
				<label class="switch">
			
                    <input name="account-status" type="checkbox" value="1" >
                     <span class="slider round"></span>
               </label>
				</div>
				
				<div class="form-group">
					<input id="btn-update"  type="submit" class="btn btn-default" value="Submit">
				</div>
				
			</form>
		</div>
	</div><!-- .row -->
</div><!-- .container -->
<script>

	</script>
