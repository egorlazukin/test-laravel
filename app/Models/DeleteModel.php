<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class DeleteModel extends Model
{
    use HasFactory;
    public function DeleteID($id)
    {
        if (DeleteModel::Check_Its_User($id) >= 1) 
        {
            $response_server =  DB::table('user') -> where('id', '=', $id) -> delete();
            return ["code"=>"400", "message"=>"User deleted", "response_server" => $response_server];
        }
        return ["code"=>"400", "message"=>"The user has already been deleted"];
    }
    function Check_Its_User($id)
    {
        //чекер
        //нет ли такого уже пользователя?
        return DB::table('user') -> where('id', '=', $id) -> count() ;
    }
}
