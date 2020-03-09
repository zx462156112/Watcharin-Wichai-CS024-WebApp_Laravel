<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Typebooks extends Model
{
    protected $table = 'typebooks';//กำหนดชื่อตารางให้ตรงกับฐานข้อมูล


    public function books(){
        return $this->hasMany(Books::class);//กำหนดความสัมพันธืรูปแบบ One to Many ไปยังตาราง books
    }
}
