@php
use Package\August\Http\Controllers\UtilityController;
@endphp

@push('css')
<link href="/assets-august/css/widgets/august-file.css" rel="stylesheet" type="text/css" />
@endpush

<input type="hidden" value="{{ route('august.file.field.delete') }}" name="route">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
@csrf
@php

$path = $_SERVER['DOCUMENT_ROOT'].'/packages/august/resources/assets-august/images/file-icons';
$arIcon = UtilityController::getListFile($path);

if (isset($view) && ($view == 'list')) {
	$fieldValue = '';
	if (isset($value)) {
		$fieldValue = $value;
	}

	if (!empty($fieldValue)) {
		if ($userField['multiple'] == 'Y') {
			foreach ($fieldValue as $value) {
				if ($value == null) {
					continue;
				}

				if ($value['is_image']) {
					@endphp
					<img class="img-thumbnail img-fluid w-100 h-100 object-fit-contain" src="{{ asset('storage/'. $value['path']) }}"/>
					@php
				} else {
					@endphp 
					<p>{{ $value['name'] }}</p>
					@php
				}
			}
		} else {
			if ($fieldValue['is_image']) {
				@endphp
				<img class="img-thumbnail img-fluid w-25" src="{{ asset('storage/'. $fieldValue['path']) }}"/>
				<br>
				@php
			}
			echo $fieldValue['name'];
		}
	}
} else {
	$fieldValue = '';
	if (isset($value)) {
		$fieldValue = $value;
	}

	if ($userField['multiple'] == 'Y') {
		if($fieldValue) {
			@endphp
			<div class="d-flex flex-wrap mb-2">
			@php
			foreach ($fieldValue as $value) {
				if ($value == null) {
					continue;
				}

				if ($value['is_image']) {
					@endphp
					<div class="position-relative d-inline-flex flex-column gap-10 w-25 p-2">
						<img class="img-thumbnail img-fluid w-100 h-100 object-fit-contain" src="{{ asset('storage/'. $value['path']) }}"/>
						<a href="{{ asset('storage/'. $value['path']) }}" target="_blank" class="">{{ $value['name'] }}</a>
						<button type="button" onclick="removeImage('{{ $value['id'] }}', '{{ $value['field_name'] }}', '{{ $value['ablock_id'] }}', '{{ $userField['multiple'] }}',this)" class="btn-reamove-file btn btn-danger btn-sm position-absolute top-1 end-1 translate-middle badge rounded-circle" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<input type="hidden" name="{{ $userField['field_name'] }}_old[]" value="{{ $value['id'] }}" class="form-control">
					</div>
					@php
				} else {
					if (in_array($value['extension'].'.svg', $arIcon)) {
						$iconFile = "/assets-august/images/file-icons/".$value['extension'].'.svg';
					} else {
						$iconFile = "/assets-august/images/file-icons/default.svg";
					}

					@endphp
					<div class="position-relative d-inline-flex flex-column gap-10 w-25 p-2">
						<img class="img-thumbnail img-fluid w-100 h-100 object-fit-contain" src="{{ $iconFile }}"/>
						<a href="{{ asset('storage/'. $value['path']) }}" target="_blank" class="">{{ $value['name'] }}</a>
						<button type="button" onclick="removeImage('{{ $value['id'] }}', '{{ $value['field_name'] }}', '{{ $value['ablock_id'] }}', '{{ $userField['multiple'] }}',this)" class="btn-reamove-file btn btn-danger btn-sm position-absolute top-1 end-1 translate-middle badge rounded-circle" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<input type="hidden" name="{{ $userField['field_name'] }}_old[]" value="{{ $value['id'] }}" class="form-control">
					</div>
					@php
				}
			}
			@endphp 
			</div>
			@php
		}
		@endphp
		<input type="file" id="{{ $userField['field_name'] }}" name="{{ $userField['field_name'] }}[]" value="" class="form-control" multiple>
		@php
	} else {
		if ($fieldValue) {
			if ($fieldValue['is_image']) {
				@endphp
				<div class="position-relative d-inline-block w-25 -2 mb-2">
					<img class="img-thumbnail img-fluid w-100 h-100 object-fit-contain" src="{{ asset('storage/'. $value['path']) }}"/>
					<a href="{{ asset('storage/'. $value['path']) }}" target="_blank" class="">{{ $fieldValue['name'] }}</a>
					<button type="button" onclick="removeImage('{{ $fieldValue['id'] }}', '{{ $fieldValue['field_name'] }}', '{{ $fieldValue['ablock_id'] }}', '{{ $userField['multiple'] }}',this)" class="btn-reamove-file btn-reamove-file btn btn-danger btn-sm position-absolute top-1 end-1 translate-middle badge rounded-circle" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<input type="hidden" name="{{ $userField['field_name'] }}_old" value="{{ $fieldValue['id'] }}" class="form-control">
				</div>
				@php
			} else {
				if (in_array($fieldValue['extension'].'.svg', $arIcon)) {
					$iconFile = "/assets-august/images/file-icons/".$fieldValue['extension'].'.svg';
				} else {
					$iconFile = "/assets-august/images/file-icons/default.svg";
				}
				@endphp
				<div class="position-relative d-inline-block w-25 -2 mb-2">
					<img class="img-thumbnail img-fluid w-100 h-100 object-fit-contain" src="{{ $iconFile }}"/>
					<a href="{{ asset('storage/'. $value['path']) }}" target="_blank" class="">{{ $fieldValue['name'] }}</a>
					<button type="button" onclick="removeImage('{{ $fieldValue['id'] }}', '{{ $fieldValue['field_name'] }}', '{{ $fieldValue['ablock_id'] }}', '{{ $userField['multiple'] }}',this)" class="btn-reamove-file btn-reamove-file btn btn-danger btn-sm position-absolute top-1 end-1 translate-middle badge rounded-circle" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<input type="hidden" name="{{ $userField['field_name'] }}_old" value="{{ $fieldValue['id'] }}" class="form-control">
				</div>
				@php
			}
		}
		@endphp
		<input type="file" id="{{ $userField['field_name'] }}" name="{{ $userField['field_name'] }}" value="" class="form-control">
		@php
	}
}
@endphp

@push('js')
<script src="/assets-august/js/widgets/august-file.js"></script>
@endpush