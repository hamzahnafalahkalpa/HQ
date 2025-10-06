<?php

namespace Projects\Hq\Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Hanafalah\LaravelSupport\Concerns\Support\HasRequest;
use Hanafalah\ModuleEmployee\Data\EmployeeData;
use Hanafalah\ModuleUser\Contracts\Data\UserData;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    use HasRequest;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = app(config('database.models.User'))->where('username','admin_hq')->first();
        if (!isset($user)){
            foreach ([
                'admin_hq','customer_hq',
            ] as $credential) {
                $role = $credential == 'admin_hq' ? 'Admin' : 'Customer';
                $role_ids   = app(config('database.models.Role'))->where('name',$role)->get()->pluck('id')->toArray();
                $user       = app(config('database.models.User'))->where('username',$credential)->first();
    
                request()->merge([
                    "id" => null,
                    'name' => $role,
                    "username" => $credential,
                    "password" => "password",
                    "password_confirmation" => "password", // Konfirmasi password
                    "email" => "hamzah_".$credential."@dev.com",
                    "email_verified_at" => now(),
                    "is_hq_user" => true,
                    "is_customer" => $role == 'Customer',
                    "user_reference" => [
                        "role_ids" => $role_ids, // Daftar role ID
                        "workspace_type" => 'Tenant',
                        "workspace_id" => tenancy()->tenant->id,
                        "reference_type" => "People",
                        "reference" => [ // Informasi individu
                            "id" => null,
                            "name" => "Hamzah",
                            "dob" => "1996-01-01", // Tanggal lahir
                            "pob" => "Pandeglang", // Tempat lahir
                            "card_identity" => [ // Identitas kartu lainnya
                                "nik" => null,
                                "npwp" => null,
                            ],
                            "phones" => [ // Daftar nomor telepon
                                "08129283746",
                            ]
                        ],
                    ]
                ]);
                app(config('app.contracts.User'))
                    ->prepareStoreUser($this->requestDTO(UserData::class));
            }
        }
    }
}
