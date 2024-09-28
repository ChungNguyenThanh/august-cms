@php
use Package\August\Http\Controllers\UtilityController;
@endphp

@push('css')
<link href="/assets-august/css/widgets/link-to-user.css" rel="stylesheet" type="text/css" />
@endpush

@csrf
<input type="hidden" value="{{ route('august.ablock.getfields') }}" name="route">
<input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="form-control user-field" id="link_to_user_<?php echo $name ?>">
	<span class="chooseuser" style="display: none"></span>
	@php 
	if (isset($arParams['SETTINGS']) && !empty($arParams['SETTINGS']->$name)) {
		$ablock = UtilityController::getAblockById($arParams['SETTINGS']->{$name});
		$ablock_name = $ablock->name;
		$ablock_id = $ablock->id;
		@endphp
		<span class="chooseuser" id="ablock_old" style="display: inline;"><span class="us-name">{{ $ablock_name }} <span class="remove-usn" onclick="removeAblock('{{ $ablock_id }}', this)">x</span></span></span> 
		@php
	} else {
		$ablock_id = '';
	}
	@endphp
	<input type="hidden" name="settings[{{ $name }}]" value="{{ $ablock_id }}">

	<span class="lua-chon" data-bs-toggle="modal" data-bs-target="#user-modal_<?php echo $name ?>">+ Lựa chọn</span>
</div>
<div id="user-modal_<?php echo $name ?>" class="user-modal modal fade" tabindex="-1" aria-labelledby="standard-modalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="standard-modalLabel">Danh sách Ablock</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<input type="text" class="form-control" name="search-user" onkeyup="">
				<hr>
				<span>Tất cả ablock:</span>
				<div class="d-flex justify-content-between mt-2">
					<div class="u-items" id="recently">
						@foreach($arParams['ABLOCK'] as $ablock)
						<div class="d-flex u-item" onclick="chooseAblock('{{ $ablock->name }}', '{{ $ablock->id }}', '<?php echo $name; ?>');">
							<div class="u-name-title">
								<div class="u-name">{{ $ablock->name }}</div>
							</div>
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@push('js')
<script src="/assets-august/js/widgets/link-to-ablock.js"></script>
@endpush