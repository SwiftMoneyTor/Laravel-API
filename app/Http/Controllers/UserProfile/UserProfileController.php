<?php

namespace App\Http\Controllers\UserProfile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class UserProfileController extends Controller
{
    //
    public function updateAcc(Request $req, Response $res)
    {
        $id = intval($req->input('users_id'));
        $updateProfile = DB::table('users')
            ->where('id', '=', $id)
            ->update([
                'email' => $req->input('email'),
                'password' => $req->input('password')
            ]);

        if ($updateProfile) {
            $msg = array("message" => "success", "account" => "updated");
            $json = json_encode($msg);
            return $json;
        }
    }

    public function retrieveUserInfo(Request $request, Response $response)
    {
        $result = DB::table('users')
            ->join('userprofile', 'users.id', '=', 'userprofile.users_id')
            ->select('users.*', 'userprofile.*')
            ->where('users.id', '=', [$request->input('users_id')])
            ->get();
        if (isset($result[0])) {
            return $result;
        }
    }

    public function addNewProfile(Request $req)
    {
        $addProfile = DB::insert("INSERT INTO userProfile(firstName, lastName, bDay, gender, lotNum, street, brgy, city, zipCode) VALUES (?, ?, ?, ?)", [$req->input('firstname'), $req->input('lastname'), $req->input('bDay'), $req->input('gender'), $req->input('lotNum'), $req->input('street'), $req->input('brgy'), $req->input('city'), $req->input('zipCode')]);

        return $addProfile;
    }

    public function editProfile(Request $req, Response $res)
    {

        $id = intval($req->input('profile_id')); // to be change to user_id
        $firstName = $req->input('firstName');
        $lastName = $req->input('lastName');
        $bDay = $req->input('bDay');
        $gender = $req->input('gender');
        $lotNum = $req->input('lotNum');
        $street = $req->input('street');


        $data = $req->all();
        $updateProfile = DB::table('userprofile')->where('users_id', $id)->update($data);

        if ($updateProfile) {
            $msg = array("message" => "success", "profile" => "updated");
            $json = json_encode($msg);
            return $json;
        }
    }

    public function fetchUser($id)
    {
        $result = DB::select('SELECT * FROM users WHERE id=?', [$id]);
        return (array)$result[0]->name;
    }
}
