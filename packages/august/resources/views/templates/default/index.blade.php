@extends('August::layouts.app')
@section('page-title')
    {{ $arResults['PAGE_TITLE'] }}
@endsection

@section('content')

<div class="d-flex mb-2 justify-content-between gap-2 mobile-flex-wrap">
    <div class="d-flex mb-2 justify-content-start gap-2 mobile-flex-wrap w-20">
        @php
        if (count($arResults['TEMPLATE_VIEW_LIST']) > 1) {
            @endphp
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="group-btn-action" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Mãu hiển thị <i class="mdi mdi-chevron-down"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="group-btn-action" style="">
                    @php
                    foreach ($arResults['TEMPLATE_VIEW_LIST'] as $key => $value) {
                        @endphp
                        <a class="dropdown-item" href="{{ route('august.lists.index', ['id_block' => $arResults['BLOCK']->id])}}?template={{ $value }}">{{ $value }}</a>
                        @php
                    }
                    @endphp
                </div>
            </div>
        @php
        }
        @endphp
    </div>
    <div class="d-flex mb-2 justify-content-end gap-2 mobile-flex-wrap w-80">
        <div class="w-50 mobile-w-100">
            @include('August::widgets.filter', [
                'columns' => $arResults['COLUMNS'],
                'userFields' => $arResults['USER_FIELD'],
                'filterMode' => $arResults['FILTER_MODE'],
                'limit' => $arResults['LIMIT_SELECTED']
            ])
        </div>

        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="group-btn-action" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Hành động <i class="mdi mdi-chevron-down"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="group-btn-action" style="">
                @if (isset($arParams['ACTION_ACCESS']['EDIT_BLOCK_SETTING']) && $arParams['ACTION_ACCESS']['EDIT_BLOCK_SETTING'] == 'Y')
                    <a class="dropdown-item" href="{{ route('august.ablock.edit', ['field_id' => $arResults['BLOCK']->id])}}">{{ trans('August::list.setting_list') }}</a>
                    <a class="dropdown-item" href="{{ route('august.userfield.index', ['id_block' => $arResults['BLOCK']->id])}}">{{ trans('August::list.setting_field') }}</a>
                @endif

                @if (isset($arParams['ACTION_ACCESS']['EXPORT_EXCEL']) && $arParams['ACTION_ACCESS']['EXPORT_EXCEL'] == 'Y')
                    <a class="dropdown-item" href="{{ route('august.lists.exportexcel', ['id_block' => $arResults['BLOCK']->id])}}">{{ trans('August::list.export_excel') }}</a>
                @endif

                @if (isset($arParams['ACTION_ACCESS']['IMPORT_EXCEL']) && $arParams['ACTION_ACCESS']['IMPORT_EXCEL'] == 'Y')
                    <a class="dropdown-item" href="{{ route('august.lists.importexcel', ['id_block' => $arResults['BLOCK']->id])}}">{{ trans('August::list.import_excel') }}</a>
                @endif
            </div>
        </div>

        @if (isset($arParams['ACTION_ACCESS']['ADD_ELEMENT']) && $arParams['ACTION_ACCESS']['ADD_ELEMENT'] == 'Y')
            <a href="{{ route('august.lists.add', ['id_block' => $arResults['BLOCK']->id])}}" class="btn btn-primary">{{ trans('August::element.add_new') }}</a>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card mb-1">
            <div class="card-body overflow-auto">
                <table class="table dt-responsive nowrap w-100 mb-0">
                    <thead>
                        <tr>
                            <th><input class="form-check-input select-all" type="checkbox"></th>
                            <th>
                                <i class="fe-settings pointer" data-bs-toggle="modal" data-bs-target="#centermodal"></i>
                            </th>
                            @php
                            foreach ($arResults['COLUMNS'] as $key => $column) {
                                if ($arResults['USER_FIELD'][$key]['show_in_list'] == 'N') {
                                    continue;
                                }
                                @endphp
                                <th>{{ $column }}</th>
                                @php
                            }
                            @endphp
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        if (isset($arResults['ITEMS']) && !empty($arResults['ITEMS'])) {
                            foreach ($arResults['ITEMS'] as $item) {
                                @endphp
                                <tr>
                                    <td><input class="form-check-input item-select" type="checkbox"></td>
                                    <td>
                                    @if (isset($item['ID']))
                                        <div class="btn-group dropdown">
                                            <a href="#" class="dropdown-toggle arrow-none" data-bs-toggle="dropdown" aria-expanded="false"><i class="fe-align-justify"></i></a>
                                            <div class="dropdown-menu dropdown-menu-start">
                                                @if (isset($arParams['ACTION_ACCESS']['VIEW_ELEMENT']) && $arParams['ACTION_ACCESS']['VIEW_ELEMENT'] == 'Y')
                                                    <a class="dropdown-item" href="{{ route('august.lists.preview',['id_block' => $arResults['BLOCK']->id, 'id_element' => $item['ID']['value'] ]) }}"><i class="mdi mdi-eye me-2 text-muted font-18 vertical-middle"></i>{{ trans('August::messages.view') }}</a>
                                                @endif

                                                @if (isset($arParams['ACTION_ACCESS']['EDIT_ELEMENT']) && $arParams['ACTION_ACCESS']['EDIT_ELEMENT'] == 'Y')
                                                    <a class="dropdown-item" href="{{ route('august.lists.edit',['id_block' => $arResults['BLOCK']->id, 'id_element' => $item['ID']['value'] ]) }}"><i class="mdi mdi-pencil me-2 text-muted font-18 vertical-middle"></i>{{ trans('August::messages.edit') }}</a>
                                                @endif

                                                @if (isset($arParams['ACTION_ACCESS']['COPY_ELEMENT']) && $arParams['ACTION_ACCESS']['COPY_ELEMENT'] == 'Y')
                                                    <a class="dropdown-item" href="{{ route('august.lists.copy',['id_block' => $arResults['BLOCK']->id, 'id_element' => $item['ID']['value'] ]) }}"><i class="mdi mdi-content-copy me-2 text-muted font-18 vertical-middle"></i>{{ trans('August::messages.coppy') }}</a>
                                                @endif

                                                @if (isset($arParams['ACTION_ACCESS']['DELETE_ELEMENT']) && $arParams['ACTION_ACCESS']['DELETE_ELEMENT'] == 'Y')
                                                    <a class="dropdown-item item-delete" data-item-url="{{ route('august.lists.delete',['id_block' => $arResults['BLOCK']->id, 'id_element' => $item['ID']['value'] ]) }}" data-bs-toggle="modal" data-bs-target="#confirm-delete-modal" href="#"><i class="mdi mdi-delete me-2 text-muted font-18 vertical-middle"></i>{{ trans('August::messages.delete') }}</a>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                    </td>
                                    @php
                                        foreach ($item as $cel) {
                                            if ($cel['user_field']['show_in_list'] == 'N') {
                                                continue;
                                            }
                                            @endphp
                                            <td>
                                                @php
                                                if ($cel['user_type_id'] == 'string') {
                                                    @endphp
                                                    @include('August::widgets.string', [
                                                        "value" => $cel['value'],
                                                        "view" => 'list',
                                                        "userField" => $cel['user_field']
                                                    ])
                                                    @php
                                                } elseif ($cel['user_type_id'] == 'int') {
                                                    @endphp
                                                    @include('August::widgets.integer', [
                                                        "value" => $cel['value'],
                                                        "view" => 'list',
                                                        "userField" => $cel['user_field']
                                                    ])
                                                    @php
                                                } elseif ($cel['user_type_id'] == 'float') {
                                                    @endphp
                                                    @include('August::widgets.float', [
                                                        "value" => $cel['value'],
                                                        "view" => 'list',
                                                        "userField" => $cel['user_field']
                                                    ])
                                                    @php
                                                } elseif ($cel['user_type_id'] == 'date') {
                                                    @endphp
                                                    @include('August::widgets.date', [
                                                        "value" => $cel['value'],
                                                        "view" => 'list',
                                                        "userField" => $cel['user_field']
                                                    ])
                                                    @php
                                                } elseif ($cel['user_type_id'] == 'datetime') {
                                                    @endphp
                                                    @include('August::widgets.datetime', [
                                                        "value" => $cel['value'],
                                                        "view" => 'list',
                                                        "userField" => $cel['user_field']
                                                    ])
                                                    @php
                                                } elseif ($cel['user_type_id'] == 'phone') {
                                                    @endphp
                                                    @include('August::widgets.phone', [
                                                        "value" => $cel['value'],
                                                        "view" => 'list',
                                                        "userField" => $cel['user_field']
                                                    ])
                                                    @php
                                                } elseif ($cel['user_type_id'] == 'link') {
                                                    @endphp
                                                    @include('August::widgets.link', [
                                                        "value" => $cel['value'],
                                                        "view" => 'list',
                                                        "userField" => $cel['user_field']
                                                    ])
                                                    @php
                                                } elseif ($cel['user_type_id'] == 'enum') {
                                                    @endphp
                                                    @include('August::widgets.enum', [
                                                        "value" => $cel['value'],
                                                        "view" => 'list',
                                                        "userField" => $cel['user_field'],
                                                        "listEnum" => $cel['list_enum']
                                                    ])
                                                    @php
                                                } elseif ($cel['user_type_id'] == 'link_to_user') {
                                                    @endphp
                                                    @include('August::widgets.link_to_user', [
                                                        "value" => $cel['value'],
                                                        "view" => 'list',
                                                        "userField" => $cel['user_field']
                                                    ])
                                                    @php
                                                } elseif ($cel['user_type_id'] == 'file') {
                                                    @endphp
                                                    @include('August::widgets.file', [
                                                        "value" => $cel['value'],
                                                        "view" => 'list',
                                                        "userField" => $cel['user_field']
                                                    ])
                                                    @php
                                                } elseif ($cel['user_type_id'] == 'link_to_element') {
                                                    @endphp
                                                    @include('August::widgets.link_to_element', [
                                                        "value" => $cel['value'],
                                                        "view" => 'list',
                                                        "userField" => $cel['user_field']
                                                    ])
                                                    @php
                                                } elseif ($cel['user_type_id'] == 'html') {
                                                    @endphp
                                                    @include('August::widgets.html', [
                                                        "value" => $cel['value'],
                                                        "view" => 'list',
                                                        "userField" => $cel['user_field']
                                                    ])
                                                    @php
                                                } elseif ($cel['user_type_id'] == 'money') {
                                                    @endphp
                                                    @include('August::widgets.money', [
                                                        "value" => $cel['value'],
                                                        "view" => 'list',
                                                        "userField" => $cel['user_field']
                                                    ])
                                                    @php
                                                } else {
                                                    
                                                }
                                                @endphp
                                            </td>
                                            @php
                                        }
                                    @endphp
                                </tr>
                                @php
                            }
                        }
                        @endphp
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card">
            <div class="card-body pt-0 pb-0">
                <table class="table dt-responsive nowrap w-100 mb-0">
                    <tr class="border-0">
                        <td class="align-middle border-0">{{ trans('August::list.checked_item') }}: <span class="ckecked-total">0/{{ count($arResults['ITEMS']) }}</span></td>
                        <td class="align-middle border-0">{{ trans('August::list.total_item') }}: {{ $arResults['TOTAL_ITEMS'] }}</td>
                        <td class="align-middle border-0">
                            <div class="col-sm-12 col-md-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="basic-datatable_paginate">
                                    <ul class="pagination pagination-rounded mb-0">
                                        @php 
                                        $previous = '';
                                        if($arResults['PAGE'] == 1) {
                                            $previous = 'disabled';
                                        }
                                        @endphp
                                        <li class="paginate_button page-item previous {{ $previous }}" id="basic-datatable_previous">
                                            <a href="{{ route('august.lists.index', ['id_block' => $arParams['ABLOCK_ID'], 'page' => ($arResults['PAGE'] - 1) ]) }}" aria-controls="basic-datatable" data-dt-idx="0" tabindex="0" class="page-link">
                                                <i class="mdi mdi-chevron-left"></i>
                                            </a>
                                        </li>
                                        @php
                                        $min = $arResults['PAGE'] - 2;

                                        if ($min < 1) {
                                            $min = 1;
                                        }

                                        $max = $min + 4;

                                        if ($max > $arResults['TOTAL_PAGES']) {
                                            $max = $arResults['TOTAL_PAGES'];
                                        }

                                        for ($i = $min; $i <= $max; $i++) {
                                            $active = '';
                                            if ($arResults['PAGE'] == $i) {
                                                $active = 'active';
                                            }
                                            @endphp
                                            <li class="paginate_button page-item {{ $active }}">
                                                <a href="{{ route('august.lists.index', ['id_block' => $arParams['ABLOCK_ID'], 'page' => $i]) }}" aria-controls="basic-datatable" data-dt-idx="1" tabindex="0" class="page-link">
                                                    {{ $i }}
                                                </a>
                                            </li>
                                            @php 
                                        }
                                         
                                        $next = '';
                                        if($arResults['PAGE'] == $arResults['TOTAL_PAGES']) {
                                            $next = 'disabled';
                                        }
                                        @endphp
                                        <li class="paginate_button page-item next {{ $next }}" id="basic-datatable_next">
                                            <a href="{{ route('august.lists.index', ['id_block' => $arParams['ABLOCK_ID'], 'page' => ($arResults['PAGE'] + 1) ]) }}" aria-controls="basic-datatable" data-dt-idx="7" tabindex="0" class="page-link">
                                                <i class="mdi mdi-chevron-right"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle border-0">
                            <div class="d-flex justify-content-end align-items-center gap-2">
                                <span>{{ trans('August::list.limit_option') }}:</span>
                                <select class="form-select fit-content limit-option" aria-label="5">
                                    @php
                                    foreach ($arResults['LIMIT_OPTION'] as $val) {
                                        if ($arResults['LIMIT_SELECTED'] == $val) {
                                            $selected = 'selected';
                                        } else {
                                            $selected = '';
                                        }
                                        @endphp
                                        <option {{ $selected }} value="{{ $val }}">{{ $val }}</option>
                                        @php
                                    }
                                    @endphp
                                </select>
                            </div>
                        </td>
                    </tr>
                </table><!-- table pagination -->
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div><!-- end row-->

<div class="modal fade" id="centermodal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form class="august-search" action="{{ route('august.lists.view_mode') }}" method="post">
                @csrf
                <input type="hidden" name="ablock_id" value="{{ $arResults['BLOCK']->id }}">
                <div class="modal-header">
                    <h4 class="modal-title" id="myCenterModalLabel">{{ trans('August::list.view_mode') }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-wrap gap-1">
                        @php
                        foreach ($arResults['COLUMNS'] as $key => $column) {
                            if ($arResults['USER_FIELD'][$key]['show_in_list'] == 'N') {
                                $check = '';
                            } else {
                                $check = 'checked';
                            }
                            @endphp
                            <div class="form-check col-3">
                                <input class="form-check-input" {{ $check }} type="checkbox" value="Y" id="{{ $column }}" name="view[{{ $key }}]">
                                <label class="form-check-label" for="{{ $column }}">
                                    {{ $column }}
                                </label>
                            </div>
                            @php
                        }
                        @endphp
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div id="confirm-delete-modal" class="modal fade" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-top">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="topModalLabel">{{ trans('August::messages.confirm_delete') }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>{{ trans('August::element.confirm_delete') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ trans('August::ablock.btn_cancel') }}</button>
                <a type="button" class="btn btn-primary btn-delete" href="">{{ trans('August::messages.delete') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection


@push('js')
<script>
    (function ($) {
        $(document).on("click", ".item-delete", function() {
            let url = $(this).attr('data-item-url');
            $("#confirm-delete-modal .btn-delete").attr('href', url);
        });

        $(document).on("click", ".select-all", function() {
            if ($(this).is(":checked")) {
                $(".item-select").prop("checked", true);
                let limit = $(".limit-option").val();
                $(".ckecked-total").text(limit + "/" + limit);
            } else {
                $(".item-select").prop("checked", false);
                let limit = $(".limit-option").val();
                $(".ckecked-total").text("0/" + limit);
            }
        });

        $(document).on("change", ".limit-option", function() {
            location.href = "{{ route('august.lists.index', ['id_block' => $arParams['ABLOCK_ID']]) }}?limit=" + $(this).val();
        });
    })(jQuery)
</script>
@endpush