<?php

namespace Emotionally\Http\Controllers;

use Auth;
use Emotionally\User;
use Illuminate\Http\Request;
use Symfony\Component\Console\Output\ConsoleOutput;

class UserController extends Controller
{
    public function checkUserPassword(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'old_password' => 'bail|required|string'
        ]);

        if ($validator->fails()) {
            return json_encode(array('done' => false, 'errors' => $validator->errors()->toArray()));
        }
        return json_encode(array('done' => \Hash::check($request->old_password, User::findOrFail(Auth::user()->getAuthIdentifier())->password)));
    }

    public function editProfile(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'old_password' => 'bail|required|string',
            'name' => 'required|string',
            'surname' => 'required|string',
            'password' => 'string'
        ]);

        if ($validator->fails()) {
            return json_encode(array('done' => false, 'errors' => $validator->errors()->toArray()));
        }

        $user = User::findOrFail(Auth::user()->getAuthIdentifier());
        if (!\Hash::check($request->old_password, $user->password)) {
            return json_encode(array('done' => false));
        }

        $user->name = $request->name;
        $user->surname = $request->surname;
        if ($request->has('password')) {
            $user->password = \Hash::make($request->password);
        }
        $user->save();
        return json_encode(array('done' => true));
    }
}
