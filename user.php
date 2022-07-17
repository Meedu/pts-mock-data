<?php
require_once 'vendor/autoload.php';

$config = require_once './config.php';

ini_set('memory_limit', '512M');

$faker = Faker\Factory::create();

$mobile =  $config['user']['mobile'];
$password = '$2y$10$rx5GUeOLNKhNxj5rQW1a0.6Jaf4/LlKIxXsFd7OnJQ0nMyFv/EZkm'; //123123
$now = date('Y-m-d H:i:s');

$rows = [];
for ($i = 0; $i < $config['user']['num']; $i++) {
    $mobile += 1;
    $rows[] = sprintf(
        // avatar,nick_name,mobile,password,credit1,credit2,credit3,is_active,is_lock,remember_token,created_at,updated_at,role_id,role_user_expired_at,
        '("%s", "%s", "%s", "%s", 0, 0, 0, 1, 0, "", "%s", "%s", 0, "", 0, 0, "", 0, 0, "%s", "%s", 0)',
        'https://mock.com/mock.png',
        $faker->name() . '_' . mt_rand(0, 1000),
        $mobile,
        $password,
        $now,
        $now,
        $faker->ipv4(),
        $faker->city(),
    );
}

$sql = 'INSERT INTO `users` (`avatar`, `nick_name`, `mobile`, `password`, `credit1`, `credit2`, `credit3`, `is_active`, `is_lock`, `remember_token`, `created_at`, `updated_at`, `role_id`, `role_expired_at`, `invite_balance`, `invite_user_id`, `invite_user_expired_at`, `is_password_set`, `is_set_nickname`, `register_ip`, `register_area`, `last_login_id`) VALUES ';
$sql .= implode(',', $rows);

file_put_contents('./data/' . date('Y-m-d') . '_users.sql', $sql);

echo 'success';
