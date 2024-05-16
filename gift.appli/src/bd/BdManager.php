<?php

namespace gift\appli\bd;
use Illuminate\Database\Capsule\Manager as Manager;
class BdManager{
    static function connect(){
        $db = new Manager();
        $db->addConnection(parse_ini_file(__DIR__ .'/../conf/gift.db.conf.ini.dist'));
        $db->setAsGlobal();
        $db->bootEloquent();
    }
}