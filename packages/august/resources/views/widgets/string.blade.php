@php
if (isset($view) && ($view == 'list')) {
	$fieldValue = '';
	if (isset($value)) {
		$fieldValue = $value;
	}

	if ($userField['multiple'] == 'Y') {
		if (is_array($fieldValue)) {
			foreach ($fieldValue as $val) {
				echo $val."<br>";
			}
		}
	} else {
		echo $fieldValue;
	}
} else {
	$fieldValue = '';
	if (isset($value)) {
		$fieldValue = $value;
	}

	if ($userField['multiple'] == 'Y') {
		if (is_array($fieldValue)) {
			foreach ($fieldValue as $val) {
				@endphp
				<div class="d-flex gap-1 mb-1">
					<input type="" id="{{ $userField['field_name'] }}" name="{{ $userField['field_name'] }}[]" value="{{ $val }}" class="form-control">
					<span class="btn btn-danger btn-delete-input-string">Xoá</span>
				</div>
				@php
			}
		}
		@endphp
		<span class="btn btn-success btn-add-input-string" item-field-name="{{ $userField['field_name'] }}">Thêm</span>
		@php
	} else {
		@endphp
		<input type="" id="{{ $userField['field_name'] }}" name="{{ $userField['field_name'] }}" value="{{ $fieldValue }}" class="form-control">
		@php
	}
}
@endphp

@push('js')
<script src="/assets-august/js/widgets/august-string.js"></script>
@endpush