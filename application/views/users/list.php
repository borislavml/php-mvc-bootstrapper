<div class="col-md-10 col-sm-10 col-lg-8">
    <h1 class="text-center">Users</h1>
    <div class="table-responsive">
        <table class="table table-sm table-striped table-bordered table-hover custom-bootstrap-table">
        <thead>
            <tr>
                <th scope="col">Email</th>
                <th scope="col">Roles</th>
                <th scope="col">Date registered</th>                
                <th scope="col">Action</th> 
            </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user) { ?>
            <tr>
                <td><?php  if (isset($user->email)) echo $user->email; ?></td>
                <td><?php if (isset($user->user_roles)) echo $user->user_roles ?></td>
                <td><?php if (isset($user->date_registered)) echo $user->date_registered ?></td>
                <td><a href="<?php echo Config::get('URL'); ?>users/user/<?php echo $user->id ?>"
                       type="button" 
                       class="btn btn-sm btn-info">Edit >></button></td> 
            </tr>
        <?php } ?>
        </tbody>
        </table>
    </div>
</div>
