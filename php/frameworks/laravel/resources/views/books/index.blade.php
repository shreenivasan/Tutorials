@extends('books/template')
@section('content')
<h1>Peru BookStore</h1>
<a href="{{url('/books/create')}}" class="btn btn-success">Create Book</a>
<hr>

<table class="table table-striped table-bordered table-hover">
<thead>
<tr class="bg-info">
<th>Id</th>
<th>ISBN</th>
<th>Title</th>
<th>Author</th>
<th>Publisher</th>
<th>Thumbs</th>
<th colspan="3">Actions</th>
</tr>
</thead>
<tbody>
@foreach ($books as $book)
<tr>
<td>{{ $book->id }}</td>
<td>{{ $book->isbn }}</td>
<td>{{ $book->title }}</td>
<td>{{ $book->author }}</td>
<td>{{ $book->publisher }}</td>
<td><img src="{{asset('img/'.$book->image.'.jpg')}}" height="35" width="30"></td>
<td><a href="{{url('books',$book->id)}}" class="btn btn-primary">Read</a></td>
<td><a href="{{route('books.edit',$book->id)}}" class="btn btn-warning">Update</a></td>
<td>
{!! Form::open(['method' => 'DELETE', 'route'=>['books.destroy', $book->id]]) !!}
{!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
{!! Form::close() !!}
</td>
</tr>
@endforeach

<div class="dataTables_paginate paging_simple_numbers">
        {{ $books->links() }}
    </div>

<div class="container">
        <form action="books/search" method="POST" role="search">
            <input type="hidden" name="_method" value="POST">
            {{ csrf_field() }}
            <div class="input-group">
                <input type="text" class="form-control" name="q"
                    placeholder="Search users"> <span class="input-group-btn">
                    <button type="submit" class="btn btn-default">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>
    </div>
</tbody>
</table>
@endsection
