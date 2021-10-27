<?php

namespace App\Models;

class Roles extends Model
{
    const STUDENT_ROLE = 'student';
    const PARENT_ROLE  = 'parent';
    const TEACHER_ROLE = 'teacher';

    public function remove_undesired_roles()
    {
        $roles_to_remove = ['editor', 'author', 'contributor', 'subscriber'];
        foreach ($roles_to_remove as $role) {
            remove_role($role);
        }
    }

    public function add_roles()
    {
        add_role(self::STUDENT_ROLE, ucwords(self::STUDENT_ROLE), []);
        add_role(self::PARENT_ROLE, ucwords(self::PARENT_ROLE), []);
        add_role(self::TEACHER_ROLE, ucwords(self::TEACHER_ROLE), []);
    }
}
