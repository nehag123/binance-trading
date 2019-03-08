<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
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
				<h1>Register</h1>
			</div>
			<?= form_open() ?>
				<div class="form-group">
					<label for="username">Username</label>
					<input type="text" class="form-control" id="username" name="username" placeholder="Enter a username">
					<p class="help-block">At least 4 characters, letters or numbers only</p>
				</div>
				<div class="form-group">
					<label for="email">Email</label>
					<input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
					<p class="help-block">A valid email address</p>
				</div>
				<div class="form-group">
					<label for="email">Role</label>
					<select class="form-control" id="roles" onchange="return changeRoles();" name="user_role">
						<option value="">Select Role</option>
						<option value="1">Developer</option>
						<option value="2">Trader</option>
						<option value="3">User</option>
					</select>
					<p class="help-block">Select Relavant Role</p>
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" class="form-control" id="password" name="password" placeholder="Enter a password">
					<p class="help-block">At least 6 characters</p>
				</div>
				<div class="form-group">
					<label for="password_confirm">Confirm password</label>
					<input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Confirm your password">
					<p class="help-block">Must match your password</p>
				</div>
				<div class="form-group" id="binance-section" style="display:none">
					<label for="email">Binance Trading Account Name</label>
					<select class="form-control" name="trading_account">
						<option value="">Select Binance Trading Account</option>
						<?php foreach($accounts as $account){?>
						<option value="<?= $account['id'];?>"><?= $account['account_name'];?></option>
					    <?php } ?>
					</select>
					<p class="help-block">Select One of Trading Account</p>
				</div>
				<div class="form-group">
				<?php echo $widget;?>
                <?php echo $script;?>
                </div>
				<div class="form-group">
					<input type="submit" class="btn btn-default" value="Register">
				</div>
			</form>
		</div>
	</div><!-- .row -->
</div><!-- .container -->
<script>
function changeRoles(){
	var selectedCountry = $('#roles').children("option:selected"). val();
	if(selectedCountry == 2)
	{  console.log('y');
		 $('#binance-section').show();
		}else{
		     console.log('n');	
			$('#binance-section').hide();
			}
	}
	</script>
