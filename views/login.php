<?php
require_once 'renderable.php';

class Login implements Renderable {
  public function render() {
    ?>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="#"><?php echo _("Sign Up")?></a></li>
      <li class="dropdown">
        <a class="dropdown-toggle" href="#" data-toggle="dropdown"><?php echo _("Sign In")?> <strong class="caret"></strong></a>
        <div class="dropdown-menu" style="padding: 15px;">
          <!-- Login form here -->
          <form action="login" method="post" accept-charset="UTF-8">
            <input id="user_username" type="text" class="form-control" placeholder="<?php echo _("e-mail")?>" />
            <input id="user_password" type="password" class="form-control" placeholder="<?php echo _("password")?>" />
            <input id="user_remember_me" type="checkbox" value="1" />
            <label for="user_remember_me"> <?php echo _("Remember me")?></label>
           
            <input class="btn btn-primary" type="submit" value="<?php echo _("Sign In")?>" style="width:100%" />
          </form>
        </div>
      </li>
    </ul>
    <?php
  }
}