<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Member;

class MemberSeeder extends Seeder
{
    public function run()
    {
        // Buat 15 anggota otomatis
        Member::factory(15)->create();
    }
}