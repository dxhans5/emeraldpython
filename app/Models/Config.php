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
        $record = $this->first();

        if(empty($record)) {
            $this->id = 1;
            $record = $this->save();
        }

        return $record;
    }
}
