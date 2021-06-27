<?php

namespace App\Http\Controllers;

use App\Models\LoaiTin;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function getLoaiTin($idTheLoai) {
        $loaitin = LoaiTin::where('idTheLoai', $idTheLoai)->get();
        foreach($loaitin as $item) {
            echo "<option value='".$item->id."'>".$item->Ten."</option>";
        }
    }
}
