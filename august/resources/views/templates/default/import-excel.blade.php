@extends('August::layouts.app')
@section('page-title')
Import Excel
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal" role="form" action="{{ route('august.lists.importexcel', ['id_block' => $arResults['BLOCK_ID']])}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-2 row">
                        <label class="col-md-3 col-form-label text-end mobile-text-start" for="FILE">File</label>
                        <div class="col-md-9">
                            <input type="file" id="FILE" name="FILE[]" value="" class="form-control" multiple="" accept=".xlsx">
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-md-3 col-form-label text-end mobile-text-start" for="FILE">Tải File mẫu</label>
                        <div class="col-md-9 align-items-center d-flex">
                            <a href="">{{ $arResults['TABLE_NAME'] }}.xlsx</a>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary me-2" name="btn_action" value="save">Upload</button>
                        <button type="button" class="btn btn-secondary">Thoát</button>
                    </div>
                </form>
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div><!-- end col -->
</div>
<!-- end row -->
@endsection

@push('js')

@endpush