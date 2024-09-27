@extends('August::layouts.app')
@section('page-title')
{{ trans('August::userfieldtype.list') }}
@endsection
@section('content')


<div class="d-flex mb-2 justify-content-end">
    <a href="{{ route('august.userfieldtype.add') }}" class="btn btn-primary">{{ trans('August::userfieldtype.add_new') }}</a>
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
                            <th>{{ trans('August::userfieldtype.code') }}</th>
                            <th>{{ trans('August::userfieldtype.user_field_type') }}</th>
                            <th>{{ trans('August::userfieldtype.db_type') }}</th>
                            <th>{{ trans('August::userfieldtype.accessori_type') }}</th>
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
                                        <a class="dropdown-item" href="{{ route('august.userfieldtype.edit', ['id_fieldtype' => $item->id]) }}"><i class="mdi mdi-pencil me-2 text-muted font-18 vertical-middle"></i>{{ trans('August::messages.edit') }}</a>
                                        <a class="dropdown-item" href="{{ route('august.userfieldtype.copy', ['id_fieldtype' => $item->id]) }}"><i class="mdi mdi-content-copy me-2 text-muted font-18 vertical-middle"></i>{{ trans('August::messages.coppy') }}</a>

                                        <a class="dropdown-item item-delete" data-item-url="{{ route('august.userfieldtype.delete', ['id_fieldtype' => $item->id]) }}" data-bs-toggle="modal" data-bs-target="#confirm-delete-modal" href="#"><i class="mdi mdi-delete me-2 text-muted font-18 vertical-middle"></i>{{ trans('August::messages.delete') }}</a>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $item->code }}</td>
                            <td>{{ $item->user_field_type }}</td>
                            <td>{{ $item->db_type }}</td>
                            <td>{{ $item->accessori_type }}</td>
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
                <p>{{ trans('August::userfieldtype.confirm_delete') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ trans('August::userfieldtype.btn_cancel') }}</button>
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