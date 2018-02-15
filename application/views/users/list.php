
<div class="col-md-10">
    <h1 class="text-center">Users</h1>
    <table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Username</th>
            <th scope="col">Email</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $user) { ?>
        <tr>
            <th scope="row"> <?php if (isset($user->id)) echo $user->id; ?></th>
            <td><?php  if (isset($user->username)) echo $user->username; ?></td>
            <td><?php if (isset($user->email)) echo $user->email; ?></td>
        </tr>
       <?php } ?>
    </tbody>
    </table>
</div>