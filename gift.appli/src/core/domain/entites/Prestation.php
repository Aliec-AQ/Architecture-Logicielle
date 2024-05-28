<?php
namespace gift\appli\core\domain\entites;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Prestation extends Model {

    use HasUuids;
    protected $table = 'prestation';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function boxes(){
        return $this->belongsToMany(Box::class, 'box2presta', 'presta_id', 'box_id')
                ->withPivot('quantite');
    }

    public function categorie(){
        return $this->belongsTo(Categorie::class, 'cat_id');
    }
}