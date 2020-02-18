<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PgoodsModel extends Model
{
    protected  $table='p_goods';
    protected  $primaryKey='id';
    public $timestamps=false;
    protected $guarded=[];
}
