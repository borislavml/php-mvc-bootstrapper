<?php if ($user_is_logged) { ?>

<div class="col-md-2">
    <div class="list-group list-group-flush">
        <a href="javascript:void(0)" 
           class="list-group-item list-group-item-action">Servermaps</a>
        <a href="javascript:void(0)" 
           class="list-group-item list-group-item-action">Procedures</a>
        <a href="javascript:void(0)" 
           class="list-group-item list-group-item-action">Preventim</a>
        <?php if($user_is_admin) { ?>
            <a href="<?php echo Config::get('URL'); ?>users/list"
               class="list-group-item list-group-item-action 
               <?php if($active_menu_option == "users") { echo 'active'; }?>">Users</a>
        <?php } ?>
    </div>
</div>

<?php } ?>