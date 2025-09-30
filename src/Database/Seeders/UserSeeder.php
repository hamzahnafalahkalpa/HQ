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
            $role_ids   = app(config('database.models.Role'))->where('name','Customer')->get()->pluck('id')->toArray();
            $user       = app(config('database.models.User'))->where('username','admin')->first();

            request()->merge([
                "id" => null,
                "username" => "admin_hq",
                "password" => "password",
                "password_confirmation" => "password", // Konfirmasi password
                "email" => "hamzahhq@dev.com",
                "email_verified_at" => now(),
                "user_reference" => [
                    "role_ids" => $role_ids, // Daftar role ID
                    "workspace_type" => 'Tenant',
                    "workspace_id" => tenancy()->tenant->id,
                    "reference_type" => "People",
                    "people" => [ // Informasi individu
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
