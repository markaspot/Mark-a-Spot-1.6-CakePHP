<?php
class Group extends AppModel {
    var $name = 'Group';
    var $hasAndBelongsToMany = array(
            'Permission' => array('className' => 'Permission',
                        'joinTable' => 'groups_permissions',
                        'foreignKey' => 'group_id',
                        'associationForeignKey' => 'permission_id',
                        'unique' => true
            ),
            'User' => array('className' => 'User',
                        'joinTable' => 'groups_users',
                        'foreignKey' => 'group_id',
                        'associationForeignKey' => 'user_id',
                        'unique' => true
            )
    );
}
?>