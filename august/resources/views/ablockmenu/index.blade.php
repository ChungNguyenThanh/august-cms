@extends('August::layouts.app')
@section('page-title')
    {{ trans('August::menu.list') }}
@endsection
@section('content')

<div class="d-flex mb-2 justify-content-between gap-2 mobile-flex-wrap">
    <div class="d-flex mb-2 justify-content-start gap-2 mobile-flex-wrap">
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="group-btn-action" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Group menu <i class="mdi mdi-chevron-down"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="group-btn-action" style="">
                @php
                foreach ($arResults['GROUP'] as $key => $value) {
                    @endphp
                    <a class="dropdown-item" href="{{ route('august.menu.index')}}?groupmenu={{ $value->code }}">{{ $value->name }}</a>
                    @php
                }
                @endphp
            </div>
        </div>
    </div>
    <div class="d-flex mb-2 justify-content-end gap-2 mobile-flex-wrap w-50">
        <a href="{{ route('august.menugroup.add') }}" class="btn btn-secondary me-1">{{ trans('August::menu.add_new_group') }}</a>
        <a href="{{ route('august.menu.add') }}" class="btn btn-primary">{{ trans('August::menu.add_new') }}</a>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table class="table dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th><input class="form-check-input" type="checkbox"></th>
                            <th><i class="fe-settings"></i></th>
                            <th>{{ trans('August::menu.menu_title') }}</th>
                            <th>{{ trans('August::menu.parent_item_menu') }}</th>
                            <th>{{ trans('August::menu.menu_link') }}</th>
                            <th>{{ trans('August::menu.menu_group') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                        $parent_item = [];
                        foreach($arResults['ITEMS'] as $parent) {
                            $parent_item[$parent->id] = $parent->item_code;
                        }
                        @endphp
                        @foreach($arResults['ITEMS'] as $item)
                        <tr>
                            <td><input class="form-check-input" type="checkbox"></td>
                            <td>
                                <div class="btn-group dropdown">
                                    <a href="#" class="dropdown-toggle arrow-none" data-bs-toggle="dropdown" aria-expanded="false"><i class="fe-align-justify"></i></a>
                                    <div class="dropdown-menu dropdown-menu-start" style="">
                                        <a class="dropdown-item" href="{{ route('august.menu.edit', ['id_menu' => $item->id]) }}"><i class="mdi mdi-pencil me-2 text-muted font-18 vertical-middle"></i>{{ trans('August::messages.edit') }}</a>
                                        <a class="dropdown-item" href="{{ route('august.menu.copy', ['id_menu' => $item->id]) }}"><i class="mdi mdi-content-copy me-2 text-muted font-18 vertical-middle"></i>{{ trans('August::messages.coppy') }}</a>

                                        <a class="dropdown-item item-delete" data-item-url="{{ route('august.menu.delete', ['id_menu' => $item->id]) }}" data-bs-toggle="modal" data-bs-target="#confirm-delete-modal" href="#">
                                            <i class="mdi mdi-delete me-2 text-muted font-18 vertical-middle"></i>
                                            {{ trans('August::messages.delete') }}
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $item->menu_title }}</td>
                            @php 
                            if ($item->parent_item_menu == 0) {
                                $parent_item_menu = '';
                            } else {
                                $parent_item_menu = $parent_item[$item->parent_item_menu];
                            }
                            @endphp
                            <td>{{ $parent_item_menu }}</td>
                            <td>{{ $item->menu_link }}</td>
                            <td>{{ $item->name_group }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
<!-- end row-->

<div id="confirm-delete-modal" class="modal fade" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-top">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="topModalLabel">Xác nhận xoá</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>{{ trans('August::menu.confirm_delete') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ trans('August::menu.btn_cancel') }}</button>
                <a type="button" class="btn btn-primary btn-delete" href="#">{{ trans('August::messages.delete') }}</a>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
@endsection

@push('js')
<script>
    (function ($) {
        $(document).on("click", ".item-delete", function() {
            let url = $(this).attr('data-item-url');
            $("#confirm-delete-modal .btn-delete").attr('href', url);
        });
    })(jQuery)
</script>
@endpush
