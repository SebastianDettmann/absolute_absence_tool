<?php

use App\Access;
use App\User;
use Illuminate\Database\Seeder;

/**
 * Class UsersTableSeeder
 */
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::flushEventListeners();

        factory(User::class)->state('admin')->create([
            'firstname' => 'Adminvorname',
            'lastname' => 'Adminnachname',
            'email' => 'admin@email.de',
            'password' => bcrypt('Quertz123'),
        ]);
        factory(User::class)->create([
            'firstname' => 'Uservorname',
            'lastname' => 'Usernachname',
            'email' => 'user@email.de'
        ]);
        factory(User::class, 3)->create();
        factory(User::class, 2)->state('admin')->create();

        $user_id = User::pluck('id');
        $access = Access::first();
        $access->users()->sync($user_id);
    }
}
