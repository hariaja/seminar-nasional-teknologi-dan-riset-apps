<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Helpers\Global\Constant;
use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClientSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $user = User::create([
      'name' => 'Aldiama Hari Octavian',
      'email' => 'aldiama@gmail.com',
      'phone' => '085659466622',
      'email_verified_at' => now(),
      'password' => bcrypt(Constant::DEFAULT_PASSWORD),
      'status' => Constant::ACTIVE,
    ])->assignRole(Constant::PEMAKALAH);

    Client::create([
      'user_id' => $user->id,
      'first_name' => 'Aldiama Hari',
      'last_name' => 'Octavian',
      'gender' => Constant::MALE,
      'institution' => strtoupper('Politeknik Sukabumi'),
      'address' => 'Jl. Perintis Kemerdekaan No. 130 Kec. Cibadak, Kab. Sukabumi, Jawa Barat Indonesia 43351',
    ]);
  }
}
