@extends('August::layouts.app')
@section('page-title')
    {{ trans('August::file.new_file') }}
@endsection
@section('content')

<div class="d-flex mb-2 justify-content-end">
    <a href="{{ route('august.file.index') }}" class="btn btn-secondary">{{ trans('August::file.back_to_list') }}</a>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @include('August::widgets.errors')
                <form class="form-horizontal" role="form" action="{{ route('august.file.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $arParams['ID'] }}">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-settings-tab" data-bs-toggle="tab" data-bs-target="#nav-settings" type="button" role="tab" aria-controls="nav-settings" aria-selected="true">{{ trans('August::file.settings') }}</button>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-settings" role="tabpanel" aria-labelledby="nav-settings-tab">
                            <div class="row">
                                <div class="col-12">
                                    <div class="p-2">
                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::file.extension') }}</label>
                                            <div class="col-md-9">
                                                @php
                                                if(isset($arParams['FILE']) && !empty($arParams['FILE']->extension)) {
                                                    $extension = $arParams['FILE']->extension;
                                                } else {
                                                    $extension = '';
                                                }
                                                @endphp
                                                <input type="text" class="form-control" id="extension" value="{{ $extension }}" name="extension">
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::file.author') }}</label>
                                            <div class="col-md-9">
                                                @php 
                                                if(isset($arParams['FILE']) && !empty($arParams['FILE']->author)) {
                                                    $author = $arParams['FILE']->author;
                                                } else {
                                                    $author = '';
                                                }
                                                @endphp
                                                <input type="text" class="form-control" id="author" value="{{ $author }}" name="author">
                                            </div>
                                        </div>
                                        
                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::file.file') }}</label>
                                            <div class="col-md-9">
                                                @if (isset($arParams['FILE']) && !empty($arParams['FILE']->name) && !empty($arParams['FILE']->path)) 
                                                    @if($arParams['FILE']->is_image)
                                                        <img class="img-fluid w-50 mx-auto mb-2" src="{{ asset('storage/' . $arParams['FILE']->path) }}" alt="{{ $arParams['FILE']->name }}"/>
                                                    @else
                                                        <input type="text" class="form-control mb-2" readonly value="{{ $arParams['FILE']->name }}"/>
                                                    @endif
                                                @endif

                                                <input type="file" class="form-control" id="file" value="" name="file">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary" name="btn_action" value="save">{{ trans('August::file.btn_save') }}</button>
                        <button type="submit" class="btn btn-success ms-1 me-1" name="btn_action" value="apply">{{ trans('August::file.btn_apply') }}</button>
                        <button type="button" class="btn btn-secondary">{{ trans('August::file.btn_cancel') }}</button>
                    </div>
                </form>

                <!-- end row -->
            </div>
        </div> <!-- end card -->
    </div><!-- end col -->
</div>

@endsection