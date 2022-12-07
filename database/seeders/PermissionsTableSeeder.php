<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'audit_log_show',
            ],
            [
                'id'    => 18,
                'title' => 'audit_log_access',
            ],
            [
                'id'    => 19,
                'title' => 'team_create',
            ],
            [
                'id'    => 20,
                'title' => 'team_edit',
            ],
            [
                'id'    => 21,
                'title' => 'team_show',
            ],
            [
                'id'    => 22,
                'title' => 'team_delete',
            ],
            [
                'id'    => 23,
                'title' => 'team_access',
            ],
            [
                'id'    => 24,
                'title' => 'user_alert_create',
            ],
            [
                'id'    => 25,
                'title' => 'user_alert_show',
            ],
            [
                'id'    => 26,
                'title' => 'user_alert_delete',
            ],
            [
                'id'    => 27,
                'title' => 'user_alert_access',
            ],
            [
                'id'    => 28,
                'title' => 'faq_management_access',
            ],
            [
                'id'    => 29,
                'title' => 'faq_category_create',
            ],
            [
                'id'    => 30,
                'title' => 'faq_category_edit',
            ],
            [
                'id'    => 31,
                'title' => 'faq_category_show',
            ],
            [
                'id'    => 32,
                'title' => 'faq_category_delete',
            ],
            [
                'id'    => 33,
                'title' => 'faq_category_access',
            ],
            [
                'id'    => 34,
                'title' => 'faq_question_create',
            ],
            [
                'id'    => 35,
                'title' => 'faq_question_edit',
            ],
            [
                'id'    => 36,
                'title' => 'faq_question_show',
            ],
            [
                'id'    => 37,
                'title' => 'faq_question_delete',
            ],
            [
                'id'    => 38,
                'title' => 'faq_question_access',
            ],
            [
                'id'    => 39,
                'title' => 'document_create',
            ],
            [
                'id'    => 40,
                'title' => 'document_edit',
            ],
            [
                'id'    => 41,
                'title' => 'document_show',
            ],
            [
                'id'    => 42,
                'title' => 'document_delete',
            ],
            [
                'id'    => 43,
                'title' => 'document_access',
            ],
            [
                'id'    => 44,
                'title' => 'setting_create',
            ],
            [
                'id'    => 45,
                'title' => 'setting_edit',
            ],
            [
                'id'    => 46,
                'title' => 'setting_show',
            ],
            [
                'id'    => 47,
                'title' => 'setting_delete',
            ],
            [
                'id'    => 48,
                'title' => 'setting_access',
            ],
            [
                'id'    => 49,
                'title' => 'workspace_create',
            ],
            [
                'id'    => 50,
                'title' => 'workspace_edit',
            ],
            [
                'id'    => 51,
                'title' => 'workspace_show',
            ],
            [
                'id'    => 52,
                'title' => 'workspace_delete',
            ],
            [
                'id'    => 53,
                'title' => 'workspace_access',
            ],
            [
                'id'    => 54,
                'title' => 'folder_create',
            ],
            [
                'id'    => 55,
                'title' => 'folder_edit',
            ],
            [
                'id'    => 56,
                'title' => 'folder_show',
            ],
            [
                'id'    => 57,
                'title' => 'folder_delete',
            ],
            [
                'id'    => 58,
                'title' => 'folder_access',
            ],
            [
                'id'    => 59,
                'title' => 'analysis_item_create',
            ],
            [
                'id'    => 60,
                'title' => 'analysis_item_edit',
            ],
            [
                'id'    => 61,
                'title' => 'analysis_item_show',
            ],
            [
                'id'    => 62,
                'title' => 'analysis_item_delete',
            ],
            [
                'id'    => 63,
                'title' => 'analysis_item_access',
            ],
            [
                'id'    => 64,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
