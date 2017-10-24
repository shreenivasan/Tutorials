<?php
namespace App\Http\Controllers;

use App\Book;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Request;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $books=Book::paginate(5);
        
        return view('books.index',compact('books'));
    }

    public function show($id)
    {
        $book=Book::find($id);
        return view('books.show',compact('book'));
    }
    
    public function create()
    {
        return view('books.create');
    }
    
    public function store()
    {
        $book=Request::all();
        Book::create($book);
        return redirect('books');
    }
    
    public function edit($id)
    {
        $book=Book::find($id);
        return view('books.edit',compact('book'));
    }
    
    public function update($id){
        
        $bookUpdate=Request::all();
        $book=Book::find($id);
        $book->update($bookUpdate);
        return redirect('books');
    }
    
    public function destroy($id)
    {
        Book::find($id)->delete();
        return redirect('books');
    }
    
        
}
