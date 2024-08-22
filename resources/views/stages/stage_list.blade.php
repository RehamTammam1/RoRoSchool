@extends('layouts.master')

@section('css')

@section('title')
{{ trans('stage_list.stages') }}
@stop

@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">{{ trans('stage_list.stages') }}</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">Home</a></li>
                <li class="breadcrumb-item active">{{ trans('stage_list.stages') }}</li>
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
                    {{ trans('stage_list.add') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-xl-12 mb-30">
                    <div class="repeater">
                        <!-- Add Form -->
                        <form action="{{ route('stages.store') }}" method="POST" class=" row mb-30">
                            @csrf
                            <div data-repeater-list="group-a">
                                <div data-repeater-item>
                                    <div class="row">
                                        <div class="col">
                                            <label for="Name" class="mr-sm-2">{{ trans('stage_list.stage_name_ar') }}:</label>
                                            <input id="Name" type="text" name="Name" class="form-control">
                                        </div>
                                        <div class="col">
                                            <label for="Name_en" class="mr-sm-2">{{ trans('stage_list.stage_name_en') }}:</label>
                                            <input type="text" class="form-control" name="Name_en">
                                        </div>
                                        <div class="col">
                                            <label for="Grade_Name_en" class="mr-sm-2">{{ trans('grade_list.grade_name_en') }}:</label>
                                            <div class="box">
                                                <select name="grade_id" class="fancyselect">
                                                    @foreach($grades as $grade)
                                                    <option value="{{$grade->id}}">{{$grade->Name}}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <input class="btn btn-danger " data-repeater-delete type="button" value="Delete" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <input class="btn btn-primary" data-repeater-create type="button" value="Add new" />
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('grade_list.close') }}</button>
                                <button type="submit" class="btn btn-success">{{ trans('grade_list.submit') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- stages Table -->
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
                    <button type="button" class="btn btn- btn-md" data-toggle="modal" data-target="#exampleModal" title="{{ trans('stage_list.add') }}">
                        {{ trans('stage_list.add') }} <i class="fa fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-md hidden" id="stages_mass_delete" title="{{ trans('stage_list.stages_mass_delete') }}">
                        {{ trans('stage_list.stages_mass_delete') }} <i class="fa fa-trash"></i>
                    </button>
                    <table id="datatable" class="table table-striped table-bordered p-0">
                        <thead>
                            <tr>
                                <th>
                                    <input name="select-all" id="select_all_satages" type="checkbox" onclick="CheckAll('stage',this)" />
                                </th>
                                <th> {{ trans('stage_list.number') }}</th>
                                <th>{{ trans('stage_list.stagename') }}</th>
                                <th>{{ trans('stage_list.gradename') }}</th>
                                <th>{{ trans('stage_list.operations') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            @foreach($stages as $stage)
                            <?php $i++ ?>
                            <tr>
                                <td>
                                    <input type="checkbox" class="stage" value="{{$stage->Grade->id}}">
                                </td>
                                <td>
                                    {{ $i }}
                                </td>
                                <td>{{ $stage->name }}</td>
                                <td>{{ $stage->Grade->Name }}</td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#edit{{ $grade->id }}" title="{{ trans('stage_list.edit') }}">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete{{ $grade->id }}" title="{{ trans('stage_list.delete') }}">
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
                                                {{ trans('stage_list.edit') }}
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- edit Form -->
                                            <form action="{{ route('stages.update','test') }}" method="POST">
                                                {{method_field('patch')}}
                                                @csrf
                                                <div class="row">
                                                    <div class="col">
                                                        <label for="Name" class="mr-sm-2">{{ trans('stage_list.stage_name_ar') }}:</label>
                                                        <input id="Name" type="text" name="Name" value="{{$stage->getTranslation('name','ar')}}" class="form-control">
                                                    </div>
                                                    <div class="col">
                                                        <label for="Name_en" class="mr-sm-2">{{ trans('stage_list.stage_name_en') }}:</label>
                                                        <input type="text" class="form-control" value="{{$stage->getTranslation('name','en')}}" name=Name_en>
                                                    </div>
                                                    <div class="col">
                                                        <input type="hidden" name="id" id="id" class="form-control" value="{{$stage->id}}">
                                                    </div>
                                                    <div class="col">
                                                        <label for="Grade_Name_en" class="mr-sm-2">{{ trans('grade_list.grade_name_en') }}:</label>
                                                        <div class="box">
                                                            <select name="grade_id" class="fancyselect">
                                                                @foreach($grades as $grade)
                                                                <option value="{{$grade->id}}">{{$grade->Name}}</option>
                                                                @endforeach

                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <br><br>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('stage_list.close') }}</button>
                                            <button type="submit" class="btn btn-success">{{ trans('stage_list.submit') }}</button>
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
                                                {{ trans('stage_list.delete') }}
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- delete Form -->
                                            <form action="{{ route('stages.destroy','test') }}" method="POST">
                                                {{method_field('Delete')}}
                                                @csrf
                                                <div class="row">
                                                    <div class="col">
                                                        {{trans('message.confirm_delete')}}
                                                        <input type="hidden" name="id" id="id" class="form-control" value="{{$stage->id}}">
                                                    </div>
                                                </div>
                                                <br><br>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('stage_list.close') }}</button>
                                            <button type="submit" class="btn btn-danger">{{ trans('stage_list.submit') }}</button>
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