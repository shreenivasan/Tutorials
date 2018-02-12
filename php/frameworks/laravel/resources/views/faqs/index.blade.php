@extends('faqs/template')

@section('content')
 <h1>Peru BookStore</h1>
 <a href="{{url('/books/create')}}" class="btn btn-success">Create Book</a>
 <hr>
 <table class="table table-striped table-bordered table-hover">
     <thead>
     <tr class="bg-info">
         <th>Id</th>
         <th>Question</th>
         <th>Answer</th>
         <th>Status</th>
         <th>Platform</th>
         <th colspan='2'>Actions</th>
     </tr>
     </thead>
     <tbody>
     @foreach ($faqs as $faq)
         <tr>
             <td>{{ $faq->id }}</td>
             <td>{{ $faq->question }}</td>
             <td>{{ $faq->answer }}</td>
             <td>{{ $faq->status?'Active':'Inactive' }}</td>
             <td>{{ $faq->android=='Y'?'Android':'' }} 
				{{$faq->desktop=='Y'?',Web':'' }}
				{{$faq->wap=='Y'?',Wap':'' }}
				{{$faq->ios=='Y'?',IOS':'' }}
			</td>
             <td>
             {!! Form::open(['method' => 'DELETE', 'route'=>['faqs.destroy', $faq->id]]) !!}
             {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
             {!! Form::close() !!}
			 </td>
			<td>
				{!! Form::open(['method' => 'Edit', 'route'=>['faqs.edit', $faq->id]]) !!}
             {!! Form::submit('Edit', ['class' => 'btn btn-success']) !!}
             {!! Form::close() !!}
             </td>
             
         </tr>
     @endforeach
<div class="dataTables_paginate paging_simple_numbers">
        {{ $faqs->links() }}
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
