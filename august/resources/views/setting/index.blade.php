@extends('August::layouts.app')
@section('page-title')
    {{ trans('August::setting.setting_site') }}
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @include('August::widgets.errors')
                <form class="form-horizontal" role="form" action="{{ route('august.setting.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-settings-tab" data-bs-toggle="tab" data-bs-target="#nav-settings" type="button" role="tab" aria-controls="nav-settings" aria-selected="true">{{ trans('August::menu.settings') }}</button>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-settings" role="tabpanel" aria-labelledby="nav-settings-tab">
                            <div class="row">
                                <div class="col-12">
                                    <div class="p-2">
                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::setting.title') }}</label>
                                            <div class="col-md-9">
                                                @php
                                                $site_title = '';
                                                if (!empty($arResults['site_title'])) {
                                                    $site_title = $arResults['site_title'];
                                                }
                                                @endphp
                                                <input type="text" class="form-control" id="site_title" value="{{ $site_title }}" name="site_title">
                                            </div>
                                        </div>

                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::setting.tagline') }}</label>
                                            <div class="col-md-9">
                                                @php
                                                $tagline = '';
                                                if (!empty($arResults['tagline'])) {
                                                    $tagline = $arResults['tagline'];
                                                }
                                                @endphp
                                                <input type="text" class="form-control" id="tagline" value="{{ $tagline }}" name="tagline">
                                            </div>
                                        </div>

                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::setting.site_icon') }}</label>
                                            <div class="col-md-9">
                                                @php
                                                if (!empty($arResults['site_icon'])) {
                                                    @endphp
                                                    <img class="img-fluid w-25 mx-auto mb-2" src="{{ $arResults['site_icon_path'] }}" alt=""/>
                                                    @php
                                                }
                                                @endphp
                                                <input type="file" class="form-control" id="site_icon" value="" name="site_icon">
                                            </div>
                                        </div>

                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::setting.site_logo') }}</label>
                                            <div class="col-md-9">
                                                @php
                                                if (!empty($arResults['site_logo'])) {
                                                    @endphp
                                                    <img class="img-fluid w-25 mx-auto mb-2" src="{{ $arResults['site_logo_path'] }}" alt=""/>
                                                    @php
                                                }
                                                @endphp
                                                <input type="file" class="form-control" id="site_logo" value="" name="site_logo">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary" name="btn_action" value="save">{{ trans('August::menu.btn_save') }}</button>
                        <button type="submit" class="btn btn-success ms-1 me-1" name="btn_action" value="apply">{{ trans('August::menu.btn_apply') }}</button>
                        <button type="button" class="btn btn-secondary">{{ trans('August::menu.btn_cancel') }}</button>
                    </div>
                </form>

                <!-- end row -->
            </div>
        </div> <!-- end card -->
    </div><!-- end col -->
</div>
@endsection

@push('js')

@endpush
