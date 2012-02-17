<div class="ui-widget-content ui-conner-all module" id="<?php echo $info['module_id'];?>">
<?php
$isLoggedIn = 0;
$username = "";

//check login status
$auth = Zend_Auth::getInstance ();
if($auth->hasIdentity ()) {
    $isLoggedIn = 1;
    $username = $username = $auth->getIdentity()->username;
}
?>
	<script type="text/javascript">
		//Get the values from database
		var use_forgot_password_link = <?php echo $use_forgot_password_link==1?1:0;?>;
		var use_keep_signed_in = <?php echo $use_keep_signed_in==1?1:0;?>;
		var isLoggedIn = <?php echo $isLoggedIn;?>;
		var username = "<?php echo $username;?>";

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
		
		function updateAfterLogIn(username) {
			$("#user-name").html(username);
			$("#login-title-default").hide();
			$("#login-title-welcome").show();
			$("#login-form").hide();
			$("#toolbar").show();
			$(".edit-button").show();
		}
	
		function updateAfterLogOut() {
			$("#login-title").html("<h3>Login</h3>");
			$("#login-title-default").show();
			$("#login-title-welcome").hide();
			$("#login-form").show();
			$("#toolbar").hide();
			$(".edit-button").hide();
		}
	
		function logOut() {
			updateAfterLogOut();
			$.ajax({
				type: 'POST',
				url: '<?php echo HTTP_SERVER."front/auth/logout"?>',
				success: function(data) {
					
				},
				error: function(request, textStatus, error) {
					showMessage("Error! <br> Detail: <br>" + request.responseText + error);
				}	
			});
		}
		
		function loginUser(username,password) {
			$.ajax({
				type: 'POST',
				url: '<?php echo HTTP_SERVER."front/auth/login"?>',
				dataType: 'json',
				data: {
					password: password,
					username: username
				},
				success: function(data) {
					if(data.status) {
						 updateAfterLogIn(data.name);
					} else {
						$("#validating-login").show();
						$("#validating-login").html("Wrong User Name or Password");
					}
				},
				error: function(request, textStatus, error) {
					showMessage("Error! <br> Detail: <br>" + request.responseText + error);
				}	
			});
		}
		
		//Update values
		function updateLogin() {
			var option_str = "";
			var isShowed = $("#edit-login-form :checkbox['chkIsShowed']").is(":checked");			
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
					is_showed: 1,
					position: <?php echo $info['position'];?>,
					sort_order: <?php echo $info['sort_order'];?>,
					option: option_str
				},
				success: function(data) {
					closeMessage();	
					if(!isShowed){	
						$("#<?php echo $info['module_id']?>").remove();
					}else{
						refresh();
					}
				},
				error: function(request, error) {
					showMessage("Error! <br> Detail: <br>" + request.responseText);
				}	
			});
			refresh();
		}
		$(function(){
			if(isLoggedIn == 1) {
				updateAfterLogIn(username);
			}
			
			refresh();
		
			//Init #edit-login button
			$("#edit-login").button().click(function(){
				refresh();
				$("#edit-login-form").dialog("open");
			});
		
			//Make the #login-button look like button.
			$("#login-button").button().click(function(){
				loginUser($('input[name=txtUserName]').val(),$('input[name=txtPassword]').val());
			});
		
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
	<div class="ui-widget-header ui-corner-all module-title">
		<div id="login-title-default"><h3>Login</h3></div>
		<div id="login-title-welcome" class="hidden">
			<h3>Hello <span id="user-name"></span> <a onclick="logOut();">Log Out</a></h3>
		</div>
		<div class="edit-button">
			<button id='edit-login' class="state-changable-button">...</button>
		</div>
	</div>
	<div id="login-form">
		<div id="validating-login" class="ui-state-error hidden"></div>
		Username:<br> 
		<input type="text" name="txtUserName" id="txtUserName" maxlength="50" size="25"/><br>
		Password:<br>
		<input type="password" name="txtPassword" id="txtPassword" maxlength="50" size="25"/><br>
		
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
		<input type="checkbox" name="chkShowForgetPass" id="chkShowForgetPass" checked="checked"/>Show 'Forgort password' link.<br>
		<input type="checkbox" name="chkShowKeepSignIn" id="chkShowKeepSignIn" checked="checked"/>Show 'Keep me signed in' checkbox.<br>
	</form>
</div>
</div>