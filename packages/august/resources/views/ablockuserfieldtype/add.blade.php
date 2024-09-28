@extends('August::layouts.app')
@section('page-title')
    {{ trans('August::userfieldtype.new_field') }}
@endsection
@section('content')


<div class="d-flex mb-2 justify-content-end">
    <a href="{{ route('august.userfieldtype.index') }}" class="btn btn-secondary">{{ trans('August::userfieldtype.back_to_list') }}</a>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @include('August::widgets.errors')
                <form class="form-horizontal" role="form" action="{{ route('august.userfieldtype.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $arParams['ID'] }}">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-settings-tab" data-bs-toggle="tab" data-bs-target="#nav-settings" type="button" role="tab" aria-controls="nav-settings" aria-selected="true">{{ trans('August::userfield.settings') }}</button>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-settings" role="tabpanel" aria-labelledby="nav-settings-tab">
                            <div class="row">
                                <div class="col-12">
                                    <div class="p-2">
                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::userfieldtype.code') }} <span class="text-danger">*</span></label>
                                            <div class="col-md-9">
                                                @php 
                                                if(isset($arParams['USER_FIELD_TYPE']->code) && !empty($arParams['USER_FIELD_TYPE']->code)) {
                                                    $code = $arParams['USER_FIELD_TYPE']->code;
                                                }else{
                                                    $code = '';
                                                }
                                                @endphp
                                                <input type="text" class="form-control" id="code" value="{{ $code }}" name="code">
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::userfieldtype.user_field_type') }} <span class="text-danger">*</span></label>
                                            <div class="col-md-9">
                                                @php 
                                                if(isset($arParams['USER_FIELD_TYPE']->user_field_type) && !empty($arParams['USER_FIELD_TYPE']->user_field_type)) {
                                                    $user_field_type = $arParams['USER_FIELD_TYPE']->user_field_type;
                                                }else{
                                                    $user_field_type = '';
                                                }
                                                @endphp
                                                <input type="text" class="form-control" id="user_field_type" value="{{ $user_field_type }}" name="user_field_type">
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::userfieldtype.db_type') }} <span class="text-danger">*</span></label>
                                            <div class="col-md-9">
                                                @php 
                                                if(isset($arParams['USER_FIELD_TYPE']->db_type) && !empty($arParams['USER_FIELD_TYPE']->db_type)) {
                                                    $db_type = $arParams['USER_FIELD_TYPE']->db_type;
                                                }else{
                                                    $db_type = '';
                                                }
                                                @endphp
                                                <input type="text" class="form-control" id="db_type" value="{{ $db_type }}" name="db_type">
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::userfieldtype.accessori_type') }} <span class="text-danger">*</span></label>
                                            <div class="col-md-9">
                                                @php 
                                                if(isset($arParams['USER_FIELD_TYPE']->accessori_type) && !empty($arParams['USER_FIELD_TYPE']->accessori_type)) {
                                                    $accessori_type = $arParams['USER_FIELD_TYPE']->accessori_type;
                                                }else{
                                                    $accessori_type = '';
                                                }
                                                @endphp
                                                <input type="text" class="form-control" id="accessori_type" value="{{ $accessori_type }}" name="accessori_type">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary" name="btn_action" value="save">{{ trans('August::userfieldtype.btn_save') }}</button>
                        <button type="submit" class="btn btn-success ms-1 me-1" name="btn_action" value="apply">{{ trans('August::userfieldtype.btn_apply') }}</button>
                        <button type="button" class="btn btn-secondary">{{ trans('August::userfieldtype.btn_cancel') }}</button>
                    </div>
                </form>

                <!-- end row -->
            </div>
        </div> <!-- end card -->
    </div><!-- end col -->
</div>

@endsection