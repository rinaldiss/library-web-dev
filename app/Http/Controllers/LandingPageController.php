<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Magazine;
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
                ->rawColumns(['action'])
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
                ->rawColumns(['action'])
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
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.landing-page.search.search-regulation');
    }

    protected function getAction($row): string
    {
        $id = Crypt::encrypt($row->id);

        return "<a class='btn btn-sm btn-secondary' data-attr='$id'><i class='fa fa-eye'></i></a>";
    }

    public function visitors()
    {
        return view('pages.landing-page.visitor.index');
    }

    public function storeVisitors(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'nip' => 'required|max:255',
            'phone' => 'required|numeric|unique:visitors,phone|max_digits:20',
        ];
        $messages = [
            'required' => ':attribute harus diisi',
            'max' => ':attribute maksimal :max karakter',
            'numeric' => ':attribute harus berupa angka',
            'unique' => ':attribute telah digunakan',
        ];

        $attributes = [
            'name' => 'Nama',
            'nip' => 'NIP',
            "phone" => "No HP",
        ];

        $this->validate($request, $rules, $messages, $attributes);
        $data = Visitor::create([
            'name' => $request->name,
            'nip' => $request->nip,
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
        return redirect()->back()->with('success', 'Kunjungan berhasil ditambahkan');
    }

    public function verify(Request $request){
        if ($request->token == null) {
            return redirect(route('visitors'))->withErrors(["failed_verify" => "Parameter token wajib diisi!"]);
        }
        $data = Visitor::where('token',$request->token)->first();
        if (empty($data)) {
            return redirect(route('visitors'))->withErrors(["failed_verify" => "Token tidak valid!"]);
        }else if (date('Y-m-d H:i:s') > date('Y-m-d H:i:s',strtotime($data->expired_at))) {
            $this->resendVerify($data->id);
            return redirect(route('visitors'))->withErrors(["failed_verify" => "URL kedaluwarsa, Link baru telah dikirimkan."]);
        }else{
            $data->update([
                "is_verified" => true,
                "token" => null,
                "expired_at" => null
            ]);
            return redirect()->back()->with('success', 'Verifikasi berhasil, anda dapat meminjam buku sekarang!');
        }
    }

    public function resendVerify(Visitor $visitor){
        $visitor->update([
            "token" => Str::random(64),
            "expired_at" => date('Y-m-d H:i:s',strtotime(" + 1 days"))
        ]);
        if ($visitor) {
$message = "
*Halo {$visitor->name}*,
Terimakasih Telah Mendaftar
Silahkan verifikasi nomor anda dengan klik link berikut :
=========================
".route('verification',$visitor->token)."
=========================
*Link berlaku 1 hari, Terimakasih!*";
            $this->whatsapp->sendMessage($visitor->phone,$message);
        }
    }
}
