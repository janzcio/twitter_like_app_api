<?php

namespace Database\Factories;

use App\Models\Tweet;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class TweetFactory extends Factory
{
    protected $model = Tweet::class;

    public function definition()
    {
        return [
            'user_id' => function () {
                return \App\Models\User::factory()->create()->id;
            },
            'content' => $this->faker->sentence,
            'attachment' => function () {
                $file = $this->faker->image(storage_path('app/attachments'), 400, 300, null, false);
                return 'attachments/' . $file;
            },
        ];
    }
}