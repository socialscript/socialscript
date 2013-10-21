<div id="content" class="hidden"></div>
<div id="login">

	<div style="text-align: left; padding-left: 30px;">

		<div id='form-column'>

			<div id='login-title'>LOGIN</div>
			<div id="status"></div>
			<div class="area">

				<div id='user-container'>
					Username: <br /> <input class="username" type="text" id="username"
						value="admin" />
				</div>

				<div id='password-container'>
					Password: <br /> <input class="password" type="password"
						id="password" value="admin" />
				</div>

			</div>


		</div>

		<div id='submit-column'>

			<input type="button" class="login-submit" id="submit" />

		</div>

		<div class="clear"></div>

	</div>
</div>
{literal}
<script type="text/javascript">
var r_h = '{/literal}{$r_h}{literal}';

$('#submit').bind('click', function() {

	$('#submit').attr('disabled', 'disabled');

	 $.ajax({
         type: "POST",
         url: "index_admin.php?route=index&action=login",
         dataType:"html",
         data:
         {
             'username':$("#username").val(),
             'password':$("#password").val(),
             'r_h':r_h
         },
         dataType:'json',
         success:function(response){
             if(response.status == true)
             {
				$("#status").html('Succesfully logged in');
				//$("#content").load("index_admin.php?route=index&action=home");
				$.ajax({
					type : "GET",
					url : "index_admin.php?route=index&action=home",
					data : {

						'rh' : r_h,

					},

					success : function(response) {
						$("#content").html(response);
						$("#login").hide();
						$("#content").fadeIn(2000);
					}
				});


             }
             else
             {
            	 $("#status").html('Invalid username or password');
            	 $('#submit').removeAttr('disabled');
             }

         },
         error:function (xhr, ajaxOptions, thrownError){
             alert(xhr.status);
             alert(thrownError);
         }
     });
});


	</script>
{/literal}

