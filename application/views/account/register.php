<div class="container">
<div class="row">
    <div class="col-md-4 col-sm-2"> </div>
    <div class="col-md-4 col-sm-8"> 
        <h1 class="text-center">Register</h1>
    </div>           
    <div class="col-md-4 col-sm-2"> </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4 col-sm-2"></div>
    <div class="col-md-4 col-sm-8">
        <form action="<?php echo URL; ?>account/register" method="POST">
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email"  name="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" required>
                <small id="emailHelp" class="form-text text-muted">Provide an email address</small>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" id="password" aria-describedby="passwordHelp" placeholder="Enter Password" required>
                <small id="passwordHelp" class="form-text text-muted">Provide a secure password</small>
            </div>
            <div class="form-group">
                <label for="passwordConfirm">Confirm Password</label>
                <input type="password" class="form-control" name="confirm-password" id="passwordConfirm" aria-describedby="passwordConfirmHelp" placeholder="Confirm Password" required>
                <small id="passwordConfirmHelp" class="form-text text-muted">Confirm your password</small>
            </div>                      
            <div class="text-center">
                <button type="submit" name="create-account" class="btn btn-primary">Register</button>
            </div>
        </form>
    </div>  
    <div class="col-md-4 col-sm-2"></div>
</div>
</div>