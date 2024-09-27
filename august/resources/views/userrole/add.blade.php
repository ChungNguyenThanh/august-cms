@extends('August::layouts.app')
@section('page-title')
{{ trans('August::userrole.new_user_role') }}
@endsection
@section('content')

<div class="d-flex mb-2 justify-content-end">
    <a href="{{ route('august.user.role.index') }}" class="btn btn-secondary">{{ trans('August::userrole.back_to_list') }}</a>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @include('August::widgets.errors')
                <form class="form-horizontal" role="form" action="{{ route('august.user.role.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $arParams['ID'] }}">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-settings-tab" data-bs-toggle="tab" data-bs-target="#nav-settings" type="button" role="tab" aria-controls="nav-settings" aria-selected="true">{{ trans('August::userrole.settings') }}</button>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-settings" role="tabpanel" aria-labelledby="nav-settings-tab">
                            <div class="row">
                                <div class="col-12">
                                    <div class="p-2">
                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::userrole.code') }}</label>
                                            <div class="col-md-9">
                                                @php 
                                                if(isset($arParams['ROLE']) && !empty($arParams['ROLE']->code)) {
                                                    $code = $arParams['ROLE']->code;
                                                } else {
                                                    $code = '';
                                                }
                                                @endphp
                                                <input type="text" class="form-control" id="code" value="{{ $code }}" name="code">
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::userrole.name') }}</label>
                                            <div class="col-md-9">
                                                @php 
                                                if(isset($arParams['ROLE']) && !empty($arParams['ROLE']->name)) {
                                                    $name = $arParams['ROLE']->name;
                                                } else {
                                                    $name = '';
                                                }
                                                @endphp
                                                <input type="text" class="form-control" id="name" value="{{ $name }}" name="name">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary" name="btn_action" value="save">{{ trans('August::userrole.btn_save') }}</button>
                        <button type="submit" class="btn btn-success ms-1 me-1" name="btn_action" value="apply">{{ trans('August::userrole.btn_apply') }}</button>
                        <button type="button" class="btn btn-secondary">{{ trans('August::userrole.btn_cancel') }}</button>
                    </div>
                </form>

                <!-- end row -->
            </div>
        </div> <!-- end card -->
    </div><!-- end col -->
</div>

@endsection