@extends('August::layouts.app')
@section('page-title')
    {{ trans('August::file.list') }}
@endsection
@section('content')

<div class="d-flex mb-2 justify-content-end">
    <a href="{{ route('august.file.add') }}" class="btn btn-primary">{{ trans('August::file.add_new') }}</a>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body overflow-auto">
                <table class="table dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th><input class="form-check-input" type="checkbox"></th>
                            <th><i class="fe-settings"></i></th>
                            <th class="w-25">{{ trans('August::file.name') }}</th>
                            <th>{{ trans('August::file.path') }}</th>
                            <th>{{ trans('August::file.extension') }}</th>
                            <th>{{ trans('August::file.author') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($arResults['ITEMS'] as $item)
                        <tr>
                            <td><input class="form-check-input" type="checkbox"></td>
                            <td>
                                <div class="btn-group dropdown">
                                    <a href="#" class="dropdown-toggle arrow-none" data-bs-toggle="dropdown" aria-expanded="false"><i class="fe-align-justify"></i></a>
                                    <div class="dropdown-menu dropdown-menu-start" style="">
                                        <a class="dropdown-item" href="{{ route('august.file.edit', ['id_file' => $item->id]) }}"><i class="mdi mdi-pencil me-2 text-muted font-18 vertical-middle"></i>{{ trans('August::messages.edit') }}</a>

                                        <a class="dropdown-item item-delete" data-item-url="{{ route('august.file.delete', ['id_file' => $item->id]) }}" data-bs-toggle="modal" data-bs-target="#confirm-delete-modal" href="#">
                                            <i class="mdi mdi-delete me-2 text-muted font-18 vertical-middle"></i>
                                            {{ trans('August::messages.delete') }}
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($item->is_image)
                                <img class="img-thumbnail img-fluid" src="{{ asset('storage/'. $item->path) }}"/>
                                <br>
                                @endif
                                {{ $item->name }}
                            </td>
                            <td>{{ $item->path }}</td>
                            <td>{{ $item->extension }}</td>
                            <td>{{ $item->author }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> <!-- end card body-->
        </div> <!-- end card -->
        <div class="card">
            <div class="card-body pt-0 pb-0 overflow-auto">
                <table class="table dt-responsive nowrap w-100 mb-0">
                    <tr class="border-0">
                        <td class="align-middle border-0">Đã chọn: 1/10</td>
                        <td class="align-middle border-0">Toàn bộ: {{ $arResults['TOTAL_ITEMS'] }}</td>
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
                                            <a href="{{ route('august.file.index', ['page' => ($arResults['PAGE'] - 1) ]) }}" aria-controls="basic-datatable" data-dt-idx="0" tabindex="0" class="page-link">
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
                                                <a href="{{ route('august.file.index', ['page' => $i]) }}" aria-controls="basic-datatable" data-dt-idx="1" tabindex="0" class="page-link">
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
                                            <a href="{{ route('august.file.index', ['page' => ($arResults['PAGE'] + 1) ]) }}" aria-controls="basic-datatable" data-dt-idx="7" tabindex="0" class="page-link">
                                                <i class="mdi mdi-chevron-right"></i>
                                            </a>
                                        </li>
                                    </ul>
                                    
                                </div>
                            </div>
                        </td>
                        <td class="align-middle border-0">
                            <div class="d-flex justify-content-end align-items-center gap-2">
                                <span>Các bản ghi:</span>
                                <select class="form-select fit-content" aria-label="5">
                                    <option selected value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                    <option value="200">200</option>
                                    <option value="400">400</option>
                                    <option value="500">500</option>
                                </select>
                            </div>
                        </td>
                    </tr>
                </table><!-- table pagination -->
            </div> <!-- end card body-->
        </div>
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
                <p>{{ trans('August::file.confirm_delete') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ trans('August::file.btn_cancel') }}</button>
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
