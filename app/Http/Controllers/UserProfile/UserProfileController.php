<?php

namespace App\Http\Controllers\UserProfile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use App\Models\User;

class UserProfileController extends Controller
{
    //
    public function retrieveAccInfo(Request $request, Response $response)
    {
        $input = Hash::make($request->input('password'));

        $user = User::where('id', $request->input('users_id'))->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ], 404);
        }
        if (Hash::check($request->input('passcheck'), $user->password)) {
            return response()->json([
                'status' => 'match',
                'message' => 'correct password',
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Incorrect password',
            ], 200);
        }
    }

    public function updateAcc(Request $req, Response $res)
    {
        $id = intval($req->input('users_id'));

        if ($req->input('password') === null) {
            $updateAcc = DB::table('users')
                ->where('id', '=', $id)
                ->update([
                    'email' => $req->input('email')
                ]);
        } else if ($req->input('email') === null) {
            $updateAcc = DB::table('users')
                ->where('id', '=', $id)
                ->update([
                    'password' => Hash::make($req->input('password'))
                ]);
        } else {
            $updateAcc = DB::table('users')
                ->where('id', '=', $id)
                ->update([
                    'email' => $req->input('email'),
                    'password' => Hash::make($req->input('password'))
                ]);
        }

        $msg = array("message" => "success", "account" => "updated");
        $json = json_encode($msg);
        return $json;
    }

    public function retrieveUserInfo(Request $req, Response $response)
    {
        $id = $req->input('users_id');
        $find = DB::table('userprofile')->where('users_id', '=', $id)->first();

        if ($find) {
            $resultuser = DB::table('users')
                ->join('userprofile', 'users.id', '=', 'userprofile.users_id')
                ->select('users.*', 'userprofile.*')
                ->where('users.id', '=', $id)
                ->first();

            return response()->json($resultuser, 200);
        } else {
            $resultprofile = DB::table('users')->where('id', '=', $id)->get();
            return response()->json($resultprofile, 200);
        }
    }
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('display_image')) {
            $file = $request->file('display_image');
            $filename = $file->getClientOriginalName();
            $file->storeAs('display_images', $filename, 's3');
        }

        DB::table('userprofile')->where('users_id', $request->input('user_id'))->update(array('display_image' => Storage::disk('s3')->url('display_images/' . $request->file('display_image')->getClientOriginalName())));
        return response()->json(['success' => true, 'responsedata' => Storage::disk('s3')->url('display_images/' . $request->file('display_image')->getClientOriginalName())]);
    }

    public function editProfile(Request $req, Response $res)
    {

        $id = intval($req->input('users_id')); // to be change to user_id
        $firstName = $req->input('firstName');
        $lastName = $req->input('lastName');
        $bDay = $req->input('bDay');
        $gender = $req->input('gender');
        $lotNum = $req->input('lotNum');
        $street = $req->input('street');


        $data = $req->all();
        $updateProfile = DB::table('userprofile')->where('users_id', $id)->first();

        if ($updateProfile) {
            DB::table('userprofile')->where('users_id', $id)->update($data);
        } else {
            DB::table('userprofile')->insert($data);
        }

        return response()->json(["message" => "success", "profile" => "updated"], 200);
    }

    public function fetchUser($id)
    {
        $result = DB::select('SELECT * FROM users WHERE id=?', [$id]);
        return (array)$result[0]->name;
    }
    public function fetchDisplayImage(Request $request)
    {
        $result = DB::select('SELECT display_image FROM userprofile WHERE users_id=?', [$request->input('user_id')]);
        if (count($result) > 1)
            $responsedata = ['success' => true, 'responsedata' => (array)$result[0]];
        else
            $responsedata = ['success' => false];

        return response()->json($responsedata);
    }
}
