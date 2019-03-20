<?php  defined('BASEPATH') OR exit('No direct script access allowed'); 
//print_r($accounts);
?>
<div class="right-menus" style="float:right;padding-bottom:8px;padding-right:5px">
	<?php if (isset($_SESSION['username']) && $_SESSION['logged_in'] === true && $_SESSION['is_admin'] == 1) : ?>
						<a href="<?= base_url();?>trading_account/add"><button type="button" class="btn btn-primary">Add Trading Account</button></a>
					<?php endif; ?>
</div>
<?php if($accounts){ ?>
<table id="accounts" class="display">
        <thead>
            <tr>
                <th style="text-align:center">Account Name</th>
                <th style="text-align:center">Status</th>
                <th style="text-align:center">Action</th>
                
            </tr>
        </thead>
        <tbody>
			<?php foreach($accounts as $account){?>
            <tr>
                <td style='background:#234620;color:#fff;text-align:center'><?php echo $account['account_name'];?></td>
                <td style='background:#234620;color:#fff;text-align:center'><?php if($account['active']==1){ echo 'Active';} else{ echo 'Inactive'; }?></td>
                <td style='background:#234620;color:#fff;text-align:center'><a style='color:#fff' href="<?= base_url();?>trading_account/edit/<?php echo $account['id'];?>">Edit</a><!--<a style='color:#fff;padding-left:30px;' onclick="return showmodel(<?php echo $account['id']?>)" href="javascript:void(0)">Delete</a>--></td>
            </tr>
            <?php }?>
        </tbody>
        <tfoot>
            <tr>
                <th style="text-align:center">Account Name</th>
                <th style="text-align:center">Status</th>
                <th style="text-align:center">Action</th>
            </tr>
        </tfoot>
    </table>
<?php }else{
	          
	        echo "<h3>No trading account available!</h3>"; 
     }
	
?>

<div class="modal fade" style="margin-top:10%;" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mit-modal">
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
	
	 $("#mit-modal").modal('hide');
}

function showmodel(accountid){
	   id =accountid;
	 $("#mit-modal").modal('show');
}
	
	
	// Delete a trading account
	
	function deleteUser(){
		console.log(id)
     $.ajax({
		type : "POST",
		url : "<?php echo base_url(); ?>dashboard/delete",
		data : {id:id},
		success : function(response) {
		  $("#mit-modal").modal('hide');
			location.reload();
		}
	});
          
          
	}
	</script>
