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
                <?php
                $arRes = array();
                $typeEvenue = array();

                foreach ($arResults['ITEMS'][0]["TYPE"]["list_enum"] as $key => $value) {
                    $typeEvenue[$value["id"]] = $key;
                }

                foreach ($arResults['ITEMS'] as $key => $value) {
                    $type = $typeEvenue[$value["TYPE"]["value"]];
                    $month = intval(date("m", strtotime($value["ENTRY_DATE"]["value"])));
                    $total = $value["TOTAL"]["value"];

                    if (!isset($arRes[$type])) {
                        $arRes[$type] = array();
                    }

                    if (!isset($arRes[$type][$month])) {
                        $arRes[$type][$month] = 0;
                    }

                    $arRes[$type][$month] += $total;
                }

                for ($i=1; $i <=12 ; $i++) { 
                    if (!isset($arRes["revenue"][$i])) {
                        $arRes["revenue"][$i] = 0;
                    }

                    if (!isset($arRes["expense"][$i])) {
                        $arRes["expense"][$i] = 0;
                    }
                }

                ksort($arRes["revenue"]);
                ksort($arRes["expense"]);
                ?>

                <canvas id="revenue_report" width="2882" height="1441" style="display: block; box-sizing: border-box; height: 720px; width: 1441px;"></canvas>
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

@endsection


@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js"></script>


<script>
    var revenues = [];
    <?php
    foreach ($arRes["revenue"] as $key => $value) {
        ?>
        revenues.push(parseInt(<?php echo $value?>));
        <?php
    }
    ?>

    var expenses = [];
    <?php
    foreach ($arRes["expense"] as $key => $value) {
        ?>
        expenses.push(parseInt(<?php echo $value?>) * -1);
        <?php
    }
    ?>

    const data = {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        datasets: [{
            label: 'Revenues',
            data: revenues,
            backgroundColor: ['#3bafda'],
            borderWidth: 1
        },
        {
            label: 'Expenses',
            data: expenses,
            backgroundColor: ['#f1556c'],
            borderWidth: 1
        }]
    };

    const config = {
        type: 'bar',
        data,
        options: {
            scales: {
                x:{
                    stacked: true
                },
                y: {
                    beginAtZero: true,
                    stacked: true
                }
            }
        }
    };

    const revenue_report = new Chart(document.getElementById('revenue_report'), config);
</script>

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
            location.href = "{{ route('august.lists.index', ['id_block' => $arParams['ABLOCK_ID']]) }}?template=August::templates.revenue.index&limit=" + $(this).val();
        });
    })(jQuery)
</script>
@endpush