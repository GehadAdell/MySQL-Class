<?php

include "Db.php";

$db = new Db;
$user = [
    "name" => "sara",
    "email" => "sara@s.com",
    "password" => 123
];

echo "<pre>";
print_r($db->select("user", "name,email")->where("id", "=", "2")->getRow());

echo "<hr>";
print_r($db->select("user", "*")->where("name", "=", "mohamed")->orWhere("name", "=", "gehad")->getAll());

echo "<hr>";
print_r($db->insert("usererroe", $user)->excu());
// print_r($db->insert("user",$user)->excu());
// print_r($db->update("user",$user)->where("id","=","3")->excu());
// print_r($db->delete("user")->where("id","=","4")->excu());
