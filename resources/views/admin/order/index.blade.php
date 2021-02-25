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
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order as $row)
                        <tr>
                            <td>{{$row->name}}</td>
                            <td>{{$row->number_of_copies}}</td>
                            <td>{{$row->price*$row->number_of_copies}}$</td>
                            <td>
                                @if ($row->bought = 1)
                                <span class="badge badge-warning">قيد المعالجة</span>
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
