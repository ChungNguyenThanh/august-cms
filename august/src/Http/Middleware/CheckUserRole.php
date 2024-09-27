<?php

namespace Package\August\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Package\August\Models\AExtendblockFile;
use Package\August\Models\AExtendblockUserMeta;
use Package\August\Models\AExtendblockUserRole;
use Package\August\Models\AExtendblockUserRoleRelation;
use Package\August\Models\AExtendblockUsers;

class CheckUserRole {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $userId = $request->route('id_user');

        $current_id = Auth::id();

        $relation = AExtendblockUserRoleRelation::where('user_id', $current_id)->first();

        if (!$relation) {
            return redirect('/');
        }

        $user_role = AExtendblockUserRole::where('id', $relation->role_id)->first();

        if ($user_role->code == 'administrator' || Auth::id() == $userId) {
            return $next($request);
        }else {
            return redirect()->route('august.users.preview', ['id_user' => $current_id]);
        }
    }
}
