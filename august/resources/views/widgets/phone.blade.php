@php
if (isset($view) && ($view == 'list')) {
	$fieldValue = '';
	if (isset($value)) {
		$fieldValue = "<a href='tel:".$value."'>".$value."</a>";
	}

	if ($userField['multiple'] == 'Y') {
		if (is_array($fieldValue)) {
			foreach ($fieldValue as $val) {
				echo "<a href='tel:".$val."'>".$val."</a><br>";
			}
		}
	} else {
		echo $fieldValue;
	}
} elseif (isset($value)) {
	$fieldValue = '';
	if (isset($value)) {
		$fieldValue = $value;
	}

	if ($userField['multiple'] == 'Y') {
		if (is_array($fieldValue)) {
			foreach ($fieldValue as $val) {
				@endphp
				<div class="d-flex gap-1 mb-1">
					<input type="number" id="{{ $userField['field_name'] }}" name="{{ $userField['field_name'] }}[]" value="{{ $val }}" class="form-control">
					<span class="btn btn-danger btn-delete-input-phone">Xoá</span>
				</div>
				@php
			}
		}
		@endphp
		<span class="btn btn-success btn-add-input-phone" item-field-name="{{ $userField['field_name'] }}">Thêm</span>
		@php
	} else {
		@endphp
		<input type="number" id="{{ $userField['field_name'] }}" name="{{ $userField['field_name'] }}" value="{{ $fieldValue }}" class="form-control">
		@php
	}
}
@endphp

@push('js')
<script src="/assets-august/js/widgets/august-phone.js"></script>
@endpush
