<?php
namespace gift\api\core\domain\entites;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model {
    protected $table = 'categorie';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function prestations(){
        return $this->hasMany(Prestation::class, 'cat_id');
    }
}