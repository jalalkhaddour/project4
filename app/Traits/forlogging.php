<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

trait forlogging
{
    static protected $logTable = 'logs';

    static function logToDb($model, $logType)
    {
        date_default_timezone_set('EET');
        if (!auth()->check() || $model->excludeLogging || !config('userActions.activated', true)) return;
        if ($logType == 'create') {
            $originalData = json_encode($model);
            $newData22 = json_encode($model);
        }
        else {
            if (version_compare(app()->version(), '7.0.0', '>=')){
                $newData22 = json_encode($model);
            $originalData = json_encode($model->getRawOriginal());}

            else{
            $newData22 = json_encode($model);
            $originalData = json_encode($model->getRawOriginal());}
        }
        date_default_timezone_set('EET');
        $created_at=date('Y-m-d H:i:s',strtotime(json_decode($originalData)->created_at));
        $updated_at=date('Y-m-d H:i:s',strtotime(json_decode($newData22)->updated_at));
        $tableName = $model->getTable();
        $dateTime = date('Y-m-d H:i:s');
        $userId = auth()->user()->id;
        $newdata='';
        $JsonData=json_decode($originalData);
        $JsonNewData=json_decode($newData22);
        $userIIII='';
        if($logType == 'create'){
            $newdata='';
            foreach ($JsonNewData as $key1=>$newvalue){
                if($key1!='password' and $key1!='created_at' and $key1!='updated_at'){

                    $newdata=" |".$key1.": ".$newvalue.$newdata;
                }else{
                    if($key1=='updated_at')
                        $newdata="|".$newvalue.": وقت الإنشاء| ".$newdata;
                }
            }
        }else{
        foreach ($JsonData as $key=>$value) {
            if( $key=='password'){
                $usernnn=User::findOrFail($userIIII);
                $newpass=$usernnn->password;
                if($newpass!=$value)
                    $newdata="| !!! password Changed !!! | ".$newdata;}
            foreach ($JsonNewData as $key1=>$newvalue){
                if($key=='id' and $key1=='id'){$userIIII=$value;
                    $newdata=$newdata.'| '.$value.': id  التغيير في الحقل ذو الـ ';}

            if($key==$key1 and $newvalue!=$value){
            if($key!='password' and $key!='created_at' and $key!='updated_at'){

            $newdata=" |old ".$key.": ".$value." =>new ".$key.": ".$newvalue.$newdata;
            }else{
                if($key1=='updated_at')
                    $newdata="|".$newvalue.": وقت التعديل| ".$newdata;
            }
            }
        }}}

        DB::table(self::$logTable)->insert([
            'userID'    => $userId,
            'log_date'   => $dateTime,
            'table_name' => $tableName,
            'log_type'   => $logType,
            'data'       => $newdata,
            'created_at' =>$created_at,
            'updated_at' =>$updated_at

        ]);
    }

    public static function bootforlogging()
    {
        if (config('userActions.log_events.on_edit', false)) {
            self::updated(function ($model) {
                self::logToDb($model, 'edit');
            });
        }


        if (config('userActions.log_events.on_delete', false)) {
            self::deleted(function ($model) {
                self::logToDb($model, 'delete');
            });
        }


        if (config('userActions.log_events.on_create', false)) {
            self::created(function ($model) {
                self::logToDb($model, 'create');
            });
        }
    }
}
