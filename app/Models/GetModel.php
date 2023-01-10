<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class GetModel extends Model
{
    use HasFactory;
    public function getListAll()
    {
        //вывод всех пользователей
        $count_table_ = GetModel::getCount_All();
        $list_table_ = json_decode(DB::table('user') -> select('id','surname', 'name','patronymic', 'phone', 'email', 'date_of_birth', 'photo_url') -> get(), true);
        $arr_nu = [];
        $arr2 = [];
        foreach ($list_table_ as $key => $value) {
            $arr_nu = json_decode(DB::table('compound_company_user') -> select('company_id') -> where('user_id', '=', $value['id']) -> get(), true);
            $bl=true;
            foreach ($arr_nu as $k1 => $vl) {
                $arr2[] = [$value, json_decode(DB::table('company') -> select('company_name') -> where('id', '=', $vl['company_id']) -> get(),true)[0]];
                $bl = false;
            }
            if ($bl) {
                $arr2[] = [$value, ["company_name" => null]];
            }
        }
        return ["code"=>"200", "count"=>$count_table_, "array"=>$arr2];
    }
    function getCount_All()
    {
        return DB::table('user') -> count();
    }
    public function getListID($id)
    {
        if(DB::table('user') -> select('id','surname', 'name','patronymic', 'phone', 'email', 'date_of_birth', 'photo_url') -> where('id','=', $id) -> count() == 0)
        {
            return ["code"=>"404", "array"=>null];
        }
        $list_table_ = json_decode(DB::table('user') -> select('id','surname', 'name','patronymic', 'phone', 'email', 'date_of_birth', 'photo_url') -> where('id','=', $id) -> get(), true)[0];
        
        if(DB::table('compound_company_user') -> select('company_id') -> where('user_id', '=', $list_table_['id']) -> count() >= 1)
        {
            
            $arr_nu = json_decode(DB::table('compound_company_user') -> select('company_id') -> where('user_id', '=', $list_table_['id']) -> get(), true)[0];
            
            $arr2[] = [$list_table_, json_decode(DB::table('company') -> select('company_name') -> where('id', '=', $arr_nu['company_id']) -> get(),true)[0]];
        }
        else
            $arr2[] = [$list_table_, ["company_name" => null]];
        return ["code"=>"200", "array"=>$arr2];
    }
}
