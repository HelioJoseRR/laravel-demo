<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\Song;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Str;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // create an admin user for accessing song management
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);
        $this->command->info('Admin user created: admin@example.com / password');

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test_' . Str::random(5) . '@example.com',
        ]);
        $this->command->info('User created: ' . $user->id);

        $albums = Album::factory(5)->create();
        $this->command->info('Albums created: ' . $albums->pluck('id')->join(', '));

        $albums->each(function ($album) use ($user) {
            Song::factory(10)->create(['album_id' => $album->id]);
            $this->command->info('Songs created for album: ' . $album->id);

            if (!User::find($user->id)) {
                $this->command->error('User not found: ' . $user->id);
                return;
            }

            if (!Album::find($album->id)) {
                $this->command->error('Album not found: ' . $album->id);
                return;
            }

            Review::factory(3)->create([
                'album_id' => $album->id,
                'user_id' => $user->id,
                'text' => fake()->paragraph,
            ])->each(function ($review) {
                $this->command->info('Review created: ' . $review->id . ' for album: ' . $review->album_id . ' by user: ' . $review->user_id);
            });
            $this->command->info('Reviews created for album: ' . $album->id);
        });
    }
}
