@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">معرض الكتب</div>

                <div class="card-body">

                    <div class="row justify-content-center">
                        <form action="{{route('search')}}" method="GET" class="form-inline col-md-6 justify-content-center">
                            <input type="text" name="term" class="form-control mx-sm-3 mb-2">
                            <button class="btn btn-secondary mb-2" type="submit">ابحث</button>
                        </form>
                    </div>
                    <hr>
                    <br>
                   <h3> {{$title}} </h3>
                    <div class="row">
                        @if ($books->count())
                            @foreach ($books as $book)
                                @if ($book->number_of_copies > 0)
                                    <div class="col-lg-3 col-md-4 col-6" style="margin-bottom:10px">
                                        <div class="d-block mb-2 h-100 border rounded" style="padding:10px">
                                            <a href="{{route('book.details',$book->id)}}" style="color:#555555">
                                            <img src="{{asset('storage/'.$book->cover_image)}}" alt="" class="img-fluid img-thumbnail">
                                            <b><p style="height:25px">{{$book->title}}</p></b>
                                             </a>
                                             <span class="score">
                                                <div class="score-wrap">
                                                    <span class="stars-active" style="width: {{ $book->rate()*20 }}%">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                    </span>
                                                    
                                                    <span class="stars-inactive">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                    </span>
                                                </div>
                                            </span>
                                            @if ($book->category != NULL)
                                                <br><a href="{{ route('gallery.categories.show', $book->category) }}" style="color:#525252">{{$book->category->name}}</a>
                                            @endif

                                            @if ($book->authors->isNotEmpty())
                                                <br><b>تاليف: </b>
                                                @foreach ($book->authors as $author)
                                                    {{$loop->first ? '' : 'و' }}
                                                    <a href="{{ route('gallery.authors.show',$author) }}" style="color:#525252">{{$author->name}}</a>
                                                @endforeach
                                            @endif
                                            <br>
                                            <b>السعر</b>{{$book->price}} $
                                            <a href="{{route('book.details',$book->id)}}" class="btn-link">
                                                <button class="btn btn-secondary mt-2">تفاصيل الكتاب</button>
                                            </a>     

                                            @auth
                                                <form method="POST" action="{{route('cart.add')}}" class="mt-2">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{$book->id}}">
                                                    <input type="number" name="quantity" value="1" min="1" max="{{$book->number_of_copies}}" class="form-control" style="width:40%; float:right" required>
                                                    <button class="btn btn-primary" type="submit" style="margin-right:10px">اضف <i class="fa-fa-plus"></i></button>
                                                </form>
                                            @endauth


                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @else
                         <h3 style="margin:0 auto">لا نتائج</h3>    
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
