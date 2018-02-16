<?php if($user_is_admin) {?>

<div class="col-md-9">
    <h1 class="text-center">Users</h1>
    <div class="table-responsive">
        <table class="table table-sm table-striped table-bordered table-hover custom-bootstrap-table">
        <thead>
            <tr>
                <th scope="col">Username</th>
                <th scope="col">Email</th>
                <th scope="col">Date registered </th>
                <th scope="col">Action</th> 
            </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user) { ?>
            <tr>
                <td><?php  if (isset($user->username)) echo $user->username; ?></td>
                <td><?php if (isset($user->email)) echo $user->email; ?></td>
                <td><?php if (isset($user->date_registered)) echo $user->date_registered ?></td>
                <td><button type="button" class="btn btn-sm btn-info">Edit>></button></td> 
            </tr>
        <?php } ?>
        </tbody>
        </table>
    </div>
</div>

<?php } ?>