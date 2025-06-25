<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [

            'Add Client',
            'Edit Ticket',
            'Family Access',
            'Reservation',
            'Capacity',
            'Group Access',
            'Corporations',
            'Exit',

        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
