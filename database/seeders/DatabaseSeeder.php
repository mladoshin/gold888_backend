<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Branch;
use App\Models\Region;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Region::create(['name' => 'Актау']);
        Branch::create(['region_id' => 1, 'name' => 'Филиал №11']);
         $users = [
             [
                 'region_id' => 1,
                 'branch_id' => 1,
                 'name' => 'Admin User',
                 'email' => 'admin@admin.com',
                 'password' => bcrypt('123456'),
             ],
             [
                 'region_id' => 1,
                 'branch_id' => 1,
                 'name' => 'Марат Кажымукан Сакенулы',
                 'email' => 'Maratov.kz95@mail.ru',
                 'password' => bcrypt('12345678Aa'),
             ],
             [
                 'region_id' => 1,
                 'branch_id' => 1,
                 'name' => 'Янгибаев Маркс Кахраманович',
                 'email' => 'yangibayev.marx@gmail.com',
                 'password' => bcrypt('YYmm1234'),
             ],
             [
                 'region_id' => 1,
                 'branch_id' => 1,
                 'name' => 'Мақымғалиева Гүлнұр Талғатқызы',
                 'email' => 'gulnur_22295@mail.ru',
                 'password' => bcrypt('Talgatovna95'),
             ],
             [
                 'region_id' => 1,
                 'branch_id' => 1,
                 'name' => 'Садык Карим Болатович',
                 'email' => 'djgraf1997@mail.ru',
                 'password' => bcrypt('20041997Karim'),
             ],
             [
                 'region_id' => 1,
                 'branch_id' => 1,
                 'name' => 'Бактияров Асхат Узакбаевич',
                 'email' => 'Baktyarov96@gmail.com',
                 'password' => bcrypt('Aseke131296'),
             ],
             [
                 'region_id' => 1,
                 'branch_id' => 1,
                 'name' => 'Мамырхан Султан Валиханович',
                 'email' => 'abikhanov_02@icloud.com',
                 'password' => bcrypt('Abikhanov012'),
             ],
             [
                 'region_id' => 1,
                 'branch_id' => 1,
                 'name' => 'Аймуханова Индира Нуроллаевна',
                 'email' => 'Indir-88@mail.ru',
                 'password' => bcrypt('Indira88'),
             ],
             [
                 'region_id' => 1,
                 'branch_id' => 1,
                 'name' => 'Мергенева Румия Руслановна',
                 'email' => 'rmergeneva@inbox.ru',
                 'password' => bcrypt('mergeneva2024'),
             ],
             [
                 'region_id' => 1,
                 'branch_id' => 1,
                 'name' => 'Аймуханова Гульсая Алтаевна',
                 'email' => 'gulsaya.aimukhanova@mail.ru',
                 'password' => bcrypt('adikonim1234'),
             ],
             [
                 'region_id' => 1,
                 'branch_id' => 1,
                 'name' => 'Бейщанов Азамат Гайдарұлы',
                 'email' => 'azamatbejsanov@gmail.com',
                 'password' => bcrypt('q2131yar'),
             ],
         ];
         \DB::table('users')->insert($users);
    }
}
