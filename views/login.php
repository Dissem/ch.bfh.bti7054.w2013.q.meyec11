<?php
require_once 'renderable.php';
require_once __DIR__.'/../lib/data.php';

class Login implements Renderable {
  var $signedIn;
  var $user;

  public function __construct(){
    $user = User::getLoggedIn();
    $this->signedIn = isset($user);
    $this->user = $user;
  }

  public function render() {
    ?>
  <script type="text/javascript">
    //<![CDATA[
    function login(){
        $.ajax({
            type: "POST",
            url: "ajax.php?site=signin",
            data: $("#loginForm").serialize(),
            dataType: "html",
            success: function(data){
                if (data != "") {
                    $("#loginBlock").css("display", "none");
                    $("#login_error").css("display", "none");
                    $("#logoutBlock").css("display", "");
                    $("#username").text(data);
                    $(".loginRequired").css("display", "");
                }
                else {
                    $("#login_error").css("display", "");
                    $("#logoutBlock").css("display", "none");
                }
            }
        });
        return false;
    }
    
    function logout(){
        $.ajax({
            type: "POST",
            url: "ajax.php?site=signout",
            data: $("#loginForm").serialize(),
            dataType: "html",
            success: function(data){
                $("#loginBlock").css("display", "");
                $("#login_error").css("display", "none");
                $("#logoutBlock").css("display", "none");
                $(".loginRequired").css("display", "none");
                go("overview");
            }
        });
        return false;
    }
    
    //]]>
  </script>
  <ul id="loginBlock" class="nav navbar-nav navbar-right"<?php $this->display(true)?>>
    <li>
      <a href="#" onclick="return go('signup');">
        <?php echo _("Sign Up")?>
      </a>
    </li>
    <li class="dropdown">
      <a class="dropdown-toggle" href="#" data-toggle="dropdown">
        <?php echo _("Sign In")?>
        <strong class="caret"></strong></a>
      <div class="dropdown-menu" style="padding: 15px;">
        <!-- Login form here -->
        <form id="loginForm" action="ajax.php" method="post" accept-charset="UTF-8">
          <input id="user_username" name="username" type="text" class="form-control" placeholder="<?php echo _("e-mail")?>" /><input id="user_password" name="password" type="password" class="form-control" placeholder="<?php echo _("password")?>" />
          <div id="login_error" style="display: none" class="alert alert-danger">
            <?php echo _("Well, that didn't work.")?>
          </div>
          <input id="user_remember_me" name="remember" type="checkbox" value="1" />
          <label for="user_remember_me">
            <?php echo _("Remember me")?>
          </label>
          <input class="btn btn-primary" type="submit" value="<?php echo _("Sign In")?>" onclick="return login();" style="width: 100%" />
        </form>
      </div>
    </li>
  </ul>
  <ul id="logoutBlock" class="nav navbar-nav navbar-right"<?php $this->display(false)?>>
    <li>
      <a href="#" onclick="return logout();">
        <?php echo _("Sign Out")?>
      </a>
    </li>
  </ul>
    <?php
  }

  private function display($b) {
    if ($b == $this->signedIn)
      echo ' style="display: none"';
    else
      echo '';
  }

  function login() {
    $user = User::find($_POST["username"]);
    if ($user->check($_POST["password"])) {
      $this->signedIn = true;
      $this->user = $user->name;
      $userstring = serialize($user);
      $_SESSION['user'] = $userstring;
      if (isset($_POST["remember"]) && $_POST["remember"] == "1") {
        // Store cookie for 30 days
        setcookie("user", $user->name, strtotime( '+30 days' ));
        setcookie("usersecret", $user->getSecret(), strtotime( '+30 days' ));
      }
      echo $user->name;
    } else {
      echo "";
    }
  }

  function logout() {
    $_SESSION['user'] = FALSE;
    setcookie("user", FALSE, strtotime( '-1 days' ));
  }
}