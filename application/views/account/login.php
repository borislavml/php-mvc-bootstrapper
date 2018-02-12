<div class="col-md-4 col-sm-2 col-lg-4"> </div>
<div class="col-md-4 col-sm-8 col-lg-4">
    <form action="<?php echo URL; ?>account/login" method="POST">
        <div class="form-group"><h4 class="text-center"> Login</h1></div>
        <div class="form-group">
            <label for="email">Email address</label>
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">@</div>
                </div>
                <input type="email"  name="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" required>
            </div>
            <small id="emailHelp" class="form-text text-muted">Enter your email address</small>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" id="password" aria-describedby="passwordHelp" placeholder="Enter Password" required>
            <small id="passwordHelp" class="form-text text-muted">Enter your password</small>
        </div>                   
        <div class="text-center">
            <button type="submit" name="login" class="btn btn-primary">Login</button>
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
<div class="col-md-4 col-sm-2 col-lg-4"></div>
