@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <a style="text-decoration: none;color:gray" href="{{ route('gallery.categories.index') }}">
                    <div class="card-header">تصنيفات الكتب</div>
                 </a>
                <div class="card-body">
                  <div class="row justify content conter">
                      <form action="{{ route('gallery.categories.search') }}"  class="form-inline col-md-6" method="GET">
                        <input type="text" class="form-control mx-sm-3 mb-2" name="term">
                        <button class="btn btn-secondary mb-2" type="submit">ابحث</button>
                      </form>
                  </div>
                  <hr>
                  <br>
                  <h3>{{$title}}</h3>
                  @if ($categories->count())
                      <ul class="list-group">
                          @foreach ($categories as $category)
                              <a style="color:gray" href="{{ route('gallery.categories.show',$category) }}">
                               <li class="list-goup-item">
                                {{ $category->name }} ({{$category->books->count()}})
                               </li>
                               </a>
                          @endforeach
                      </ul>
                  @else
                      <h4>لا توجد نتائج</h4>
                  @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
