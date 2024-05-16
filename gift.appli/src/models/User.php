<?php
namespace gift\appli\models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class User extends Model {
    
    use HasUuids;
    protected $table = 'user';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function boxes(){
        return $this->hasMany(Box::class, 'createur_id');
    }
}