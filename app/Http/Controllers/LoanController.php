<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Magazine;
use App\Models\Member;
use App\Models\Regulation;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class LoanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Loan::with('member')->orderBy('id', 'desc')->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        if ($row->status == "on_going") {
                            return $this->getActionColumn($row);
                        }else{
                            return '<button class="btn btn-success btn-sm" disabled>Complete</button>';
                        }
                    })
                    ->addColumn('peminjam', function($row){
                        return $row->member->name;
                    })
                    ->addColumn('phone', function($row){
                        return $row->member->phone;
                    })
                    ->addColumn('type', function($row){
                        return $this->types()[$row->type];
                    })
                    ->addColumn('created_at', function($row){
                        return date('d-m-Y H:i:s',strtotime($row->loan_at)) . " s/d "  . date('d-m-Y H:i:s',strtotime($row->expired_at));
                    })
                    ->addColumn('status', function($row){
                        return ($row->status == "finished") ? '<span class="badge text-white bg-success">Finished</span>' : '<span class="badge text-white bg-danger">On Going</span>';
                    })
                    ->addColumn('judul', function($row){
                        if ($row->type == "book") {
                            $data = Book::find($row->book_id);
                        }else if ($row->type == "magazine") {
                            $data = Magazine::find($row->magazine_id);
                        }else if ($row->type == "regulation") {
                            $data = Regulation::find($row->regulation_id);
                        }
                        return $data->title;
                    })
                    ->addColumn('pengarang', function($row){
                        if ($row->type == "book") {
                            $data = Book::find($row->book_id);
                        }else if ($row->type == "magazine") {
                            $data = Magazine::find($row->magazine_id);
                        }else if ($row->type == "regulation") {
                            $data = Regulation::find($row->regulation_id);
                        }
                        return ($data->author) ? $data->author : "-";
                    })
                    ->rawColumns(['action','status'])
                    ->make(true);
        }
        return view('pages.admin.loan.index');
    }

    protected function getActionColumn($row): string
    {
        $id = Crypt::encrypt($row->id);

        return "<button type='button' class='btn btn-sm btn-danger btn-delete' data-id='$id'>Batalkan</button>";
    }


    public function create()
    {
        $member = Member::where("is_verified",true)->get();
        $book = Book::where('stock','>',0)->get();
        $magazine = Magazine::where('stock','>',0)->get();
        $regulation = Regulation::where('stock','>',0)->get();
        return view('pages.admin.loan.create',compact("member","book","magazine","regulation"));
    }

    public function store(Request $request)
    {
        $rules = $this->rules();
        $rules[$request->type."_id"] = "required";
        $this->validate($request, $rules, $this->messages(), $this->attributes());
        $cekBorrowing = Loan::where("member_id",$request->member_id)->where("status","on_going")->first();
        if (!empty($cekBorrowing)) {
            return redirect()->back()->withErrors(["failed" => "Anggota tersebut belum mengembalikan buku sebelumnya!"]);
        }
        $data = $request->all();
        $data['status'] = "on_going";
        $data['expired_at'] = date('Y-m-d H:i',strtotime($request->loan_at." + $request->lama_pinjam days"));
        $loan = Loan::create($data);
        $day = date_diff(date_create(date('Y-m-d H:i:s',strtotime($loan->loan_at))),date_create(date('Y-m-d H:i:s',strtotime($loan->expired_at))));
        if ($loan) {
            if ($loan->type == "book") {
                $dt = Book::where("id",$loan->book_id)->first();
                $dt->decrement("stock",1);
            }else if ($loan->type == "magazine") {
                $dt = Magazine::where("id",$loan->magazine_id)->first();
                $dt->decrement("stock",1);
            }else if ($loan->type == "regulation") {
                $dt = Regulation::where("id",$loan->regulation_id)->first();
                $dt->decrement("stock",1);
            }
            $wa = new DashboardController();
            $message = "
*Halo {$loan->member->name}*,
Berhasil Peminjaman
Detail Peminjaman :
=========================
*Jenis:* ".$loan->type."
*Judul:* ".$dt->title."
*Pengarang:* ".$dt->title."
*Tanggal Peminjaman:* ".date('d-m-Y H:i',strtotime($loan->loan_at))."
*Lama Peminjaman:* ".$day->days." Hari
*Tanggal Pengembalian:* ".date('d-m-Y H:i',strtotime($loan->expired_at))."
=========================
Terimakasih!*";            
            $wa->sendMessage($loan->member->phone,$message);
        }
        return redirect()->route('admin.loan')->with('success', 'Peminjaman buku berhasil dilakukan');
    }

    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        $item = Loan::find($id);
        if ($item) {
            if ($item->type == "book") {
                Book::where("id",$item->book_id)->increment('stock',1);
            }else if ($item->type == "magazine") {
                Magazine::where("id",$item->magazine_id)->increment('stock',1);
            }else if ($item->type == "regulation") {
                Regulation::where("id",$item->regulation_id)->increment('stock',1);
            }
            $item->delete();
            return response()->json(['success' => 'Item deleted successfully.']);
        } else {
            return response()->json(['error' => 'Item not found.'], 404);
        }
    }
    private function types(){
        return [
            "book" => "Buku",
            "magazine" => "Majalah",
            "regulation" => "Peraturan"
        ];
    }

    private function rules()
    {
        return [
            'member_id' => 'required',
            'book_id' => '',
            'magazine_id' => '',
            'regulation_id' => '',
            'type' => 'required',
            'loan_at' => 'required',
            'lama_pinjam' => 'required|numeric',
        ];
    }

    private function messages()
    {
        return [
            'required' => ':attribute harus diisi.',
            'numeric' => ':attribute harus berupa angka.',
        ];
    }

    private function attributes()
    {
        return [
            'member_id' => 'Anggota',
            'book_id' => 'Buku',
            'magazine_id' => 'Majalah',
            'regulation_id' => 'Peraturan',
            'loan_at' => 'Waktu Pinjam',
            'type' => 'Jenis Peminjaman',
            'lama_pinjam' => 'Lama Peminjaman',
        ];
    }
}