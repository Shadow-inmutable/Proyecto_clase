<?php
require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

$email = 'wrong@invalid.test';
$pass = 'notapassword';
$res = Auth::attempt(['email' => $email, 'password' => $pass]);
var_dump(['attempt' => $res]);

$u = \App\Models\User::where('email','admin@inventario.com')->first();
var_dump(['user_exists' => (bool)$u, 'user_email' => $u?->email]);
if ($u) {
    var_dump(['hash_check_seed' => Hash::check('admin1234', $u->password)]);
}

// Show currently authenticated user if any
var_dump(['auth_check' => Auth::check(), 'auth_user' => Auth::user()?->email]);
