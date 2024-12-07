<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class JobTitlesTableSeeder extends Seeder
{

    // NOTE THIS JUST FOR EXAMPLE PURPOSE ONLY, IN REAL PROJECT USERS WILL NOO SEEDED
    public function run()
    {
        $sql = <<<EOT
        INSERT INTO "job_titles" ("id", "name", "status", "created_at", "updated_at", "department_id") VALUES (32, 'Safety & Maintenance', 'ACTIVE', '2024-12-05 22:09:54', '2024-12-05 22:09:54', 6);
        INSERT INTO "job_titles" ("id", "name", "status", "created_at", "updated_at", "department_id") VALUES (31, 'Quality Control', 'ACTIVE', '2024-12-05 22:09:54', '2024-12-05 22:09:54', 6);
        INSERT INTO "job_titles" ("id", "name", "status", "created_at", "updated_at", "department_id") VALUES (30, 'Inventory Auditing', 'ACTIVE', '2024-12-05 22:09:54', '2024-12-05 22:09:54', 6);
        INSERT INTO "job_titles" ("id", "name", "status", "created_at", "updated_at", "department_id") VALUES (29, 'Order Fulfillment', 'ACTIVE', '2024-12-05 22:09:54', '2024-12-05 22:09:54', 6);
        INSERT INTO "job_titles" ("id", "name", "status", "created_at", "updated_at", "department_id") VALUES (28, 'Stock Management', 'ACTIVE', '2024-12-05 22:09:54', '2024-12-05 22:09:54', 6);
        INSERT INTO "job_titles" ("id", "name", "status", "created_at", "updated_at", "department_id") VALUES (27, 'Receiving & Inspection', 'ACTIVE', '2024-12-05 22:09:54', '2024-12-05 22:09:54', 6);
        INSERT INTO "job_titles" ("id", "name", "status", "created_at", "updated_at", "department_id") VALUES (26, 'Customer Service', 'ACTIVE', '2024-12-05 22:09:54', '2024-12-05 22:09:54', 5);
        INSERT INTO "job_titles" ("id", "name", "status", "created_at", "updated_at", "department_id") VALUES (25, 'Sales Support', 'ACTIVE', '2024-12-05 22:09:54', '2024-12-05 22:09:54', 5);
        INSERT INTO "job_titles" ("id", "name", "status", "created_at", "updated_at", "department_id") VALUES (24, 'Telemarketing', 'ACTIVE', '2024-12-05 22:09:54', '2024-12-05 22:09:54', 5);
        INSERT INTO "job_titles" ("id", "name", "status", "created_at", "updated_at", "department_id") VALUES (23, 'Field Sales', 'ACTIVE', '2024-12-05 22:09:54', '2024-12-05 22:09:54', 5);
        INSERT INTO "job_titles" ("id", "name", "status", "created_at", "updated_at", "department_id") VALUES (22, 'Business Development', 'ACTIVE', '2024-12-05 22:09:54', '2024-12-05 22:09:54', 5);
        INSERT INTO "job_titles" ("id", "name", "status", "created_at", "updated_at", "department_id") VALUES (21, 'Account Management', 'ACTIVE', '2024-12-05 22:09:54', '2024-12-05 22:09:54', 5);
        INSERT INTO "job_titles" ("id", "name", "status", "created_at", "updated_at", "department_id") VALUES (20, 'Claims Handling', 'ACTIVE', '2024-12-05 22:09:54', '2024-12-05 22:09:54', 4);
        INSERT INTO "job_titles" ("id", "name", "status", "created_at", "updated_at", "department_id") VALUES (19, 'Delivery Management', 'ACTIVE', '2024-12-05 22:09:54', '2024-12-05 22:09:54', 4);
        INSERT INTO "job_titles" ("id", "name", "status", "created_at", "updated_at", "department_id") VALUES (18, 'Inventory Control', 'ACTIVE', '2024-12-05 22:09:54', '2024-12-05 22:09:54', 4);
        INSERT INTO "job_titles" ("id", "name", "status", "created_at", "updated_at", "department_id") VALUES (17, 'Tracking & Monitoring', 'ACTIVE', '2024-12-05 22:09:54', '2024-12-05 22:09:54', 4);
        INSERT INTO "job_titles" ("id", "name", "status", "created_at", "updated_at", "department_id") VALUES (16, 'Fleet Management', 'ACTIVE', '2024-12-05 22:09:54', '2024-12-05 22:09:54', 4);
        INSERT INTO "job_titles" ("id", "name", "status", "created_at", "updated_at", "department_id") VALUES (15, 'Dispatch Coordination', 'ACTIVE', '2024-12-05 22:09:54', '2024-12-05 22:09:54', 4);
        INSERT INTO "job_titles" ("id", "name", "status", "created_at", "updated_at", "department_id") VALUES (14, 'Customer Relationship Management (CRM)', 'ACTIVE', '2024-12-05 22:09:54', '2024-12-05 22:09:54', 3);
        INSERT INTO "job_titles" ("id", "name", "status", "created_at", "updated_at", "department_id") VALUES (13, 'Event Management', 'ACTIVE', '2024-12-05 22:09:54', '2024-12-05 22:09:54', 3);
        INSERT INTO "job_titles" ("id", "name", "status", "created_at", "updated_at", "department_id") VALUES (12, 'Brand Management', 'ACTIVE', '2024-12-05 22:09:54', '2024-12-05 22:09:54', 3);
        INSERT INTO "job_titles" ("id", "name", "status", "created_at", "updated_at", "department_id") VALUES (11, 'Market Research & Analysis', 'ACTIVE', '2024-12-05 22:09:54', '2024-12-05 22:09:54', 3);
        INSERT INTO "job_titles" ("id", "name", "status", "created_at", "updated_at", "department_id") VALUES (10, 'Content Marketing', 'ACTIVE', '2024-12-05 22:09:54', '2024-12-05 22:09:54', 3);
        INSERT INTO "job_titles" ("id", "name", "status", "created_at", "updated_at", "department_id") VALUES (9, 'Digital Marketing', 'ACTIVE', '2024-12-05 22:09:54', '2024-12-05 22:09:54', 3);
        INSERT INTO "job_titles" ("id", "name", "status", "created_at", "updated_at", "department_id") VALUES (8, 'Compliance & Legal', 'ACTIVE', '2024-12-05 22:09:54', '2024-12-05 22:09:54', 2);
        INSERT INTO "job_titles" ("id", "name", "status", "created_at", "updated_at", "department_id") VALUES (7, 'General Affairs', 'ACTIVE', '2024-12-05 22:09:54', '2024-12-05 22:09:54', 2);
        INSERT INTO "job_titles" ("id", "name", "status", "created_at", "updated_at", "department_id") VALUES (6, 'Employee Relations', 'ACTIVE', '2024-12-05 22:09:54', '2024-12-05 22:09:54', 2);
        INSERT INTO "job_titles" ("id", "name", "status", "created_at", "updated_at", "department_id") VALUES (5, 'Payroll & Compensation', 'ACTIVE', '2024-12-05 22:09:54', '2024-12-05 22:09:54', 2);
        INSERT INTO "job_titles" ("id", "name", "status", "created_at", "updated_at", "department_id") VALUES (4, 'HR Training & Development', 'ACTIVE', '2024-12-05 22:09:54', '2024-12-05 22:09:54', 2);
        INSERT INTO "job_titles" ("id", "name", "status", "created_at", "updated_at", "department_id") VALUES (3, 'HR Recruitment', 'ACTIVE', '2024-12-05 22:09:54', '2024-12-05 22:09:54', 2);
        INSERT INTO "job_titles" ("id", "name", "status", "created_at", "updated_at", "department_id") VALUES (2, 'Facility Management', 'ACTIVE', '2024-12-05 22:09:54', '2024-12-05 22:09:54', 1);
        INSERT INTO "job_titles" ("id", "name", "status", "created_at", "updated_at", "department_id") VALUES (1, 'General Operations', 'ACTIVE', '2024-12-05 22:09:54', '2024-12-05 22:09:54', 1);

    EOT;
        \DB::unprepared($sql);}
}
