<?php if ($user_is_logged) { ?>

<div class="col-md-2 col-sm-2 col-lg-2">
    <div class="list-group list-group-flush">
        <a href="javascript:void(0)" 
           class="list-group-item list-group-item-action">Servermaps</a>
        <?php if($user_is_admin) { ?>
            <a href="<?php echo Config::get('URL'); ?>users/list"
               class="list-group-item list-group-item-action 
               <?php if($active_menu_option == "users") { echo 'active'; }?>">
               <img src="<?php if ($active_menu_option == "users") {
                     echo Config::get('URL') . '/public/img/sidebar-users-menu-active.png';
               } else {
                     echo  Config::get('URL') . 'public/img/sidebar-user-menu-inactive.png' ;
               }?>">
               &nbsp; Users</a>
    
        <?php } ?>
    </div>
</div>

<?php } ?>