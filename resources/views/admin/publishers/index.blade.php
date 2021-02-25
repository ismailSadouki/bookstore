@extends('theme.default')

@section('head')
    <link href="{{ asset('theme/vendor/datatables/dataTables.bootstrap4.min.js') }} " rel="stylesheet">
@endsection
@section('heading')
    عرض الناشرين
@endsection

@section('content')
    <a href="{{route('publishers.create')}}" class="btn btn-primary"><i class="fas fa-plus"></i>اضف ناشرا جديدا</a>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <table id="books-table" width="100%" cellspacing="0" class="table table-stribed text-right">
                <thead>
                    <tr>
                        <th>الاسم</th>
                        <th>العنوان</th>
                        <th>خيارات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($publishers as $publisher)
                       <tr>
                            <td>{{$publisher->name}}</td>
                            <td>{{$publisher->address}}</td>
                            <td>
                                <a href="{{route('publishers.edit',$publisher)}}" class="btn btn-info btn-sm mb-2"><i class="fa fa-edit"></i>تعديل</a>
                                <form action="{{route('publishers.destroy',$publisher)}}" method="POST" class="d-inline-block" >
                                    @method('delete')
                                    @csrf
                                    <button class="btn btn-danger btn-sm mb-2" style="margin-left: 0px;border-left-width: 7px;" type="submit" onclick="return confirm('هل انت متأكد؟')"><i class="fa fa-trash"></i>حذف</button>
                                </form>
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
