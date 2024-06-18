<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExercisesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('exercises')->insert([
            ['exercise_photo_url' => 'Img','name' => 'Push-Up','description' => 'Do 25 Push-Ups'],
            ['exercise_photo_url' => 'Img','name' => 'Sit-Up','description' => 'Do 25 Sit-Ups'],
            ['exercise_photo_url' => 'Img','name' => 'Squat','description' => 'Do 25 Squats'],
            ['exercise_photo_url' => 'Img','name' => 'Plank','description' => 'Hold a Plank for 1 minute'],
            ['exercise_photo_url' => 'Img','name' => 'Lunge','description' => 'Do 25 Lunges'],
            ['exercise_photo_url' => 'Img','name' => 'Burpee','description' => 'Do 25 Burpees'],
            ['exercise_photo_url' => 'Img','name' => 'Mountain Climber','description' => 'Do 25 Mountain Climbers'],
            ['exercise_photo_url' => 'Img','name' => 'Jumping Jack','description' => 'Do 25 Jumping Jacks'],
            ['exercise_photo_url' => 'Img','name' => 'High Knees','description' => 'Do 25 High Knees'],
            ['exercise_photo_url' => 'Img','name' => 'Butt Kick','description' => 'Do 25 Butt Kicks'],
        ]);
    }
}
