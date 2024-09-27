@extends('August::layouts.app')
@section('page-title')
    {{ trans('August::lang.new_lang') }}
@endsection
@section('content')

<div class="d-flex mb-2 justify-content-end">
    <a href="{{ route('august.lang.index') }}" class="btn btn-secondary">{{ trans('August::lang.back_to_list') }}</a>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @include('August::widgets.errors')
                <form class="form-horizontal" role="form" action="{{ route('august.lang.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $arParams['ID'] }}">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-settings-tab" data-bs-toggle="tab" data-bs-target="#nav-settings" type="button" role="tab" aria-controls="nav-settings" aria-selected="true">{{ trans('August::lang.settings') }}</button>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-settings" role="tabpanel" aria-labelledby="nav-settings-tab">
                            <div class="row">
                                <div class="col-12">
                                    <div class="p-2">
                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::lang.lang_id') }}</label>
                                            <div class="col-md-9">
                                                @php 
                                                if(isset($arParams['ABLOCK_LANG']) && !empty($arParams['ABLOCK_LANG']->lang_id)) {
                                                    $lang_id = $arParams['ABLOCK_LANG']->lang_id;
                                                } else {
                                                    $lang_id = '';
                                                }
                                                @endphp
                                                <input type="text" class="form-control" id="lang_id" value="{{ $lang_id }}" name="lang_id">
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::lang.flag') }}</label>
                                            <div class="col-md-9">
                                                @php 
                                                if(isset($arParams['ABLOCK_LANG']) && !empty($arParams['ABLOCK_LANG']->flag)) {
                                                    $flag = $arParams['ABLOCK_LANG']->flag;
                                                } else {
                                                    $flag = '';
                                                }
                                                @endphp
                                                <input type="text" class="form-control" id="flag" value="{{ $flag }}" name="flag">
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::lang.title') }}</label>
                                            <div class="col-md-9">
                                                @php 
                                                if(isset($arParams['ABLOCK_LANG']) && !empty($arParams['ABLOCK_LANG']->title)) {
                                                    $title = $arParams['ABLOCK_LANG']->title;
                                                } else {
                                                    $title = '';
                                                }
                                                @endphp
                                                <input type="text" class="form-control" id="title" value="{{ $title }}" name="title">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary" name="btn_action" value="save">{{ trans('August::lang.btn_save') }}</button>
                        <button type="submit" class="btn btn-success ms-1 me-1" name="btn_action" value="apply">{{ trans('August::lang.btn_apply') }}</button>
                        <button type="button" class="btn btn-secondary">{{ trans('August::lang.btn_cancel') }}</button>
                    </div>
                </form>

                <!-- end row -->
            </div>
        </div> <!-- end card -->
    </div><!-- end col -->
</div>

@endsection