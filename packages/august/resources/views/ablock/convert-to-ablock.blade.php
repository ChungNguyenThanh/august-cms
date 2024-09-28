@extends('August::layouts.app')

@section('page-title')
    {{ trans('August::ablock.convert_to_ablock') . ' ' . $arParams['TABLE_NAME'] }}
@endsection

@section('content')

<div class="d-flex mb-2 justify-content-end">
    <a href="{{ route('august.ablock.list-table-db') }}" class="btn btn-secondary">{{ trans('August::ablock.back_to_list_table') }}</a>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">


                @include('August::widgets.errors')


                <form class="form-horizontal" role="form" action="{{ route('august.ablock.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $arParams['ablockID'] }}">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-settings-tab" data-bs-toggle="tab" data-bs-target="#nav-settings" type="button" role="tab" aria-controls="nav-settings" aria-selected="true">{{ trans('August::userfield.settings') }}</button>
                            <button class="nav-link" id="nav-language-settings-tab" data-bs-toggle="tab" data-bs-target="#nav-language-settings" type="button" role="tab" aria-controls="nav-language-settings" aria-selected="false">{{ trans('August::userfield.language_settings') }}</button>

                            <button class="nav-link" id="nav-user-field-tab" data-bs-toggle="tab" data-bs-target="#nav-user-field" type="button" role="tab" aria-controls="nav-user-field" aria-selected="false">{{ trans('August::userfield.list') }}</button>

                            <button class="nav-link" id="nav-access-tab" data-bs-toggle="tab" data-bs-target="#nav-access" type="button" role="tab" aria-controls="nav-access" aria-selected="false">{{ trans('August::ablock.access') }}</button>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-settings" role="tabpanel" aria-labelledby="nav-settings-tab">
                            <div class="row">
                                <div class="col-12">
                                    <div class="p-2">
                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end" for="ablock_name">{{ trans('August::ablock.ablock_name') }} <span class="text-danger">*</span></label>
                                            <div class="col-md-9">
                                                @php 
                                                if (isset($arParams['ablock_NAME']) && !empty($arParams['ablock_NAME'])) {
                                                    $ablock_name = $arParams['ablock_NAME'];
                                                } else {
                                                    $ablock_name = '';
                                                }
                                                @endphp
                                                <input type="" class="form-control" id="ablock_name" value="{{ $ablock_name }}" name="ablock_name">
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end" for="table_name">{{ trans('August::ablock.table_name') }} <span class="text-danger">*</span></label>
                                            <div class="col-md-9 align-items-center d-flex">
                                                <input type="hidden" class="form-control" id="table_name" value="{{ $arParams['TABLE_NAME'] }}" name="table_name">
                                                
                                                <span>{{ $arParams['TABLE_NAME'] }}</span>
                                            </div>
                                        </div>

                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end" for="description">{{ trans('August::ablock.description') }}</label>
                                            <div class="col-md-9 align-items-center d-flex">
                                                @php 
                                                if (isset($arParams['ablock_DESC']) && !empty($arParams['ablock_DESC'])) {
                                                    $description = $arParams['ablock_DESC'];
                                                } else {
                                                    $description = '';
                                                }
                                                @endphp
                                                <textarea class="form-control" id="description" rows="5" name="description">{{ $description }}</textarea>
                                            </div>
                                        </div>

                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end" for="sorting">{{ trans('August::userfield.sorting') }}</label>
                                            <div class="col-md-9">
                                                @php 
                                                if (isset($arParams['ablock_SORT']) && !empty($arParams['ablock_SORT'])) {
                                                    $sort = $arParams['ablock_SORT'];
                                                } else {
                                                    $sort = 100;
                                                }
                                                @endphp
                                                <input type="number" class="form-control" id="sorting" value="{{ $sort }}" name="sort">
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-language-settings" role="tabpanel" aria-labelledby="nav-language-settings-tab">
                            <div class="row">
                                <div class="col-12">
                                    
                                    <div class="p-2">
                                        @php
                                        $en = '';
                                        $vi = '';
                                        if(isset($arParams['ablock_LANG']) && !empty($arParams['ablock_LANG'])) {
                                            foreach($arParams['ablock_LANG'] as $key => $value) {
                                                if($value['lid'] == 'en') {
                                                    $en = $value['name'];
                                                }
                                                if($value['lid'] == 'vi') {
                                                    $vi = $value['name'];
                                                }
                                            }
                                        }
                                        @endphp
                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end" for="example-color">{{ trans('August::language.en') }}</label>
                                            <div class="col-md-9">
                                                <input type="" class="form-control" value="{{ $en }}" name="langs[en]">
                                            </div>
                                        </div>

                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end" for="form-range">{{ trans('August::language.vi') }}</label>
                                            <div class="col-md-9 align-self-center">
                                                <input type="" class="form-control" value="{{ $vi }}" name="langs[vi]">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-access" role="tabpanel" aria-labelledby="nav-access-tab">
                            <div class="row">
                                <div class="col-12">
                                    <div class="p-2">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="nav-user-field" role="tabpanel" aria-labelledby="nav-user-field-tab">
                            <div class="row">
                                <div class="col-12">
                                    <div class="p-2">
                                        <table class="table dt-responsive nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th><i class="fe-settings"></i></th>
                                                    <th>{{ trans('August::ablock.field_in_table') }}</th>
                                                    <th>{{ trans('August::userfieldtype.user_field_type') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($arParams['FIELD'] as $column => $type)
                                                <tr>
                                                    <td>
                                                        <div class="btn-group dropdown">
                                                            <a href="#" class="dropdown-toggle arrow-none" data-bs-toggle="dropdown" aria-expanded="false"><i class="fe-align-justify"></i></a>
                                                            <div class="dropdown-menu dropdown-menu-start" style="">
                                                                <a class="dropdown-item" href="#"><i class="mdi mdi-pencil me-2 text-muted font-18 vertical-middle"></i>{{ trans('August::messages.edit') }}</a>
                                                                <a class="dropdown-item" href="#"><i class="mdi mdi-content-copy me-2 text-muted font-18 vertical-middle"></i>{{ trans('August::messages.coppy') }}</a>

                                                                <a class="dropdown-item item-delete" data-item-url="#" data-bs-toggle="modal" data-bs-target="#confirm-delete-modal" href="#">
                                                                    <i class="mdi mdi-delete me-2 text-muted font-18 vertical-middle"></i>
                                                                    {{ trans('August::messages.delete') }}
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $column }}</td>
                                                    <td>{{ $type }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary" name="btn_action" value="save">{{ trans('August::userfield.btn_save') }}</button>
                        <button type="submit" class="btn btn-success ms-1 me-1" name="btn_action" value="apply">{{ trans('August::userfield.btn_apply') }}</button>
                        <a type="button" class="btn btn-secondary" href="{{URL::previous()}}">{{ trans('August::userfield.btn_cancel') }}</a>
                    </div>
                </form>

                <!-- end row -->
            </div>
        </div> <!-- end card -->
    </div><!-- end col -->
</div>

@endsection