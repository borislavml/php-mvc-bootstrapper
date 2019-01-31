<?php 

abstract class eRoles {
    const Consumer = 1;
    const Admin = 2;
}

abstract class ePermissionGroups {
    const Consumer_Permission = 1;
    const Admin_Permission = 2;
}

abstract class ePermissions {
    // admin permissions
    const Manage_Users = 10;
}