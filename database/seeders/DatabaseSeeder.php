<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Tweet;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory() -> create([
            'name' => 'Jiro',
            'email' => 'jiro.octavo@gmail.com',
        ]);

        User::factory(99)
            ->sequence(fn ($sequence) => ['name' => 'Person '.$sequence->index + 2])
            ->create();

        foreach(range(1,20) as $user_id){
            Tweet::factory()->create(['user_id' => $user_id]);
            foreach(range(1,20) as $user_id2){
                User::find($user_id)->follows()->attach(User::find($user_id2));
            }
        }


        foreach(range(21,40) as $user_id){
            Tweet::factory()->create(['user_id' => $user_id]);
            foreach(range(21,40) as $user_id2){
                User::find($user_id)->follows()->attach(User::find($user_id2));
            }
        }

        foreach(range(41,80) as $user_id){
            Tweet::factory()->create(['user_id' => $user_id]);
            foreach(range(41,80) as $user_id2){
                User::find($user_id)->follows()->attach(User::find($user_id2));
            }
        }

        foreach(range(61,80) as $user_id){
            Tweet::factory()->create(['user_id' => $user_id]);
            foreach(range(61,80) as $user_id2){
                User::find($user_id)->follows()->attach(User::find($user_id2));
            }
        }

        foreach(range(81,100) as $user_id){
            Tweet::factory()->create(['user_id' => $user_id]);
            foreach(range(81,100) as $user_id2){
                User::find($user_id)->follows()->attach(User::find($user_id2));
            }
        }
        // Tweet::factory(40)->create();
    }
}
