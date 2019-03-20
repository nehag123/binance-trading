<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	</main><!-- #site-content -->

	<footer id="site-footer" role="contentinfo">
	</footer><!-- #site-footer -->

	<!-- js -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script type="text/javascript"  src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
	<script src="/assets/js/bootstrap.min.js"></script>
	<script src="/assets/js/script.js"></script>
	<script type="text/javascript">
	$(document).ready(function () {
    $('#usersData').DataTable({
		"iDisplayLength": 10
		});
	
	$('#accounts').DataTable({
		"iDisplayLength": 10
		});	
    });
</script>
	
</body>
</html>
