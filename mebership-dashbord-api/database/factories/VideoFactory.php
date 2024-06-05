<?php

namespace Database\Factories;

use App\Models\Video;
use App\Models\User;
use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;

class VideoFactory extends Factory
{
    protected $model = Video::class;

    public function definition()
    {
      return [
        'title' => $this->faker->sentence,
        'url' => $this->faker->url,
        'group_id' => Group::factory(),
        'user_id' => User::factory(),
        'is_private' => false,
      ];
    }
}
