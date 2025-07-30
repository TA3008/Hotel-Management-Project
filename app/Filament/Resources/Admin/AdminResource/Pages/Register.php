<?php

// namespace App\Filament\Resources\AdminResource\Pages;

// use App\Models\User;
// use Filament\Pages\Page;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Validator;
// use Stancl\Tenancy\Database\Models\Tenant;

// class Register extends Page
// {
//     protected static string $view = 'filament.pages.register';

//     protected static ?string $navigationIcon = 'heroicon-o-user-plus';

//     protected static string $routePath = 'register'; // /admin/register

//     public $company;
//     public $name;
//     public $email;
//     public $password;
//     public $password_confirmation;

//     public function submit()
//     {
//         $data = Validator::make([
//             'company' => $this->company,
//             'name' => $this->name,
//             'email' => $this->email,
//             'password' => $this->password,
//             'password_confirmation' => $this->password_confirmation,
//         ], [
//             'company' => 'required|alpha_dash|unique:tenants,id',
//             'name' => 'required',
//             'email' => 'required|email|unique:users,email',
//             'password' => 'required|confirmed|min:6',
//         ])->validate();

//         $tenant = Tenant::create([
//             'id' => $data['company'],
//         ]);

//         $tenant->domains()->create([
//             'domain' => $data['company'] . '.' . config('tenancy.central_domains.0'),
//         ]);

//         $tenant->run(function () use ($data) {
//             User::create([
//                 'name' => $data['name'],
//                 'email' => $data['email'],
//                 'password' => Hash::make($data['password']),
//             ]);
//         });

//         // Redirect to tenant domain
//         return redirect()->to('http://' . $data['company'] . '.' . config('tenancy.central_domains.0') . '/admin/login');
//     }
// }
