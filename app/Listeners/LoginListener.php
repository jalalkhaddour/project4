<?php

namespace App\Listeners;

use Facade\FlareClient\Time\Time;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginListener
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function handle(Login $event)
    {
        if (!config('userActions.log_events.on_login', false)
            || !config('userActions.activated', true)) return;

        $user = $event->user;
        $dateTime = date('Y-m-d H:i:s');
        date_default_timezone_set('EET');
        $created_at=date('Y-m-d H:i:s');
        $updated_at=date('Y-m-d H:i:s');
        $data = [
            'ip'         => $this->request->ip(),
            'user_agent' => $this->request->userAgent()
        ];

        DB::table('logs')->insert([
            'userID'    => $user->id,
            'log_date'   => $dateTime,
            'table_name' => '',
            'log_type'   => 'login',
            'data'       => json_encode($data),
            'created_at'=>$created_at,
            'updated_at'=>$updated_at
        ]);
    }
}
