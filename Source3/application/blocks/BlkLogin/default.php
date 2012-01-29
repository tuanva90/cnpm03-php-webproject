<script type="text/javascript">
$(function(){
	//Get the values from database
	var use_forgot_password_link = <?php echo $use_forgot_password_link==1?1:0;?>;
	var use_keep_signed_in = <?php echo $use_keep_signed_in==1?1:0;?>;

	//Refresh module after changes
	function refresh() {
		if(use_forgot_password_link==1) {
			$("input[name=chkShowForgetPass]").prop('checked',true);
			$("#forget-pass").show();
		} else {
			$("input[name=chkShowForgetPass]").prop('checked',false);
			$("#forget-pass").hide();
		}
		
		if(use_keep_signed_in==1) {
			$("input[name=chkShowKeepSignIn]").prop('checked',true);
			$("#keep-signed-in").show();
		} else {
			$("input[name=chkShowKeepSignIn]").prop('checked',false);
			$("#keep-signed-in").hide();
		}
	}

	//Update values
	function updateLogin() {
		var option_str = "";
		if($("input[name=chkShowForgetPass]").is(":checked")) {
			use_forgot_password_link = 1;
			option_str += "$use_forgot_password_link=1;";
		} else {
			use_forgot_password_link = 0;
			option_str += "$use_forgot_password_link=0;";
		}
		if($("input[name=chkShowKeepSignIn]").is(":checked")) {
			use_keep_signed_in = 1;
			option_str += "$use_keep_signed_in=1;";
		} else {
			use_keep_signed_in = 0;
			option_str += "$use_keep_signed_in=0;";
		}

		$.ajax({
			
			type: 'POST',
			url: '<?php echo HTTP_SERVER."front/index/saveblock"?>',
			dataType: 'json',
			data: {
				module_id: <?php echo $info['module_id'];?>,
				name: "<?php echo $info['name'];?>",
				file_name: "<?php echo $info['file_name'];?>",
				is_showed: $("input[name=chkIsShowed]").is("checked")?1:0,
				position: <?php echo $info['position'];?>,
				sort_order: <?php echo $info['sort_order'];?>,
				option: option_str
			},
			success: function(data) {
				closeMessage();	
			},
			error: function(request, error) {
				showMessage("Error! <br> Detail: <br>" + request.responseText);
			}	
		});
		refresh();
	}
	
	refresh();

	//Init #edit-login button
	$("#edit-login").button().click(function(){
		refresh();
		$("#edit-login-form").dialog("open");
	});

	//Make the #login-button look like button.
	$("#login-button").button();

	//Init #edit-login-form dialog
	$("#edit-login-form").dialog({
		autoOpen: false,
		height: 300,
		width: 350,
		modal: true,
		buttons: {
			"Save": function() {
				showMessage("Saving...");
				updateLogin();
				$(this).dialog("close");
			},
			Cancel: function() {
				$(this).dialog("close");
			}
		}
	});
});
</script>

<div class="ui-widget-content ui-conner-all module" id="login">
	<div class="ui-widget-header ui-corner-all module-title">
		<h3>Login</h3>
		<div class="edit-button">
			<button id='edit-login' class="state-changable-button">...</button>
		</div>
	</div>
	Username:<br> 
	<input type="text" name="txtUserName" id="txtUserName" maxlength="50" size="25"/><br>
	Password:<br>
	<input type="password"" name="txtPassword" id="txtPassword" maxlength="50" size="25"/><br>
	
	<div id="keep-signed-in">
		<input type="checkbox" name="chkSaveMe" id="chkSaveMe">Keep me signed in.<br>
	</div>
	
	<div id="forget-pass">
		<a href="#">Forgot your password?</a><br>
	</div>
	
	<div id="login-button">Login</div>
</div>

<div id="edit-login-form" title="Edit Login Module">
	<form>
		<input type="checkbox" name="chkIsShowed" id="chkIsShowed" checked="checked"/>Use this module.<br>
		<input type="checkbox" name="chkShowForgetPass" id="chkShowForgetPass" checked="checked"/>Show 'Forgort password' link.<br>
		<input type="checkbox" name="chkShowKeepSignIn" id="chkShowKeepSignIn" checked="checked"/>Show 'Keep me signed in' checkbox.<br>
	</form>
</div>