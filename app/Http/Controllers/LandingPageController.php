<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Magazine;
use App\Models\Member;
use App\Models\Regulation;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class LandingPageController extends Controller
{
    protected $whatsapp;
    function __construct() {
        $this->whatsapp = new DashboardController();
    }

    public function index()
    {
        return view('pages.landing-page.index');
    }

    public function search()
    {
        return view('pages.landing-page.search.index');
    }

    public function searchBook(Request $request)
    {
        if ($request->ajax()) {
            $data = Book::orderBy('id', 'desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    return $this->getAction($row);
                })
                ->addColumn('dokumen', function($row) {
                    return $this->getActionDokumen($row);
                })
                ->rawColumns(['action','dokumen'])
                ->make(true);
        }

        return view('pages.landing-page.search.search-book');
    }

    public function searchMagazine(Request $request)
    {
        if ($request->ajax()) {
            $data = Magazine::orderBy('id', 'desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    return $this->getAction($row);
                })
                ->addColumn('dokumen', function($row) {
                    return $this->getActionDokumen($row);
                })
                ->rawColumns(['action','dokumen'])
                ->make(true);
        }

        return view('pages.landing-page.search.search-magazine');
    }

    public function searchRegulation(Request $request)
    {
        if ($request->ajax()) {
            $data = Regulation::orderBy('id', 'desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    return $this->getAction($row);
                })
                ->addColumn('dokumen', function($row) {
                    return $this->getActionDokumen($row);
                })
                ->rawColumns(['action','dokumen'])
                ->make(true);
        }

        return view('pages.landing-page.search.search-regulation');
    }

    protected function getAction($row): string
    {
        $url = ($row->dokumen == null) ? "#" : asset('storage/'.$row->dokumen);
        return "<a class='btn btn-sm btn-secondary' target='_blank' href='".$url."'><i class='fa fa-eye'></i></a>";
    }
    
    protected function getActionDokumen($row): string
    {
        if ($row->dokumen == null) {
            return "<a class='btn btn-sm btn-danger' href='#'>No Docs</a>";
        } else {
            return "<a class='btn btn-sm btn-success' download href='".asset('storage/'.$row->dokumen)."'>Download</a>";
        }
        
    }

    public function members()
    {
        return view('pages.landing-page.member.index');
    }

    public function visitors()
    {
        return view('pages.landing-page.visitor.index');
    }

    public function storeMembers(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'phone' => 'required|numeric|unique:members,phone|max_digits:20',
        ];
        $messages = [
            'required' => ':attribute harus diisi',
            'max' => ':attribute maksimal :max karakter',
            'numeric' => ':attribute harus berupa angka',
            'unique' => ':attribute telah digunakan',
        ];

        $attributes = [
            'name' => 'Nama',
            "phone" => "No HP",
        ];

        $this->validate($request, $rules, $messages, $attributes);
        $data = Member::create([
            'name' => $request->name,
            'phone' => $request->phone,
            "token" => Str::random(64),
            "expired_at" => date('Y-m-d H:i:s',strtotime(" + 1 days"))
        ]);
        if ($data) {
$message = "
*Halo {$data->name}*,
Terimakasih Telah Mendaftar
Silahkan verifikasi nomor anda dengan klik link berikut :
=========================
".route('verification',$data->token)."
=========================
*Link berlaku 1 hari, Terimakasih!*";
            $this->whatsapp->sendMessage($data->phone,$message);
        }
        return redirect()->back()->with('success', 'Berhasil mendaftar, silahkan verifikasi untuk dapat melakukan kunjungan.');
    }

    public function storeVisitors(Request $request)
    {
        $rules = [
            'phone' => 'required|numeric|max_digits:20',
        ];
        $messages = [
            'required' => ':attribute harus diisi',
            'max' => ':attribute maksimal :max karakter',
            'numeric' => ':attribute harus berupa angka',
        ];

        $attributes = [
            "phone" => "No HP",
        ];

        $this->validate($request, $rules, $messages, $attributes);
        $cekPhone = Member::where('phone',$request->phone)->first();
        if (empty($cekPhone)) {
            return redirect()->back()->withErrors(["failed_verify" => "No HP tidak tersedia, silahkan daftar terlebih dahulu"]);
        }else if(!$cekPhone->is_verified){
            $this->resendVerify($cekPhone->id);
            return redirect()->back()->withErrors(["failed_verify" => "Keanggotan belum terverifikasi, berhasil mengirimkan link verifikasi ke whatsapp."]);
        }
        $data = Visitor::create([
            'member_id' => $cekPhone->id,
        ]);
        return redirect()->back()->with('success', 'Terimakasih atas kunjungannya, silahkan meminjam buku.');
    }

    public function verify(Request $request){
        if ($request->token == null) {
            return redirect(route('members'))->withErrors(["failed_verify" => "Parameter token wajib diisi!"]);
        }
        $data = Member::where('token',$request->token)->first();
        if (empty($data)) {
            return redirect(route('members'))->withErrors(["failed_verify" => "Token tidak valid!"]);
        }else if (date('Y-m-d H:i:s') > date('Y-m-d H:i:s',strtotime($data->expired_at))) {
            $this->resendVerify($data->id);
            return redirect(route('members'))->withErrors(["failed_verify" => "URL kedaluwarsa, Link baru telah dikirimkan."]);
        }else{
            $data->update([
                "is_verified" => true,
                "token" => null,
                "expired_at" => null
            ]);
            return redirect(route('visitors'))->with('success', 'Verifikasi berhasil, anda dapat meminjam buku sekarang!');
        }
    }

    public function resendVerify(Member $member){
        $member->update([
            "token" => Str::random(64),
            "expired_at" => date('Y-m-d H:i:s',strtotime(" + 1 days"))
        ]);
        if ($member) {
$message = "
*Halo {$member->name}*,
Terimakasih Telah Mendaftar
Silahkan verifikasi nomor anda dengan klik link berikut :
=========================
".route('verification',$member->token)."
=========================
*Link berlaku 1 hari, Terimakasih!*";
            $this->whatsapp->sendMessage($member->phone,$message);
        }
    }
}
