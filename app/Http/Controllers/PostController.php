<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostModel;

class PostController extends Controller
{
    //
    public function UpdateUser($id, Request $request)
    {
        $surname = $request['surname'];
        $name = $request['name'];
        $patronymic = $request['patronymic'];
        $phone = $request['phone'];
        $email = $request['email'];
        $date_of_birth = $request['date_of_birth'];
        $photo_url = $request['photo_url'];
        $company_name = $request['company_name'];
        
        return PostModel::UpdateUser($id, $surname, $name, $patronymic, $phone, $email, $date_of_birth, $photo_url, $company_name);
    }

    public function AddNewUser(Request $request)
    {
        $surname = $request['surname'];
        $name = $request['name'];
        $patronymic = $request['patronymic'];
        $phone = $request['phone'];
        $email = $request['email'];
        $date_of_birth = $request['date_of_birth'];
        $photo_url = $request['photo_url'];
        $company_name = $request['company_name'];
        //проверка обязательных полей на заполнение
        if ($surname == "" || $name == ""|| $patronymic == ""|| $phone == "" ||  $email == "" ) {
            return ['code' => '400'];
        }
        else
        {
            return PostModel::New_Create($surname, $name, $patronymic, $phone, $email, $date_of_birth, $photo_url, $company_name);
        }
    }
}
