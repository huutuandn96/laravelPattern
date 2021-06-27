<?php

namespace App\Http\Controllers;

use Auth;
use View;
use App\Models\User;
use App\Models\Slide;
use App\Models\TinTuc;
use App\Models\LoaiTin;
use App\Models\TheLoai;
use Illuminate\Http\Request;

class PagesController extends Controller
{   
    public function __construct() {
        $theloai = TheLoai::all();
        $slide = Slide::all();
        View::share('theloai', $theloai);
        View::share('slide', $slide);
    }

    public function trangchu() {
        return view('pages.trangchu');
    }

    public function contact() {
        return view('pages.contact');
    }

    public function loaitin($id) {
        $loaitin = LoaiTin::find($id);
        $tintuc = TinTuc::where('idLoaiTin', $id)->paginate(5); 
        return view('pages.loaitin', ['loaitin' => $loaitin, 'tintuc' => $tintuc]);
    }

    public function tintuc($id) {
        $tintuc = TinTuc::find($id);
        $tinnoibat = TinTuc::where('NoiBat', 1)->take(4)->get();
        $tinlienquan = TinTuc::where('idLoaiTin', $tintuc->idLoaiTin)->take(4)->get();
        return view('pages.tintuc', ['tintuc' => $tintuc, 'tinnoibat' => $tinnoibat, 'tinlienquan' => $tinlienquan]);
    }

    public function getLogin() {
        return view('pages.login');
    }

    public function postLogin(Request $request) {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required|min:6|max:32',
        ], [
            'email.required' => 'Bạn chưa nhập email!',
            'password.required' => 'Bạn chưa nhập password!',
            'password.min' => 'Password không được ít hơn 6 ký tự!',
            'password.max' => 'Password chỉ được tối đa 32 ký tự!'
        ]);
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return redirect('trangchu');
        } else {
            return redirect('login')->with('loi', 'Mật khẩu và email không đúng!');
        }
    }

    public function logout() {
        Auth::logout();
        return redirect('trangchu');
    }

    public function getAccount() {
        return view('pages.account');
    }

    public function postAccount(Request $request) {
        $this->validate($request, [
            'name' => 'required|min:6',
        ], [
            'name.required' => 'Bạn chưa nhập tên người dùng.',
            'name.min' => 'Tên người dùng phải có ít nhất 6 ký tự.',
        ]);
        $user = Auth::user();
        $user->name = $request->name;

        if($request->changePassword == 'on') {
            $this->validate($request, [
                'password' => 'required|min:6|max:32',
                'passwordAgain' => 'required|same:password'
            ], [
                'password.required' => 'Bạn chưa nhập mật khẩu!',
                'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự!',
                'password.max' => 'Mật khẩu chỉ tối đa 32 ký tự!',
                'passwordAgain.required' => 'Bạn chưa lại mật khẩu!',
                'passwordAgain.same' => 'Mật khẩu không trùng khớp!'
            ]);
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return redirect('account')->with('thongbao', 'Bạn đã sửa thông tin tài khoản thành công!');
    }

    public function getSignup() {
        return view('pages.signup');
    }

    public function postSignup(Request $request) {
        $this->validate($request, [
            'name' => 'required|min:6',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:32',
            'passwordAgain' => 'required|same:password'
        ], [
            'name.required' => 'Bạn chưa nhập tên người dùng.',
            'name.min' => 'Tên người dùng phải có ít nhất 6 ký tự.',
            'email.required' => 'Bạn chưa nhập email',
            'email.email' => 'Bạn chưa nhập đúng định dạng email!',
            'email.unique' => 'Email đã tồn tại.',
            'password.required' => 'Bạn chưa nhập mật khẩu!',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự!',
            'password.max' => 'Mật khẩu chỉ tối đa 32 ký tự!',
            'passwordAgain.required' => 'Bạn chưa lại mật khẩu!',
            'passwordAgain.same' => 'Mật khẩu không trùng khớp!'
        ]);
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->quyen = 0;
        $user->save();

        return redirect('login')->with('thongbao', 'Đăng ký tài khoản thành công!');
    }

    public function search(Request $request) {
        $keyword = $request->keyword;
        $tintuc = TinTuc::where('TieuDe', 'like', "%$keyword%")->orWhere('TomTat', 'like', "%$keyword%")
        ->orWhere('NoiDung', 'like', "%$keyword%")->take(30)->paginate(5);
        return view('pages.search', ['tintuc' => $tintuc, 'keyword' => $keyword]);
    }
}
