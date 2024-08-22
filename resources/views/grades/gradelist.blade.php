@extends('layouts.master')

@section('css')

@section('title')
{{ trans('grade_list.grades') }}
@stop

@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">{{ trans('grade_list.grades') }}</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">Home</a></li>
                <li class="breadcrumb-item active">{{ trans('grade_list.grades') }}</li>
            </ol>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection

@section('content')
<!-- main body -->
<!-- Add Modal Grade -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    {{ trans('grade_list.add') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add Form -->
                <form action="{{ route('grades.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <label for="Name" class="mr-sm-2">{{ trans('grade_list.grade_name_ar') }}:</label>
                            <input id="Name" type="text" name="Name" class="form-control">
                        </div>
                        <div class="col">
                            <label for="Name_en" class="mr-sm-2">{{ trans('grade_list.grade_name_en') }}:</label>
                            <input type="text" class="form-control" name="Name_en">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">{{ trans('grade_list.Notes') }}:</label>
                        <textarea class="form-control" name="Notes" id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>
                    <br><br>
            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('grade_list.close') }}</button>
                    <button type="submit" class="btn btn-success">{{ trans('grade_list.submit') }}</button>
                </div>
                </form>
        </div>
    </div>
</div>

<!-- Grades Table -->
<div class="row">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="col-xl-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
                <div class="table-responsive">
                    <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#exampleModal" title="{{ trans('grade_list.add') }}">
                        {{ trans('grade_list.add') }} <i class="fa fa-edit"></i>
                    </button>
                    <table id="datatable" class="table table-striped table-bordered p-0">
                        <thead>
                            <tr>
                                <th>{{ trans('grade_list.number') }}</th>
                                <th>{{ trans('grade_list.gradename') }}</th>
                                <th>{{ trans('grade_list.notes') }}</th>
                                <th>{{ trans('grade_list.operations') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            @foreach($grades as $grade)
                            <?php $i++ ?>
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $grade->Name }}</td>
                                <td>{{ $grade->Notes }}</td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#edit{{ $grade->id }}" title="{{ trans('grade_list.edit') }}">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete{{ $grade->id }}" title="{{ trans('grade_list.delete') }}">
                                        <i class="fa fa-trash"></i>

                                    </button>
                                </td>
                            </tr>
                            <!-- Edit Modal Grade -->
                            <div class="modal fade" id="edit{{ $grade->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                                                {{ trans('grade_list.edit') }}
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- edit Form -->
                                            <form action="{{ route('grades.update','test') }}" method="POST">
                                                {{method_field('patch')}}

                                                @csrf
                                                <div class="row">
                                                    <div class="col">
                                                        <label for="Name" class="mr-sm-2">{{ trans('grade_list.grade_name_ar') }}:</label>
                                                        <input id="Name" type="text" name="Name" value="{{$grade->getTranslation('Name','ar')}}" class="form-control">
                                                    </div>
                                                    <div class="col">
                                                        <label for="Name_en" class="mr-sm-2">{{ trans('grade_list.grade_name_en') }}:</label>
                                                        <input type="text" class="form-control" value="{{$grade->getTranslation('Name','en')}}" name=Name_en>
                                                    </div>
                                                    <div class="col">
                                                        <input type="hidden" name="id" id="id" class="form-control" value="{{$grade->id}}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleFormControlTextarea1">{{ trans('grade_list.Notes') }}:</label>
                                                    <textarea class="form-control" name="Notes" id="exampleFormControlTextarea1" rows="3">{{$grade->Notes}}</textarea>
                                                </div>
                                                <br><br>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('grade_list.close') }}</button>
                                            <button type="submit" class="btn btn-success">{{ trans('grade_list.submit') }}</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Delete Modal Grade -->
                            <div class="modal fade" id="delete{{ $grade->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                                                {{ trans('grade_list.delete') }}
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- delete Form -->
                                            <form action="{{ route('grades.destroy','test') }}" method="POST">
                                                {{method_field('Delete')}}
                                                @csrf
                                                <div class="row">
                                                    <div class="col">
                                                        {{trans('message.confirm_delete')}}
                                                        <input type="hidden" name="id" id="id" class="form-control" value="{{$grade->id}}">
                                                    </div>
                                                </div>
                                                <br><br>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('grade_list.close') }}</button>
                                            <button type="submit" class="btn btn-danger">{{ trans('grade_list.submit') }}</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>


                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- row closed -->
@endsection
@section('js')


@endsection