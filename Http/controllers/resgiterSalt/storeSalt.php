<?php

use Core\App;
use Core\Database;
use Core\Validator;
use Core\Authenticator;

$db = App::resolve(Database::class);

$email = $_POST['email'];
$password = $_POST['password'];

$errors = [];
if (!Validator::email($email)) {
    $errors['email'] = 'Please provide a valid email address.';
}

if (!Validator::string($password, 7, 255)) {
    $errors['password'] = 'Please provide a password of at least seven characters.';
}

if (!empty($errors)) {
    return view('registration/create.view.php', [
        'errors' => $errors
    ]);
}

$user = $db->query('select * from users where email = :email', [
    'email' => $email
])->find();

if ($user) {
    header('location: /');
    exit();
} else {
    // Generate a random salt
    $salt = bin2hex(random_bytes(16));
    // Hash the password with the salt
    $hashedPassword = password_hash($password . $salt, PASSWORD_BCRYPT);

    $db->query('INSERT INTO users(email, password, salt) VALUES(:email, :password, :salt)', [
        'email' => $email,
        'password' => $hashedPassword,
        'salt' => $salt
    ]);

    $user = $db->query('select * from users where email = :email', [
        'email' => $email
    ])->find();

    (new Authenticator)->login([
        'email' => $email,
        'id' => $user['id']
    ]);

    header('location: /');
    exit();
}