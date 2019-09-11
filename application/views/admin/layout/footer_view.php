<div class="modal fade" id='myModal' role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Sing in</h4>
			</div>
			<div class="modal-body" id="data-frm">
				<p>One fine body&hellip;</p>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	window.setTimeout(function() {
		$(".alert").fadeTo(500, 0).slideUp(500, function(){
			$(this).remove(); 
		});
	}, 2500);
</script>
</body>
</html>