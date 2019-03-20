<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
//print_r($users);
?>
<style>
.dataTables_empty {
    text-align: center;
    background: #234620 !important;
    color: #fff !important;
}
</style>
<div class="right-menus" style="float:right;padding-bottom:8px;padding-right:5px">
	<?php if (isset($_SESSION['username']) && $_SESSION['logged_in'] === true && $_SESSION['is_admin'] == 1) : ?>
				<a href="<?= base_url('register') ?>"><button type="button" class="btn btn-primary">Add User</button></a>
					<?php endif; ?>
	</div>
<?php if($users){ ?>
<table id="usersData" class="display">
    <thead>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Trading Account</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
		<?php foreach($users as $user){
			  $role=$user['user_role'];
			 $assigned_trade=getTradingAccount($user['trading_account']);
	
			switch ($role) {
              case 1:$role="Developer";
              break;
              case 2:$role="Trader";
              break;
              case 3:$role="User";
              break;
             default:$role="Developer";
             break;
           }
			?>
        <tr>
            <td style='background:#234620;color:#fff'><?= $user['username'] ?></td>
            <td style='background:#234620;color:#fff'><?= $user['email'] ?></td>
            <td style='background:#234620;color:#fff'><?= $role; ?></td>
            <td style='background:#234620;color:#fff'><?php if($role=='Trader'){echo $assigned_trade;} else{ echo 'Not Available'; } ?></td>
           
            <td style='background:#234620;color:#fff'><a style='color:#fff' href="<?= base_url();?>user/edit/<?php echo $user['id']?>">Edit</a><a style='color:#fff;padding-left:30px;' onclick="return showmodel(<?php echo $user['id']?>)" href="javascript:void(0)">Delete</a></td>
            
        </tr>
        <?php }?>
    </tbody>
     <tfoot>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Trading Account</th>
            <th>Action</th>
        </tr>
    </tfoot>
</table>
<?php } else{
	          
	        echo "<h3>No user found</h3>"; 
     }
	?>
<div class="modal fade" style="margin-top:10%;" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mi-modal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel" style="color:#000;">Are you sure!</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="return deleteUser()" id="modal-btn-si">Yes</button>
        <button type="button" class="btn btn-primary" onclick="return cancelmodel()" id="modal-btn-no">No</button>
      </div>
    </div>
  </div>
</div>

<script>
	 var id = "";
function cancelmodel(){
	
	 $("#mi-modal").modal('hide');
}

function showmodel(userid){
	   id =userid;
	 $("#mi-modal").modal('show');
}
	
	
	// Delete a user
	
	function deleteUser(){
		//console.log(id)
     $.ajax({
		type : "POST",
		url : "<?php echo base_url(); ?>user/delete",
		data : {id:id},
		success : function(response) {
		  $("#mi-modal").modal('hide');
			location.reload();
		}
	});
          
          
	}
	</script>
