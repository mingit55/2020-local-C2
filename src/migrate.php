<?php

require  __DIR__ ."/App/DB.php";
use App\DB;

for($i = 1; $i <= 4; $i ++){
    $sql = "INSERT INTO users(user_id, user_name, password, photo, type) VALUES (?, ?, ?, ?, ?)";
    $params = ["specialist$i", "전문가$i", hash('sha256', "1234"), "specialist$i.jpg", "SPECIALIST"];
    DB::query($sql, $params);
}