<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Reaction;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Create 10 Users
        User::factory(10)->create()->each(function ($user) {

            // Each User creates 2 Posts
            $user->posts()->saveMany(
                Post::factory(2)->make()
            )->each(function ($post) use ($user) {

                // Each Post gets 3 Comments from random users
                Comment::factory(3)->create([
                    'post_id' => $post->id,
                    'user_id' => User::inRandomOrder()->first()->id,
                ]);

                // Each Post gets 5 Reactions from random users
                Reaction::factory(5)->create([
                    'post_id' => $post->id,
                    'user_id' => User::inRandomOrder()->first()->id,
                ]);
            });
        });
    }
}
