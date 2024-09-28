@extends('August::layouts.app')
@section('page-title')

@endsection

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card mb-1">
            <div class="card-body">
                <div class="mb-2">
                    {{ trans('August::ablock.not_found') }}
                </div>
                <div class="mb-2">
                    <a href="{{ route('august.ablock.index') }}" class="btn btn-secondary">{{ trans('August::ablock.back_to_list') }}</a>
                </div>
            </div>
        </div>
    </div><!-- end col-->
</div><!-- end row-->
@endsection