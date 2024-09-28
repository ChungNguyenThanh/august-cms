@php
$settingField = json_decode($userField['settings'], true);

if (!isset($settingField['unit_money'])) {
    $unit = 'VND';
} else {
	$unit = $settingField['unit_money'];
}

if (isset($view) && ($view == 'list')) {
	$fieldValue = '';
	if (isset($value)) {
		$fieldValue = $value;
	}

	if ($userField['multiple'] == 'Y') {
		if (is_array($fieldValue)) {
			foreach ($fieldValue as $val) {
				if (!empty($val)) {
					echo number_format($val, 2, ".", ",")." ".$unit."<br>";
				}
			}
		}
	} elseif (!empty($fieldValue)) {
		echo number_format($fieldValue, 2, ".", ",")." ".$unit;
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
		<div class="input-group input-group-merge">
			<input type="" id="{{ $userField['field_name'] }}" name="{{ $userField['field_name'] }}" value="{{ $fieldValue }}" class="form-control">
			<div class="input-group-text" data-password="false">
				<span class="">{{ $unit }}</span>
			</div>
		</div>
		@php
	}
}
@endphp

@push('js')
<script src="/assets-august/js/widgets/august-string.js"></script>
@endpush