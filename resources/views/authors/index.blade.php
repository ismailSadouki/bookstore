@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <a style="text-decoration: none;color:gray" href="{{ route('gallery.authors.index') }}">
                    <div class="card-header">المؤلفون</div>
                 </a>
                <div class="card-body">
                  <div class="row justify content conter">
                      <form action="{{ route('gallery.authors.search') }}"  class="form-inline col-md-6" method="GET">
                        <input type="text" class="form-control mx-sm-3 mb-2" name="term">
                        <button class="btn btn-secondary mb-2" type="submit">ابحث</button>
                      </form>
                  </div>
                  <hr>
                  <br>
                  <h3>{{$title}}</h3>
                  <hr>
                  @if ($authors->count())
                      <ul class="list-group">
                          @foreach ($authors as $author)
                              <a style="color:gray" href="{{ route('gallery.authors.show',$author) }}">
                               <li class="list-goup-item">
                                {{ $author->name }} ({{$author->books->count()}})
                               </li>
                               </a>
                          @endforeach
                      </ul>
                  @else
                  <hr>
                  <br>
                      <h6>لا توجد نتائج</h6>
                  @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
