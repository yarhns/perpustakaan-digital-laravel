<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;

class MemberFactory extends Factory
{
    public function definition()
    {
        $prodi = ['Teknik Informatika', 'Sistem Informasi', 'Manajemen', 'Akuntansi', 'Ilmu Komunikasi'];

        return [
            'name' => $this->faker->name(),
            'npm' => $this->faker->unique()->numerify('110122####'), // Format NPM
            'prodi' => $this->faker->randomElement($prodi),
        ];
    }
}