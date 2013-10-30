<?php
require_once 'renderable.php';

class Login implements Renderable {
  public function render() {
    ?>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="#">Sign Up</a></li>
      <li class="dropdown">
        <a class="dropdown-toggle" href="#" data-toggle="dropdown">Sign In <strong class="caret"></strong></a>
        <div class="dropdown-menu" style="padding: 15px; padding-bottom: 0px;">
          <!-- Login form here -->
          <form action="login" method="post" accept-charset="UTF-8">
            <input id="user_username" type="text" class="form-control" />
            <input id="user_password" type="password" class="form-control" />
            <input id="user_remember_me" type="checkbox" value="1" />
            <label class="string optional" for="user_remember_me"> Remember me</label>
           
            <input class="btn btn-primary" type="submit" value="Sign In" />
          </form>
        </div>
      </li>
    </ul>
    <?php
  }
}