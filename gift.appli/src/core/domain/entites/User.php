<?php
namespace gift\appli\core\domain\entites;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class User extends Model {
    const ROLE_USER = 1;
    const ROLE_ADMIN = 100; 

    use HasUuids;
    protected $table = 'user';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function boxes(){
        return $this->hasMany(Box::class, 'createur_id');
    }
}