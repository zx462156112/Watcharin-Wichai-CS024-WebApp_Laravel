<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    protected $table = 'books';//กำหนดชื่อตารางในฐานข้อมูล
    protected $fillable =['title','price','typebooks_id'];//กำหนดให้สามารถเพิ่มข้อมูลได้ในคำสั่งเดียว Mass assingment


    public function typebooks(){
        return $this->belongsTo(Typebooks::class, 'typebooks_id');//กำหนด FK ด้วย
    }
}
