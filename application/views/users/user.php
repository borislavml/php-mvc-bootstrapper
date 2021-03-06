
<div class="col-md-10 col-sm-10 col-lg-8">
    <!-- USER PROFILE SECTION START -->
    <div class="card w-80" >
        <div class="card-header">
            <h5>User Profile</h5>
        </div>
        <div class="card-block">
            <form style="padding:10px" id="edit-user-profile" method="POST">
                <input type="hidden" name="user_id" value="<?php echo $user->id; ?>">
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
                               value="<?php echo $user->email; ?>"
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
                               value="<?php echo $user->username; ?>" 
                               placeholder="Username" required>
                    </div>
                </div>
                <div class="form-group row">
                <div class="col-md-3 col-sm-4 col-lg-2"></div>
                    <div class="col-md-7 col-sm-4 col-lg-8">
                        <a role="button" class="btn btn-info"
                           style="color:white"
                           data-toggle="modal" 
                           data-target="#changePasswordSection">
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
    <!-- USER PROFILE SECTION END -->
</br>
    <!-- USER ROLES SECTION START -->
    <div class="card w-80" >
        <div class="card-header">
            <h5>User Roles</h5>
        </div>
        <div class="card-block">
            <form style="padding:10px" id="edit-user-roles" method="POST">
            <input type="hidden" name="user_id" value="<?php echo $user->id; ?>">                     
                  <div class="form-check form-check-inline">
                        <input class="form-check-input checkbox-for-hidden-input" type="checkbox" 
                                id="consumer_role" 
                                checked="checked" disabled>       
                        <label class="form-check-label" for="consumer_role">
                            Consumer
                        </label>
                    </div>   
                    <div class="form-check form-check-inline">
                        <input class="form-check-input checkbox-for-hidden-input" type="checkbox" 
                                id="admin_role"  
                                <?php if (in_array("2", $user_roles_ids)) {
                                    echo 'checked="checked"';
                                }?>>     
                        <input type="hidden" name="admin_role" value="false">
                        <label class="form-check-label" for="admin_role">
                            Administrator
                        </label>
                    </div>                     
                    <div class="form-group row">
                        <div class="col-md-10 col-sm-8 col-lg-10"></div>
                        <div class="col-md-2 col-sm-4 col-lg-2">
                            <button type="submit" class="btn btn-info" value="save_user_roles">Save</button>
                        </div>
                    </div>
            </form>
        </div>
    <!-- USER ROLES SECTION END -->
    </div>
 </div>


<!-- alerts for success and error -->
<div class="alert alert-danger text-center center-div" role="alert" id="error-editing-user-alert" style="display:none">                   
</div>
<div class="alert alert-success text-center center-div" role="alert" id="sucess-editing-user-alert" style="display:none">                      
 </div>

<!-- 
change password modal -->
 <div class="modal fade" id="changePasswordSection" 
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
      <form id="change-user-password" method="POST">
      <div class="modal-body">
        <input type="hidden" name="user_id" value="<?php echo $user->id; ?>">   
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
        <button type="submit" class="btn btn-info" value="change_user_password">Change</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script src="<?php echo Config::get('URL'); ?>public/js/edit-user.js"></script>