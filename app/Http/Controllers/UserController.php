<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Permission;
use App\Models\role;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use phpDocumentor\Reflection\Types\Array_;
use PhpParser\Node\Scalar\String_;
use function PHPUnit\Framework\throwException;
use Symfony\Component\CssSelector\Parser\Token;
use Laravel\Sanctum\PersonalAccessToken;

class UserController extends Controller
{


    public function get_users()
    {
        $users = User::where('IsActive',true)->get();
        $results = [];
        foreach ($users as $user) {
            $results[] = $this->ResultFormatter($user);
        }

        return response()->json(
            [
                'status' => '200',
                'data' => $results,
                'message' => 'Successfully get!'
            ],
            200);
    }


    public function login(LoginRequest $request)
    {
        $bb = null;
        try {
            $validated = $request->validate($request->rules());
        }  catch (ValidationException $exx) {
            return Response()->json(
                ['message'=>'The given data was invalid.','errors'=>['username'=>['اسم المستخدم غير موجود']]],
                422
            );
        }

        if (!Auth::attempt($validated)):
            try{
            $validator = validator($validated, $request->rules(), $request->messages());
}
            catch (ValidationException $exx) {
                return response()->json([$exx->getMessage()],422);
            }
            if(Auth::check()) {
            $user=Auth::user();
                $accessToken = $user->tokens()->first();
                return response()->json(['access_token' => $accessToken, 'Auth' => $user], 200);
            }
        endif;
        $user = User::where('username', $request->username)->first();
        if ($user==null) {
            return Response()->json(
                ['message'=>'The given data was invalid.','errors'=>['username'=>['اسم المستخدم غير موجود']]],
                422
            );
        }

        if (Hash::check($request->password, $user->getAuthPassword())) {
            if($user->IsActive==false){
                return Response()->json(
                    ['message'=>'عليك مراجعة المسؤول حسابك غير فعال','errors'=>['username'=>['حساب المستخدم غير فعال']]],
                    400
                );
            }
            $accessToken = $user->createToken('auth-token')->plainTextToken;

            Auth::login($user);
            Session::start();
            $rr = Auth::check();
            return Response()->json(
                ['access_token' => $accessToken, 'Auth::chek' => $rr],
                200
            );
        } else {
            $rr = Auth::check();
            return Response()->json(
                ['message'=>'The given data was invalid.','errors'=>['password'=>['كلمة السر غير صحيحة']]],
                422
            );
        }


    }



    public function Logout()
    {
        if (Auth::check()):
            $user=Auth::user();
        $user->tokens()->delete();
            Auth::logout();
            Session::flush();
            return response()->json(['Auth:Check' => Auth::check(), "good to perform"], 200);
        else:

            return response()->json(['Auth:Check' => Auth::check(), "there's no user logged in"], 202);
        endif;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     **/

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create_user(RegisterRequest $request)
    {
        $bb = null;
        try {
            $validated = $request->validate($request->rules());
        }catch (ValidationException $exx) {
            return response()->json([$exx->getMessage()],422);
        }
        $validated['password'] = Hash::make($request->password);
        $rolename = $request->Role;

        $validated['roleID'] = role::getRoleID($rolename);
        $user = User::create($validated);
        $accessToken = $user->createToken('authToken')->accessToken;
        //Auth::login($user);
        return response()->json(['user' => $user, 'access_token' => $accessToken], 200);
    }


    public function get_user()
    {

        $user = Auth::user();

        return response()->json($this->ResultFormatter($user), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */

    public function show_user(Request $request)
    {
        $id = $request->id;
        $user = User::findOrFail($id);

        return response()->json(
            $data = $user,
            $status = 200
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update_user(Request $request)
    {
        $id = $request->id;
        $user = User::findorfail($id);
        $user->fname = $request->fname;
        $user->lname = $request->lname;
        if ($user->username != $request->username) {
            $rules = ['username' => 'required|unique:users,username'];
            $messages = ['username.required' => 'يجب عليك ادخال اسم المستخدم ',
                'username.unique' => ' اسم المستخدم موجود مسبقاً في قاعدة البيانات بإمكانك تضمين أرقام ضمن اسم المستخدم مثال somene7 '];
            try {
                $valid = $request->validate($rules, $messages);
            }            catch (ValidationException $exx) {
                return response()->json([$exx->getMessage()],422);
            }
            $user->username = $request->username;
        }
        $user->roleID = role::getRoleID($request->Role);
        $user->update();
        return response()->json(["Successfully updated "], 200);
    }

    public function change_Password(Request $request)
    {
        $currU = Auth::user();
        $currR = role::findOrFail($currU->roleID)->name;
        if ($currR == 'Admin' or $currU->id == $request->id) {
            $user=User::findOrFail($request->id);
            if($request->from=='personal'){
                $oldone=$request->oldPass;
                if (!Hash::check($oldone, $currU->getAuthPassword())) {
                    return response()->json(['errors'=>['oldpass'=>"كلمة السر الحالية خاطئة"]],402);
                }
            }
            $newone=$request->newPass;
            if(strlen($newone)<6){
                return response()->json(['errors'=>['newpass'=>"يجب أن تكون كلمة السر أكثر من 6 أحرف"]],402);
            }
            $user->password=Hash::make($newone);
            $user->update();
            return response()->json("done",200);
        }
        return response()->json("YOU DON'T HAVE PERMISSION",401);
    }

    public function give_Permission_user(Request $request)
    {
        $newpermissions = $request->permissions;
        $id = $request->id;
        $user = User::findOrFail($id);
        $Role = role::findOrFail($user->roleID);
        $rolePerms = $Role->Permissions()->get();
        $RP = [];
        foreach ($rolePerms as $rolePerm) {
            $RP[] = $rolePerm->name;
        }
        $IDP = [];
        $vv = count($newpermissions);
        for ($i = 0; $i < $vv; $i++) {
            if (!in_array($newpermissions[$i], $RP) and $newpermissions[$i] != '')
                $IDP[] = Permission::where('name', $newpermissions[$i])->first()->getKey();
        }

        $user->Permissions()
            ->sync($IDP);
        return response()->json($user->AllPermissions());
    }


    public function UserPer(Request $request)
    {
        $user = User::findOrFail($request->id);
        return response()->json($user->AllPermissions());

    }

    public function delete_user(Request $request)
    {   $id=$request->id;
        $user = User::find($id);
        $user->IsActive = 0;
        $user->save();
        return response()->json("done the user is deActivated Now",200);
    }


    protected function ResultFormatter($request)
    {
        $RolII = $request->roleID;
        $RoleN = role::where('id', $RolII)->first()->name;
        //$user->rolen=$RoleN;
        $request->RoleName = $RoleN;
        if ($RoleN == 'Admin')
            $request->Role = 'رئيس دائرة';
        if ($RoleN == 'AfAdmin')
            $request->Role = 'رئيس شعبة الشؤون';
        if ($RoleN == 'ExAdmin')
            $request->Role = 'رئيس شعبة الامتحانات';
        if ($RoleN == 'Af')
            $request->Role = 'موظف شؤون';
        if ($RoleN == 'Ex')
            $request->Role = 'موظف امتحانات';
        return [
            'id' => $request->id,
            'fname' => $request->fname,
            'lname' => $request->lname,
            'username' => $request->username,
            'roleID'=>$request->roleID,
            'Role' => $request->Role,
            'RoleName' => $request->RoleName,
            'IsActive' => $request->IsActive,
        ];
    }

}
