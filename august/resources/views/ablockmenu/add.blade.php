@extends('August::layouts.app')
@section('page-title')
    {{ trans('August::menu.new_menu') }}
@endsection
@section('content')

<div class="d-flex mb-2 justify-content-end">
    <a href="{{ route('august.menu.index')}}" class="btn btn-secondary">{{ trans('August::menu.back_to_list') }}</a>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @include('August::widgets.errors')
                <form class="form-horizontal" role="form" action="{{ route('august.menu.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $arParams['ID'] }}">
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
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::menu.menu_title') }}</label>
                                            <div class="col-md-9">
                                                @php
                                                if(isset($arParams['MENU']) && !empty($arParams['MENU']->menu_title)) {
                                                    $menu_title = $arParams['MENU']->menu_title;
                                                } else {
                                                    $menu_title = '';
                                                }
                                                @endphp
                                                <input type="text" class="form-control" id="menu_title" value="{{ $menu_title }}" name="menu_title">
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::menu.menu_link') }}</label>
                                            <div class="col-md-9">
                                                @php
                                                if(isset($arParams['MENU']) && !empty($arParams['MENU']->menu_link)) {
                                                    $menu_link = $arParams['MENU']->menu_link;
                                                } else {
                                                    $menu_link = '';
                                                }
                                                @endphp
                                                <input type="text" class="form-control" id="menu_link" value="{{ $menu_link }}" name="menu_link">
                                            </div>
                                        </div>
                                        
                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::menu.parent_item_menu') }}</label>
                                            <div class="col-md-9">
                                                <select class="form-control" name="parent_item_menu">
                                                    <option value="0">--</option>
                                                    @php 
                                                    if (isset($arParams['PARENT_MENU']) && !empty($arParams['PARENT_MENU'])) {
                                                        foreach($arParams['PARENT_MENU'] as $parent_item) {
                                                            if (!empty($arParams['MENU']->parent_item_menu) && $arParams['MENU']->parent_item_menu == $parent_item->id) {
                                                                $selected = 'selected';
                                                            } else {
                                                                $selected = '';
                                                            }
                                                            @endphp
                                                            <option value="{{ $parent_item->id }}" {{ $selected }}>{{ $parent_item->menu_id }}</option>
                                                            @php
                                                        }
                                                    }
                                                    @endphp
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-2 row">
                                            <label class="col-md-3 col-form-label text-end">{{ trans('August::menu.menu_group') }}</label>
                                            <div class="col-md-9">
                                                <select class="form-control" name="menu_group">
                                                    @php 
                                                    if (isset($arParams['GROUP']) && !empty($arParams['GROUP'])) {
                                                        foreach($arParams['GROUP'] as $key => $value) {
                                                            @endphp
                                                            <option value="{{ $value->code }}">{{ $value->name }}</option>
                                                            @php
                                                        }
                                                    }
                                                    @endphp
                                                </select>
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