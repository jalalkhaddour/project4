<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Auth\Events\Logout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LockoutListener
{

    private $userInstance = "\App\User";

    public function __construct(Request $request)
    {
        $this->request = $request;
        //$userInstance=Auth::user();
        $userInstance = User::class;
        if(!empty($userInstance)) $this->userInstance = $userInstance;
    }


    public function handle($event)
    {
        if (!config('userActions.log_events.on_lockout', false)
            || !config('userActions.activated', true)) return;

        if (!$event->request->has('username')) return response()->json('the username property not found',207);
        $user = $this->userInstance::where('username', $event->request->input('username'))->first();
        if (!$user) return;


        $data = [
            'ip'         => $this->request->ip(),
            'user_agent' => $this->request->userAgent()
        ];

        $created_at=date('Y-m-d H:i:s');

        $updated_at=date('Y-m-d H:i:s');
        DB::table('logs')->insert([
            'userID'    => $user->id,
            'log_date'   => date('Y-m-d H:i:s'),
            'table_name' => '',
            'log_type'   => 'logout',
            'data'       => json_encode($data),
            'created_at'=>$created_at,
            'updated_at'=>$updated_at
        ]);

    }
}
