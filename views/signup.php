<?php
require_once 'renderable.php';
require_once __DIR__.'/../lib/data.php';

class SignUp implements Renderable {
  public function render() {
    ?>
      <script type="text/javascript">
      //<![CDATA[
      	function signup_submit() {
      		$.ajax({
          		type: "POST",
          		url: "ajax.php?site=signup-submit",
          		data: $("#signupForm").serialize(),
          		dataType: "html",
          		success: function(data)
          		{
  					$("#messages").text(data);
          		}
      	    });
  
  	        return false;
      	}
  	//]]>
      </script>
      <div id="messages"></div>
      <form id="signupForm">
        <div class="row">
          <div class="col-md-6">
            <input id="signup_name" name="name" type="text" class="form-control" placeholder="<?php echo _("full name")?>" />
            <br />
            <input id="signup_email" name="email" type="email" class="form-control" placeholder="<?php echo _("e-mail")?>" />
            <br />
            <input id="signup_password" name="password" type="password" class="form-control" placeholder="<?php echo _("password")?>" />
            <br />
            <input type="submit" class="btn btn-primary form-control" onclick="return signup_submit();" value="<?php echo _("sign up")?>" />
          </div>
        </div>
      </form>
    <?php
  }

  public function doSignup() {
    $user = new User();
    $user->name = $_POST["name"];
    $user->email = $_POST["email"];
    $user->updatePassword("", $_POST["password"]);
    $user->save();
    setcookie("user", $user);
    return "Welcome, ".$user->name;
  }
}