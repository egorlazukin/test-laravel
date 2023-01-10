<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use DateTime;

class PostModel extends Model
{
    use HasFactory;
    public function Check_Its_User($surname, $name, $patronymic)
    {
        //чекер
        //нет ли такого уже пользователя?
        return DB::table('user') -> where('surname', '=', $surname) -> where('name', '=', $name) 
                    -> where('patronymic', '=', $patronymic) -> count();
    }

    public function Check_Its_Company($company_name)
    {
        //чекер
        //Есть ли такая компания
        return DB::table('company') -> where('company_name', '=', $company_name) -> count();
    }
    public function Create_new_Company($company_name)
    {
        //Креатор
        //Создаем новую компанию
        return DB::table('company')->insertGetId([ 'company_name' => $company_name]);
    }
    public function Sears_Its_Company($company_name)
    {
        //Поисковик
        //Ищем компанию
        return DB::table('company') -> select('id') -> where('company_name', '=', $company_name) -> get();
    }
    public function Company_Select($id, $company_name)
    {
        $id_company = "";
        if(PostModel::Check_Its_Company($company_name) == 0)
            $id_company = PostModel::Create_new_Company($company_name);
        else
            $id_company = json_decode(PostModel::Sears_Its_Company($company_name), true)[0]['id'];
        if ($id_company != "") {
            $id_new_user = DB::table('compound_company_user') -> insertGetId(
                [
                    'company_id' => $id_company,
                    'user_id' => $id,
                ]
            );
            
        }
    }

    public function New_Create($surname, $name, $patronymic, $phone, $email, $date_of_birth, $photo_url, $company_name)
    {
        if (PostModel::Check_Its_User($surname, $name, $patronymic) >= 1) 
        {
            return ['code'=>'403', 'message'=>'This user already exists'];
        }
        //создаем нового пользователя
        $id_new_user = DB::table('user') -> insertGetId(
            [
                'surname' => $surname,
                'name' => $name,
                'patronymic' => $patronymic,
                'phone' => $phone,
                'email' => $email,
                'date_of_birth' => $date_of_birth,
                'photo_url' => $photo_url,
            ]
        );
        if ($company_name != "") 
        {
            PostModel::Company_Select($id_new_user, $company_name);   
        }
        return ['code'=>'200', 'id_new'=>$id_new_user];

    }
    public function Update_User_Field($id, $field_new_value, $Field_name)
    {
        return DB::table('user')-> where('id', '=', $id) -> update([$Field_name => $field_new_value]);
    }
    public function UpdateUser($id, $surname, $name, $patronymic, $phone, $email, $date_of_birth, $photo_url, $company_name)
    {
        if ($company_name != "") 
        {
            $arr[] = PostModel::Company_Select($id, $company_name);   
        }
        if ($surname != "") 
        {
            $arr[] = PostModel::Update_User_Field($id, $surname, "surname");   
        }
        if ($name != "") 
        {
            $arr[] = PostModel::Update_User_Field($id, $name, "name");   
        }
        if ($patronymic != "") 
        {
            $arr[] = PostModel::Update_User_Field($id, $patronymic, "patronymic");   
        }
        if ($phone != "") 
        {
            $arr[] = PostModel::Update_User_Field($id, $phone, "phone");   
        }
        if ($email != "") 
        {
            $arr[] = PostModel::Update_User_Field($id, $email, "email");   
        }
        if ($date_of_birth != "") 
        {
            if(PostModel::validateDate($date_of_birth) == "0")
            {
                $arr[] = ['date_of_birth'=>'novalide'];    
            }
            else
                $arr[] = PostModel::Update_User_Field($id, $date_of_birth, "date_of_birth");   
        }
        if ($photo_url != "") 
        {
            $arr[] = PostModel::Update_User_Field($id, $photo_url, "photo_url");   
        }
        return ["code"=>'200', 'update'=>$arr];
    }
    function validateDate($date)
    {
        $d = DateTime::createFromFormat('Y/m/d', $date);
        return $d && $d->format('Y/m/d') == $date;
    }
}
