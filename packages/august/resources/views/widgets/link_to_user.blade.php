@php
use Package\August\Http\Controllers\UtilityController;
@endphp

@push('css')
	<link href="/assets-august/css/widgets/link-to-user.css" rel="stylesheet" type="text/css" />
@endpush

@php
if (isset($view) && ($view == 'list')) {
	if (!empty($value)) {
		@endphp
		<a href="{{ route('august.users.edit', ['id_user' => $value['id']]) }}">{{ $value["name"] }} [{{ $value["id"] }}]</a>
		@php
	}
} else {
	@endphp
	<div class="form-control user-field" id="link_to_user_<?php echo $userField['field_name'] ?>">
		<span class="chooseuser" style="display: none"></span>
		@php
		if (isset($value) && !empty($value)) {
			$user_id = $value["id"];
			@endphp
			<span class="chooseuser" id="user_old" style="display: inline;"><span class="us-name">{{ $value["name"] }} <span class="remove-usn" onclick="removeUsName('{{ $value["id"] }}', '{{ $value["name"] }}', this)">x</span></span></span>
			@php
		} else {
			$user_id = '';
		}
		@endphp
		<input type="hidden" name="{{ $userField['field_name'] }}" value="{{ $user_id }}">
		<input type="hidden" name="route_{{ $userField['field_name'] }}" value="{{ route('august.search.users') }}" />
		<input type="hidden" name="_token" value="{{ csrf_token() }}">

		<span class="lua-chon" data-bs-toggle="modal" data-bs-target="#user-modal_<?php echo $userField['field_name'] ?>">+ Lựa chọn</span>
	</div>
	<div id="user-modal_<?php echo $userField['field_name'] ?>" class="user-modal modal fade" tabindex="-1" aria-labelledby="standard-modalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="standard-modalLabel">Danh sách người dùng</h4>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="form-search-user d-none">
						<input type="text" class="form-control" name="search-user" onkeyup="searchUser('<?php echo $userField['field_name']; ?>', this)">
						<hr>
					</div>
					<span>Mọi người:</span>
					<div class="d-flex justify-content-between mt-2">
						<div class="u-items" id="recently">
							@php
							if (isset($arUsers) && !empty($arUsers)) {
								foreach($arUsers as $user) {
									if(isset($user->photo) && !empty($user->photo)) {
										$path = asset('storage/'.$user->photo);
									} else {
										$path = asset('/assets-august/images/users/default.png');
									}
									@endphp
									<div class="d-flex u-item" onclick="chooseUser('<?php echo $user->name; ?>', '<?php echo $user->id; ?>', '<?php echo $userField['field_name']; ?>');">
										<img class="img-fluid avatar-sm rounded-circle" src="{{ $path }}">
										<div class="u-name-title">
											<div class="u-name">{{ $user->name }}</div>
											<div class="u-title">Chuyên viên</div>
										</div>
									</div>
									@php
								}
							}
							@endphp
						</div>

						<div class="u-items" id="group" style="display: none;">
							<div class="gr-items">
								<div class="title" item-id="gr_1" onclick="getUserGroup_TEST_USER('1');"><span>+</span>Admin1</div>
								<div class="gr-users" id="gr_1" style="display: none;">
								</div>
							</div>
							<div class="gr-items">
								<div class="title" item-id="gr_2" onclick="getUserGroup_TEST_USER('2');"><span>+</span>Quản trị bài viết</div>
								<div class="gr-users" id="gr_2" style="display: none;">
								</div>
							</div>
							<div class="gr-items">
								<div class="title" item-id="gr_3" onclick="getUserGroup_TEST_USER('3');"><span>+</span>Nhân viên</div>
								<div class="gr-users" id="gr_3" style="display: none;">
								</div>
							</div>
							<div class="gr-items">
								<div class="title" item-id="gr_4" onclick="getUserGroup_TEST_USER('4');"><span>+</span>Cộng Tác Viên</div>
								<div class="gr-users" id="gr_4" style="display: none;">
								</div>
							</div>
							<div class="gr-items">
								<div class="title" item-id="gr_5" onclick="getUserGroup_TEST_USER('5');"><span>+</span>Test1</div>
								<div class="gr-users" id="gr_5" style="display: none;">
								</div>
							</div>
						</div>

						<div class="u-items" id="search" style="display: none;">

						</div>
						<div class="find-by">
							<div class="active item-by" onclick="chooseBy('recently', '<?php echo $userField['field_name']; ?>', this)">Gần đây</div>
							<div class="item-by" onclick="chooseBy('group', '<?php echo $userField['field_name']; ?>', this)">Nhóm</div>
							<div class="item-by" onclick="chooseBy('search', '<?php echo $userField['field_name']; ?>', this)">Tìm kiếm</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@php
}
@endphp

@push('js')
	<script src="/assets-august/js/widgets/link-to-user.js"></script>
@endpush