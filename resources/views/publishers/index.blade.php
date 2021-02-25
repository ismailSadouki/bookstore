@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <a style="text-decoration: none;color:gray" href="{{ route('gallery.publishers.index') }}">
                    <div class="card-header">الناشرون</div>
                 </a>
                <div class="card-body">
                  <div class="row justify content conter">
                      <form action="{{ route('gallery.publishers.search') }}"  class="form-inline col-md-6" method="GET">
                        <input type="text" class="form-control mx-sm-3 mb-2" name="term">
                        <button class="btn btn-secondary mb-2" type="submit">ابحث</button>
                      </form>
                  </div>
                  <hr>
                  <br>
                  <h3>{{$title}}</h3>
                  @if ($publishers->count())
                      <ul class="list-group">
                          @foreach ($publishers as $publisher)
                              <a style="color:gray" href="{{ route('gallery.publishers.show',$publisher) }}">
                               <li class="list-goup-item">
                                {{ $publisher->name }} ({{$publisher->books->count()}})
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
