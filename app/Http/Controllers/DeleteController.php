<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeleteModel;

class DeleteController extends Controller
{
    public function DeleteID($id)
    {
        return DeleteModel::DeleteID($id);
    }
}
