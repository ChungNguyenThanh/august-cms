@push('css')
    <link href="/assets-august/css/widgets/permission.css" rel="stylesheet" type="text/css" />
@endpush

<div id="access_modal" class="access-modal modal fade" tabindex="-1" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-big-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Danh sách người dùng</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-between">
                    <div class="find-by flex-grow-3 p-2 ps-0">
                        <div class="item-by active p-1 ps-2 pe-2" item-id="list-user">Người dùng</div>
                        <div class="item-by p-1 ps-2 pe-2" item-id="list-role">Nhóm</div>
                    </div>

                    <div class="flex-grow-1 p-2 border border-top-0 border-bottom-0">
                        <div class="form-search-user mb-4">
                            <input type="text" class="form-control" name="search-user">
                        </div>
                        <div class="d-flex align-items-center gap-2 flex-wrap list-user">
                            @php
                            if (isset($arUser) && !empty($arUser)) {
                                foreach($arUser as $user) {
                                    if(isset($user->photo) && !empty($user->photo)) {
                                        $path = asset('storage/'.$user->photo);
                                    } else {
                                        $path = asset('/assets-august/images/users/default.png');
                                    }
                                    @endphp
                                    <div class="d-flex align-items-center gap-1 u-item p-1 choose-user">
                                        <input type="hidden" name="u-name" class="u-id" value="{{ $user->id }}">
                                        <img class="u-avatar img-fluid avatar-sm rounded-circle" src="{{ $path }}">
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

                        <div class="d-none align-items-center gap-2 flex-wrap list-role">
                            @php
                            if (isset($arRole) && !empty($arRole)) {
                                foreach($arRole as $role) {
                                    $path = asset('/assets-august/images/users/user-role.png');
                                    @endphp
                                    <div class="d-flex align-items-center gap-1 g-item p-1 choose-group">
                                        <input type="hidden" name="g-name" class="g-id" value="{{ $role->id }}">
                                        <img class="g-avatar img-fluid avatar-sm rounded-circle" src="{{ $path }}">
                                        <div class="g-name-title">
                                            <div class="g-name">{{ $role->name }}</div>
                                        </div>
                                    </div>
                                    @php
                                }
                            }
                            @endphp
                        </div>
                    </div>
                    <input type="hidden" name="list-choosed" value="">
                    <div class="list-choose-user p-2">
                        
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <span class="btn btn-primary btn-choose-access">Lựa chọn</span>
                <span class="btn btn-secondary ms-1" data-bs-dismiss="modal" aria-label="Close">Thoát</span>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        var selectTask = '';
        @php
        foreach ($arTask as $kTask => $vTask) {
            @endphp
            selectTask += '<option value="{{ $kTask }}">{{ $vTask }}</option>';
            @php
        }
        @endphp
    </script>
    <script src="/assets-august/js/widgets/permission.js"></script>
@endpush