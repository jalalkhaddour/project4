<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\role;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
class SetupPerRol extends Controller
{

    public  function setupRolesAndPER(){
        $this->setup_permissions();
        $this->setupRoles();
        $this->CreateAdmin();
    }
    public  function setup_permissions(){
        $routs=Route::getRoutes()->getRoutes();

        foreach ($routs as $rout) {
            $name=$rout->getAction();
            if(array_key_exists('controller',$name)){
                $vv=explode('@',$name['controller']);
                if(array_key_exists(1,$vv)){
                    $namev=$vv[1];

                    $permission= Permission::query()->create([
                        'name'=>$namev,
                    ]);}}
        }
        dump("DONE FINDING PERMISSIONS ✔ ✔");
    }
    public static function setupRoles(){


        $allperms=Permission::all();

        $Role1=role::where(['name'=>'Admin'])->first();
        if(!$Role1) {
            $Role1=role::create(['name'=>'Admin']); }
        foreach ($allperms as $allperm) {
            //  $Role1_ID=role::getRoleID('Admin');
            // $Role1 =role::findOrFail($Role1_ID);

            $Role1->permissions()->attach($allperm->id);
        }
        $Role2=role::where(['name'=>'AfAdmin'])->first();
        if(!$Role2)
            $Role2=role::create(['name'=>'AfAdmin']);
        foreach ($allperms as $allperm) {
            $Role2_ID = role::getRoleID( 'AfAdmin');
            $Role2=role::find($Role2_ID);
            $cont=Str::contains($allperm,'user');
            if(!$cont)
                $Role2->permissions()->attach($allperm->id);
        }

        $Role3=role::where(['name'=>'ExAdmin'])->first();
        if(!$Role3)
            $Role3=role::create(['name'=>'ExAdmin']);
        foreach ($allperms as $allperm) {
            $Role3_ID = role::getRoleID( 'ExAdmin');
            $Role3=role::find($Role3_ID);

            $cont=Str::contains($allperm,'user');
            if(!$cont)
                $Role3->permissions()->attach($allperm->id);
        }
        $Role4=role::where(['name'=>'Af'])->first();
        if(!$Role4)
            $Role4=role::create(['name'=>'Af']);
        foreach ($allperms as $allperm) {
            $Role4_ID = role::getRoleID( 'Af');
            $Role4=role::find($Role4_ID);

            $cont=Str::contains($allperm,'student');
            if($cont)
                $Role4->permissions()->attach($allperm->id);
        }
        $Role5=role::where(['name'=>'Ex'])->first();
        if(!$Role5)
            $Role5=role::create(['name'=>'Ex']);
        foreach ($allperms as $allperm) {
            $Role5_ID = role::getRoleID( 'Ex');
            $Role5=role::find($Role5_ID);
            $cont=Str::contains($allperm,'course');
            if($cont)
                $Role5->permissions()->attach($allperm->id);
        }


        dump("DONE CREATING ROLES AND ATTACHING IT WITH PERMISSIONS✔✔");

    }
    public static function CreateAdmin(){
        $RoleID=role::getRoleID('Admin');
        $Pass=Hash::make('12345678');
        User::create([
        'fname'=>'Admin',
        'username'=>'admin',
        'password'=>$Pass,
        'roleID'=>$RoleID,
        'lname'=>'',
        'IsActive'=>true
        ]);
        dump("DONE CREATING ADMIN ( USERNAME:admin | PASSWORD: 12345678 ) ✔✔ ");
    }

}
