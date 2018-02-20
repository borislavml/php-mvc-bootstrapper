<div class="col-md-10 col-sm-10 col-lg-8">
    <div class="card w-80" >
        <div class="card-header"><h3>User Profile</h3></div>
        <div class="card-block">
            <input type="hidden" name="user_id" vale="<?php echo $user->id; ?>">
            <form style="padding:10px" id="edit-user" method="POST">
                <div class="form-group row">
                    <label class="col-md-2 col-sm-4 col-lg-2">Registration date</label>
                    <div class="col-md-6 col-sm-8 col-lg-4">
                        <?php echo $user->date_registered; ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail" class="col-md-2 col-sm-4 col-lg-2 col-form-label">Email</label>
                    <div class="col-md-6 col-sm-8 col-lg-4">
                        <input type="email" 
                               name="email"
                               class="form-control" 
                               id="inputEmail" 
                               value=<?php echo $user->email; ?>
                               placeholder="Email">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputUsername" class="col-md-2 col-sm-4 col-lg-2 col-form-label">Username</label>
                    <div class="col-md-6 col-sm-8 col-lg-4">
                        <input type="text" 
                               name="username"
                               class="form-control" 
                               id="inputUsername"
                               value=<?php echo $user->username; ?> 
                               placeholder="Username">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-10 col-sm-8 col-lg-10"></div>
                    <div class="col-md-2 col-sm-4 col-lg-2">
                        <button type="submit"  class="btn btn-info" value="save_user">Save</button>
                    </div>
                </div>
            </from>
        </div> 
    </div>
    <div class="alert alert-danger centered"
         role="alert" 
         style="margin:10px;" 
         id="edit-user-error-alert"></div>
</div>