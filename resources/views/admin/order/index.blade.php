@extends('theme.default')

@section('head')
    <link href="{{ asset('theme/vendor/datatables/dataTables.bootstrap4.min.js') }} " rel="stylesheet">
@endsection
@section('heading')
    عرض الطلبيات
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <table id="books-table" width="100%" cellspacing="0" class="table table-stribed text-right">
                <thead>
                    <tr>
                        <th>الاسم</th>
                        <th>الكمية</th>
                        <th> السعر الكلي</th>
                        <th>الحالة</th>
                        <th>خيارات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order as $row)
                        <tr>
                            <td>{{$row->name}}</td>
                            <td>{{$row->number_of_copies}}</td>
                            <td>{{$row->price*$row->number_of_copies}}$</td>
                            <td>
                                {{-- @if ($row->bought == 1)
                                @elseif  
                                @else 
                                @endif --}}

                                @switch($row->bought)
                                    @case(3)
                                  <span class="badge badge-danger">تم الالغاء</span>
                                        
                                        @break
                                    @case(2)
                                  <span class="badge badge-success">تمت المراجعة</span>
                                        
                                        @break
                                    @default
                                  <span class="badge badge-warning">قيد المراجعة</span>
                                        
                                @endswitch
                            </td>
                            <td>
                                @if($row->bought != 1)
                                <div class="btn btn-success btn-sm mb-2 disabled" style="margin-left: 0px;border-left-width: 7px;" >موافقة</div>
                                <div class="btn btn-danger btn-sm mb-2 disabled" style="margin-left: 0px;border-left-width: 7px;" >الغاء</div>
                                @else
                                <form action="{{route('order.accept',$row->id)}}" method="POST" class="d-inline-block" >
                                    @csrf
                                    <button class="btn btn-success btn-sm mb-2 " style="margin-left: 0px;border-left-width: 7px;" >موافقة</button>
                                </form>
                                <form action="{{route('order.cancel',$row->id)}}" method="POST" class="d-inline-block" >
                                    @csrf
                                    <button class="btn btn-danger btn-sm mb-2 " style="margin-left: 0px;border-left-width: 7px;" >الغاء</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


@endsection 

@section('script')
    <script src="{{ asset('theme/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('theme/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        $(document).ready(function(){
            $('#books-table').DataTable({
                "language":{
                    "url":"//cdn.datatables.net/plug-ins/1.10.19/i18n/Arabic.json"
                }
            });
        });
    </script>
@endsection
