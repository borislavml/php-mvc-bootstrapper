<div class="col-md-4 col-sm-2"></div>
<div class="col-md-4 col-sm-8">
    <form action="<?php echo Config::get('URL'); ?>account/register" method="POST">
        <div class="form-group">
            <h4 class="text-center">Register</h4>
        </div>
        <div class="form-group">
            <label for="email">Email address</label>
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">@</div>
                </div>
                <input type="email"  name="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" required>                
            </div>
            <small id="emailHelp" class="form-text text-muted">Provide an email address</small>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" id="password" aria-describedby="passwordHelp" placeholder="Enter Password" required>
            <small id="passwordHelp" class="form-text text-muted">Your password must be 6-20 characters long</small>
        </div>
        <div class="form-group">
            <label for="passwordConfirm">Confirm Password</label>
            <input type="password" class="form-control" name="confirm-password" id="passwordConfirm" aria-describedby="passwordConfirmHelp" placeholder="Confirm Password" required>
            <small id="passwordConfirmHelp" class="form-text text-muted">Confirm your password</small>
        </div>                      
        <div class="text-center">
            <button type="submit" name="create-account" class="btn btn-primary">Register</button>
        </div>
        <!-- validation messages -->
        <?php if(!empty($validation_message)) { ?>
            <div class="form-group">
                <div class="alert alert-danger" role="alert" style="margin:10px;">
                        <?php  echo $validation_message; ?>
                </div>
            <div class="form-group">
        <?php } ?>
    </form>
</div>  
<div class="col-md-4 col-sm-2"></div>