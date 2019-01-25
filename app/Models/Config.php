<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'config';
    protected $fillable = ['id'];

    public function getFirst() {
        return $this->firstOrNew(['id' => 1]);
    }
}
