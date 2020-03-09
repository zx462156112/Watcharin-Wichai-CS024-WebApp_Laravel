<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Books; //อย่าลืม use โมเดลเข้ามาใช้งาน
use App\Http\Requests\StoreBooksRequest;
use Image; //เรียกใช้ library จัดการรูปภาพเข้ามาใช้
use File;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Books::with('typebooks')->orderBy('id','desc')->paginate(5);
        return view('books/index',['books' => $books]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBooksRequest $request)
    {
        $book = new Books();
        $book->title = $request->title;
        $book->price = $request->price;
        $book->typebooks_id = $request->typebooks_id;
        if($request->hasFile('image')){
            $filename = str_random(10).'.'.$request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path().'/images/',$filename);
            Image::make(public_path().'/images/'.$filename)->resize(50,50)->save(public_path().'/images/resize/'.$filename);
            $book->image = $filename;
        } else {
            $book->image ='nopic.jpg';
        }
        $book->save();
        return redirect()->action('BooksController@index');

    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = Books::findOrFail($id);
        return view('books.edit', ['book' => $book]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreBooksRequest $request, $id)
    {
        $book = Books::find($id);
        $book->title = $request->title;
        $book->price = $request->price;
        $book->typebooks_id = $request->typebooks_id;

        if ($request->hasFile('image')) {

            //delete old file before update
            if ($book->image != 'nopic.jpg') {
                File::delete(public_path().'\\images\\'.$book->image);
                File::delete(public_path().'\\images\\resize\\'.$book->image);
            }

            $filename = str_random(10).'.'.$request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path().'/images/',$filename);
            Image::make(public_path().'/images/'.$filename)->resize(50,50)->save(public_path().'/images/resize/'.$filename);
            $book->image = $filename;
        }

        $book->save();
        return redirect()->action('BooksController@index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Books::find($id);
        if ($book->image != 'nopic.jpg'){
            File::delete(public_path().'\\images\\'.$book->image);
            File::delete(public_path().'\\images\\resize\\'.$book->image);
        }
       $book->delete();
       return redirect()->action('BooksController@index');

    }
}
