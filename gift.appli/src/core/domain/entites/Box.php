<?php


namespace gift\appli\core\domain\entites;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


class Box extends Model {
    const EN_COURS = 1;
    const VALIDE = 2;
    const PAYE = 3;

    use HasUuids;
    protected $table = 'box';
    protected $primaryKey = 'id';
    public $timestamps = true;

    public function prestations(){
        return $this->belongsToMany(Prestation::class, 'box2presta', 'box_id', 'presta_id')
                ->withPivot('quantite');
    }

    public function user(){
        return $this->belongsTo(User::class, 'createur_id');
    }
}