<?php
namespace gift\appli\infrastructure;

class Eloquent
{
    public static function init(string $confFile): void{
        $db = new \Illuminate\Database\Capsule\Manager();
        $db->addConnection(parse_ini_file($confFile));
        $db->setAsGlobal();
        $db->bootEloquent();
    }
}