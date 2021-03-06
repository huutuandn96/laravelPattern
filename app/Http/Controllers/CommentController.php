<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\TinTuc;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function getXoa($id, $idTinTuc) {
        $comment = Comment::find($id);
        $comment->delete();
        return redirect('admin/tintuc/sua/'.$idTinTuc)->with('thongbao', 'Xóa comment thành công!');
    }

    public function postComment($id, Request $request) {
        $idTinTuc = $id;
        $tintuc = TinTuc::find($id);
        $comment = new Comment;
        $comment->idTinTuc = $idTinTuc;
        $comment->idUser = Auth::user()->id;
        $comment->NoiDung = $request->NoiDung;
        $comment->save();

        return redirect("tintuc/$id/".$tintuc->TieuDeKhongDau.".html")->with('thongbao', 'Viết bình luận thành công!');
    }
}
