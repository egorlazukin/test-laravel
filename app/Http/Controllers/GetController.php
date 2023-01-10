<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GetModel;
class GetController extends Controller
{
    //

    public function LoadAll()
    {
        return GetModel::getListAll();
    }

    public function LoadID($id)
    {
        return GetModel::getListID($id);
    }
}
