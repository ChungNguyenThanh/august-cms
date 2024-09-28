@php
if (isset($arResults['USERS']) && !empty($arResults['USERS'])) {
    foreach($arResults['USERS'] as $user) {
        if(isset($user->photo) && !empty($user->photo)) {
            $path = asset('storage/'.$user->photo);
        } else {
            $path = asset('/assets-august/images/users/default.png');
        }
        @endphp
        <div class="d-flex u-item" onclick="chooseUser('<?php echo $user->name; ?>', '<?php echo $user->id; ?>', '<?php echo $arResults["FIELD_NAME"]?>');">
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