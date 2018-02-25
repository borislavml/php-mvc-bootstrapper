
<div class="col-md-1 col-lg-2"></div>

<div class="col-md-10 col-sm-12 col-lg-8">
    <!-- USER PROFILE SECTION START -->
    <div class="card " >
        <div class="card-header">
            <h5>My Account</h5>
        </div>
        <div class="card-block">
            <form style="padding:10px" id="edit-profile" method="POST">
                <input type="hidden" name="user_id" value="<?php echo $profile->id; ?>">
                <div class="form-group row">
                    <label class="col-md-2 col-sm-4 col-lg-2">Registration date</label>
                    <div class="col-md-6 col-sm-8 col-lg-4">
                        <?php echo $profile->date_registered; ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail" class="col-md-2 col-sm-4 col-lg-2 col-form-label">Email</label>
                    <div class="col-md-6 col-sm-8 col-lg-4">
                        <input type="email" 
                               name="email"
                               class="form-control" 
                               id="inputEmail" 
                               value="<?php echo $profile->email; ?>"
                               placeholder="Email" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputUsername" class="col-md-2 col-sm-4 col-lg-2 col-form-label">Username</label>
                    <div class="col-md-6 col-sm-8 col-lg-4">
                        <input type="text" 
                               name="username"
                               class="form-control" 
                               id="inputUsername"
                               value="<?php echo $profile->username; ?>" 
                               placeholder="Username" required>
                    </div>
                </div>
                <div class="form-group row">
                <div class="col-md-3 col-sm-4 col-lg-2"></div>
                    <div class="col-md-7 col-sm-4 col-lg-8">
                        <a role="button" class="btn btn-info"
                           style="color:white"
                           data-toggle="modal" 
                           data-target="#changePassword">
                            Change Password 
                        </a>
                    </div>
                    <div class="col-md-2 col-sm-4 col-lg-2">
                        <button type="submit" class="btn btn-info" value="save_user">Save</button>
                    </div>
                </div>
            </form>
        </div> 
    </div>
</div>
<div class="col-md-1 col-lg-2"></div>



<!-- 
change password modal -->
<div class="modal fade" id="changePassword" 
      tabindex="-1" 
      role="dialog" 
      aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center">Change password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="change-password" method="POST">
      <div class="modal-body">
        <input type="hidden" name="user_id" value="<?php echo $profile->id; ?>">   
         <div class="form-group">
            <label for="current-password" class="col-form-label">Current password:</label>
            <input type="password" class="form-control" name="current-password" id="current-password" required>
          </div>
          <div class="form-group">
            <label for="new-password" class="col-form-label">New password:</label>
            <input type="password" class="form-control" name="new-password" id="new-password" required>
          </div>
          <div class="form-group">
            <label for="confirm-password" class="col-form-label">Re-enter password:</label>
            <input type="password" class="form-control" name="confirm-password" id="confirm-password" required>
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-info" value="change_password">Change</button>
      </div>
      </form>
    </div>
  </div>
</div>


<!-- alerts for success and error -->
<div class="alert alert-danger text-center center-div" role="alert" id="error-editing-profile-alert" style="display:none">                   
</div>
<div class="alert alert-success text-center center-div" role="alert" id="sucess-editing-proile-alert" style="display:none">                      
 </div>

 <script src="<?php echo Config::get('URL'); ?>public/js/edit-profile.js"></script>