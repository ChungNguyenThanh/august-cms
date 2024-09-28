@extends('August::layouts.app')

@section('page-title')
    {{ trans('August::ablock.new_ablock') }}
@endsection

@section('content')

<div class="d-flex mb-2 justify-content-end">
    <a href="{{ route('august.ablock.index') }}" class="btn btn-secondary">{{ trans('August::ablock.back_to_list') }}</a>
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

                            <button class="nav-link" id="nav-extra-settings-tab" data-bs-toggle="tab" data-bs-target="#nav-extra-settings" type="button" role="tab" aria-controls="nav-extra-settings" aria-selected="false">{{ trans('August::userfield.extra_settings') }}</button>

                            <button class="nav-link" id="nav-language-settings-tab" data-bs-toggle="tab" data-bs-target="#nav-language-settings" type="button" role="tab" aria-controls="nav-language-settings" aria-selected="false">{{ trans('August::userfield.language_settings') }}</button>
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
                                            <div class="col-md-9">
                                                @php 
                                                if (isset($arParams['ablock_TABLE_NAME']) && !empty($arParams['ablock_TABLE_NAME'])) {
                                                    $table_name = $arParams['ablock_TABLE_NAME'];
                                                } else {
                                                    $table_name = '';
                                                }
                                                @endphp
                                                <input type="" class="form-control" id="table_name" value="{{ $table_name }}" name="table_name">
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

                        <div class="tab-pane fade" id="nav-extra-settings" role="tabpanel" aria-labelledby="nav-extra-settings-tab">
                            @php
                            $check_show_in_left_menu = '';
                            $val_show_in_left_menu = 'N';
                            $display_show_in_left_menu = 'display: none';
                            $title_in_left_menu = "";
                            $sort_in_left_menu = 100;

                            $template_view_list = array();

                            if (!empty($arParams['ablock_SETTINGS'])) {
                                $settings = json_decode($arParams['ablock_SETTINGS'], true);

                                if (isset($settings['show_in_left_menu']) && ($settings['show_in_left_menu'] == 'Y')) {
                                    $check_show_in_left_menu = 'checked';
                                    $val_show_in_left_menu = 'Y';
                                    $display_show_in_left_menu = '';
                                    $title_in_left_menu = $settings['title_in_left_menu'];
                                    $sort_in_left_menu = $settings['sort_in_left_menu'];
                                }

                                
                                if (isset($settings["template_view_list"]) && is_array($settings["template_view_list"])) {
                                    $template_view_list = $settings["template_view_list"];
                                }
                            }
                            @endphp
                            <div class="mb-2 row">
                                <label class="col-md-3 col-form-label text-end">{{ trans('August::ablock.show_in_left_menu') }}</label>
                                <div class="col-md-9 align-items-center d-flex">
                                    <input type="hidden" value="{{ $val_show_in_left_menu }}" id="show_in_left_menu" name="settings[show_in_left_menu]">
                                    <input {{ $check_show_in_left_menu }} class="form-check-input" type="checkbox" onclick="onShowInLeftMenu('show_in_left_menu', this, 'Y', 'N')">
                                </div>
                            </div>

                            <div style="<?php echo $display_show_in_left_menu ?>" id="settings_left_menu">
                                <div class="mb-2 row">
                                    <label class="col-md-3 col-form-label text-end">Tiêu đề menu</label>
                                    <div class="col-md-9">
                                        <input type="" class="form-control" id="title_in_left_menu" value="{{ $title_in_left_menu }}" name="settings[title_in_left_menu]">
                                    </div>
                                </div>

                                <div class="mb-2 row">
                                    <label class="col-md-3 col-form-label text-end">Thứ tự menu</label>
                                    <div class="col-md-9">
                                        <input type="number" class="form-control" id="sort_in_left_menu" value="{{ $sort_in_left_menu }}" name="settings[sort_in_left_menu]">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-2 row">
                                <label class="col-md-3 col-form-label text-end">{{ trans('August::ablock.template_view_list') }}</label>
                                <div class="col-md-9 template-list">
                                    <div>
                                        <span type="button" class="btn btn-secondary btn-template-list">{{ trans('August::ablock.add_template') }}</span>
                                    </div>
                                    @php
                                    foreach ($template_view_list as $key => $value) {
                                        @endphp
                                        <div class="d-flex gap-1 mt-1">
                                            <input type="" class="form-control" value="{{ $value }}" name="settings[template_view_list][]">
                                            <span class="btn btn-danger btn-delete-template">Xoá</span>
                                        </div>
                                        @php
                                    }
                                    @endphp
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
                                    <div class="p-2 list-access">
                                        @php
                                        $ind = 0;
                                        if(isset($arResults['RIGHT']) && !empty($arResults['RIGHT'])) {
                                            if ($arResults['RIGHT']) {
                                                foreach ($arResults['RIGHT'] as $right) {
                                                    @endphp
                                                    <div class="mb-2 row item-right">
                                                        <input type="hidden" name="entity_access[{{ $ind }}][user_id]" value="{{ $right['user_id'] }}">
                                                        <input type="hidden" name="entity_access[{{ $ind }}][access_code]" value="{{ $right['access_code'] }}">
                                                        <input type="hidden" name="entity_access[{{ $ind }}][provider_id]" value="{{ $right['provider_id'] }}">
                                                        <label class="col-md-3 col-form-label text-end" for="example-color">{{ $right["obj_name"] }}</label>
                                                        <div class="col-md-9">
                                                            <div class="d-flex gap-1 mb-1">
                                                                <select class="form-control" name="entity_access[{{ $ind }}][access]">
                                                                    @php
                                                                    foreach ($arResults['TASK'] as $kTask => $vTask) {
                                                                        if ($right['letter'] == $kTask) {
                                                                            $select = 'selected';
                                                                        } else {
                                                                            $select = '';
                                                                        }
                                                                        @endphp
                                                                        <option {{ $select }} value="{{ $kTask }}">{{ $vTask }}</option>
                                                                        @php
                                                                    }
                                                                    @endphp
                                                                </select>
                                                                <span class="btn btn-danger btn-delete-right">Xoá</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @php
                                                    $ind++;
                                                }
                                            }
                                        }
                                        @endphp
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary" name="btn_action" value="save">{{ trans('August::userfield.btn_save') }}</button>
                        <button type="submit" class="btn btn-success ms-1 me-1" name="btn_action" value="apply">{{ trans('August::userfield.btn_apply') }}</button>
                        <a type="button" class="btn btn-secondary" href="{{URL::previous()}}">{{ trans('August::userfield.btn_cancel') }}</a>
                        <span type="button" class="btn btn-secondary btn-access ms-1 d-none" data-bs-toggle="modal" data-bs-target="#access_modal">{{ trans('August::userfield.btn_add_access') }}</span>
                    </div>
                </form>

                <!-- end row -->
            </div>
        </div> <!-- end card -->
    </div><!-- end col -->
</div>

@if(isset($arResults) && !empty($arResults))
    @include('August::widgets.permission', ["arUser" => $arResults['USERS'], "arRole" => $arResults['ROLES'], "arTask" => $arResults['TASK']])
@endif
@endsection

@push('js')
<script>
    function onShowInLeftMenu(id, dom, val1, val2) {
        if ($(dom).is(':checked')) {
            $("#" + id).val(val1);
            $("#settings_left_menu").css('display', 'block');
        } else {
            $("#" + id).val(val2);
            $("#settings_left_menu").css('display', 'none');
        }
    }

    (function ($) {
        $(document).on('click', ".btn-template-list", function (e) {
            $(".template-list").append(`<div class="d-flex gap-1 mt-1"><input type="" class="form-control" value="" name="settings[template_view_list][]"><span class="btn btn-danger btn-delete-template">Xoá</span></div>`);
        });

        $(document).on('click', ".btn-delete-template", function (e) {
            $(this).parent().remove();
        });
        
    })(jQuery)

</script>
@endpush



