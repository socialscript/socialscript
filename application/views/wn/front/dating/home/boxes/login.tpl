<div id="my_account">
			<h3>
				<a href="#">{$languages->menu_login}</a>
			</h3>
			
			<div style="min-height:150px;">		
				<div id="login_response"></div>
<br />
					<form id="login_form" method="post"
				action="index.php?route=users&action=login">
				<label for="username_login">{$languages->login_username}</label> <input
					type="text" name="username_login" class='ui-widget-header input new-in'
					id="username_login"> 
				<br />
				<label for="password_login">{$languages->login_password}</label>
				<input type="password" name="password_login"
					class='ui-widget-header input new-in' id="password_login"> 
				<br /><label><input
					type="submit" name="login" id="login" value=""
					class="new-login-button"></label>
			</form>
		</div>

	</div>
	
	{literal}
	<script type="text/javascript">
	$("#my_account").accordion({
							header : "h3",
							fillSpace : true
						});
						</script>
						{/literal}