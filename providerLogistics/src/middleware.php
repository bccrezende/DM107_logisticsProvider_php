<?php
$username = $_SERVER["PHP_AUTH_USER"];
$password = $_SERVER["PHP_AUTH_PW"];

if ((listUsers($container['db'], $username, $password)) == true) {
    $app->add(new Tuupola\Middleware\HttpBasicAuthentication([
        "users" => [
            $username => $password
        ],
        "error" => function ($request, $response, $arguments) {
            $data["Error Message: "] = $arguments["message"];
            return $response
                ->withHeader("Content-Type", "application/json")
                ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        }
    ]));
}else{
    $app->add(new Tuupola\Middleware\HttpBasicAuthentication([
        "users" => [
            'erro' => 'erro'
        ],
        "error" => function ($request, $response, $arguments) {
            $data["Error Message: "] = $arguments["message"];
            return $response
                ->withHeader("Content-Type", "application/json")
                ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        }
    ]));
    
}

function listUsers($db, $username, $password){
    $num_users = $db->users()->where('username', $username)->where('password', $password)->count("*");
    if ($num_users == 0) {
        return false;
    }
    return true;      
}
