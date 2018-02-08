<div class="container">
    <div class="row">
        <div class="col-md-4 col-sm-2"> </div>
        <div class="col-md-4 col-sm-8"> 
            <h1 class="text-center">Login</h1>
        </div>           
        <div class="col-md-4 col-sm-2"> </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-sm-2"></div>
        <div class="col-md-4 col-sm-8">
            <form action="<?php echo URL; ?>account/login" method="POST">
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email"  name="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" required>
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
            </form>
        </div>  
        <div class="col-md-4 col-sm-2"></div>
    </div>
</div>   