<?php
require_once 'renderable.php';

class SignUp implements Renderable {
  public function render() {
    ?>
      <form>
        <div class="row">
          <div class="col-md-6">
            <input id="signup_name" name="name" type="text" class="form-control" placeholder="<?php echo _("full name")?>" />
            <br />
            <input id="signup_email" name="email" type="email" class="form-control" placeholder="<?php echo _("e-mail")?>" />
            <br/>
            <input id="signup_password" name="password" type="password" class="form-control" placeholder="<?php echo _("password")?>" />
          </div>
        </div>
      </form>
    <?php
  }
}