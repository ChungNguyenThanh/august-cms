@extends('August::layouts.app')
@section('page-title')
{{ trans('August::ablock.list_table') }}
@endsection

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table class="table dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th><i class="fe-settings"></i></th>
                            <th>{{ trans('August::ablock.table_name') }}</th>
                            <th>{{ trans('August::ablock.ablock_name') }}</th>
                            <th>{{ trans('August::ablock.description') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($arParams['ITEMS'] as $table)
                        <tr>
                            <td>
                                <div class="btn-group dropdown">
                                    <a href="#" class="dropdown-toggle arrow-none" data-bs-toggle="dropdown" aria-expanded="false"><i class="fe-align-justify"></i></a>
                                    <div class="dropdown-menu dropdown-menu-start" style="">
                                        <a class="dropdown-item" href="{{ route('august.ablock.convert-to-ablock', ['table_name' => $table['table_name']]) }}"><i class="bx bx-link me-2 text-muted font-18 vertical-middle"></i>{{ trans('August::ablock.create_ablock') }}</a>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $table["table_name"] }}</td>
                            <td>{{ isset($table["name"]) ? $table["name"] : "" }}</td>
                            <td>{{ isset($table["description"]) ? $table["description"] : "" }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> <!-- end card body-->
        </div> <!-- end card -->
        <div class="card">
            <div class="card-body pt-0 pb-0">
                <table class="table dt-responsive nowrap w-100 mb-0">
                    <tr class="border-0">
                        <td class="align-middle border-0">Đã chọn: 1/10</td>
                        <td class="align-middle border-0">Toàn bộ: 100</td>
                        <td class="align-middle border-0">
                            <div class="col-sm-12 col-md-7 pt-2">
                                <div class="dataTables_paginate paging_simple_numbers" id="datatable-buttons_paginate">
                                    <ul class="pagination pagination-rounded">
                                        @php
                                        if($arParams['CURRENT_PAGE'] == 1) {
                                        $previous = 'disabled';
                                        } else {
                                        $previous = '';
                                        }
                                        @endphp
                                        <li class="paginate_button page-item previous {{ $previous }}" id="datatable-buttons_previous">
                                            <a href="{{ route('august.ablock.list-table-db', ['page' => ($arParams['CURRENT_PAGE'] - 1)]) }}" aria-controls="datatable-buttons" data-dt-idx="0" tabindex="0" class="page-link">
                                                <i class="mdi mdi-chevron-left"></i>
                                            </a>
                                        </li>
                                        @php
                                        for( $i = 1; $i <= $arParams['TOTAL_PAGES']; $i++ ) { if($arParams['CURRENT_PAGE']==$i) { $active='active' ; } else { $active='' ; } @endphp <li class="paginate_button page-item {{ $active }}">
                                            <a href="{{ route('august.ablock.list-table-db', ['page' => $i]) }}" aria-controls="datatable-buttons" data-dt-idx="1" tabindex="0" class="page-link">
                                                {{ $i }}
                                            </a>
                                            </li>
                                            @php
                                            }
                                            @endphp
                                            @php
                                            if($arParams['CURRENT_PAGE'] == $arParams['TOTAL_PAGES']) {
                                            $next = 'disabled';
                                            } else {
                                            $next = '';
                                            }
                                            @endphp
                                            <li class="paginate_button page-item next {{ $next }}" id="datatable-buttons_next">
                                                <a href="{{ route('august.ablock.list-table-db', ['page' => ($arParams['CURRENT_PAGE'] + 1)]) }}" aria-controls="datatable-buttons" data-dt-idx="7" tabindex="0" class="page-link">
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
                </table>
            </div>
        </div><!-- end col-->
    </div>
    <!-- end row-->

    @endsection