<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TypeBooks;//นำเอาโมเดล Typebooks เข้ามาใช้งาน

class TypeBooksController extends Controller
{
    public function index(){
        //$typebooks = Typebooks::all();//แสดงข้อมูลทั้งหมด
        //$typebooks = Typebooks::orderBy('id','desc')->get();//แสดงข้อมูลเรียงจากมากไปน้อยโดยใช้ id
       $count = TypeBooks::count();//นับจำนวนแถวทั้งหมด


        //แบ่งหน้า
        //$typebooks = TypeBooks::simplePaginate(3);
        $typebooks = TypeBooks::paginate(3);


       return view('typebooks.index', [
           'typebooks' => $typebooks,
           'count' => $count
       ]); // ส่งไปที่ views โฟลเดอร์ typebooks ไฟล์ index.blade.php
    }
    public function destroy($id){
         //Typebppks::find($id)->delete();
        TypeBooks::destroy($id);
        return back();
    
    }
}
   
