<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Magazine;
use App\Models\Regulation;
use App\Models\Reversion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class ReversionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Reversion::with('loan.member')->orderBy('id', 'desc')->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        // return $this->getActionColumn($row);
                        return '<button class="btn btn-success btn-sm" disabled>Completed</button>';
                    })
                    ->addColumn('peminjam', function($row){
                        return $row->loan->member->name;
                    })
                    ->addColumn('phone', function($row){
                        return $row->loan->member->phone;
                    })
                    ->addColumn('type', function($row){
                        return $this->types()[$row->loan->type];
                    })
                    ->addColumn('returned_at', function($row){
                        return date('d-m-Y',strtotime($row->returned_at));
                    })
                    ->addColumn('amount_penalty', function($row){
                        return "Rp ". number_format($row->amount_penalty,0,',','.');
                    })
                    ->addColumn('judul', function($row){
                        if ($row->loan->type == "book") {
                            $data = Book::find($row->loan->book_id);
                        }else if ($row->loan->type == "magazine") {
                            $data = Magazine::find($row->loan->magazine_id);
                        }else if ($row->loan->type == "regulation") {
                            $data = Regulation::find($row->loan->regulation_id);
                        }
                        return $data->title;
                    })
                    ->addColumn('pengarang', function($row){
                        if ($row->loan->type == "book") {
                            $data = Book::find($row->loan->book_id);
                        }else if ($row->loan->type == "magazine") {
                            $data = Magazine::find($row->loan->magazine_id);
                        }else if ($row->loan->type == "regulation") {
                            $data = Regulation::find($row->loan->regulation_id);
                        }
                        return ($data->author) ? $data->author : "-";
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('pages.admin.reversion.index');
    }

    protected function getActionColumn($row): string
    {
        $id = Crypt::encrypt($row->id);

        return "<button type='button' class='btn btn-sm btn-danger btn-delete' data-id='$id'>Batalkan</button>";
    }


    public function create(Request $request)
    {
        if ($request->ajax()) {
            $request->validate([
                "id" => "required",
                "returned_at" => "required",
            ]);
            $row = Loan::find($request->id);
            if (empty($row)) {
                return response()->json([
                    "success" => false,
                    "message" => "Empty data"
                ],404);
            }
            if ($row->type == "book") {
                $data = Book::find($row->book_id);
            }else if ($row->type == "magazine") {
                $data = Magazine::find($row->magazine_id);
            }else if ($row->type == "regulation") {
                $data = Regulation::find($row->regulation_id);
            }
            $selisih = date_diff(date_create(date('Y-m-d H:i',strtotime($request->returned_at))),date_create(date('Y-m-d H:i',strtotime($row->loan_at))));
            return response()->json([
                "success" => true,
                "data" => [
                    "type" => $this->types()[$row->type],
                    "title" => $data->title,
                    "author" => ($data->author == null) ? "-" : $data->author,
                    "loan_at" => $row->loan_at,
                    "amount_penalty" => (date('Y-m-d H:i',strtotime($request->returned_at)) > date('Y-m-d H:i',strtotime($row->loan_at))) ? 10000*$selisih->days : 0
                ]
            ]);
        }
        $loan = Loan::with('member')->where("status","on_going")->get();
        return view('pages.admin.reversion.create',compact("loan"));
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->rules(), $this->messages(), $this->attributes());
        $loan = Loan::with('member')->where('status','on_going')->find($request->loan_id);
        if (empty($loan)) {
            return redirect()->back()->withErrors(["failed" => "Data peminjaman tidak ditemukan!"]);
        }
        $reversion = Reversion::create([
            'loan_id' => $request->loan_id,
            'penalty' => $request->amount_penalty,
            'returned_at' => $request->returned_at,
        ]);
        $day = date_diff(date_create(date('Y-m-d H:i:s',strtotime($loan->loan_at))),date_create(date('Y-m-d H:i:s',strtotime($loan->expired_at))));
        if ($reversion) {
            $loan->update([
                "status" => "finished"
            ]);
            if ($loan->type == "book") {
                $dt = Book::where("id",$loan->book_id)->first();
                $dt->increment("stock",1);
            }else if ($loan->type == "magazine") {
                $dt = Magazine::where("id",$loan->magazine_id)->first();
                $dt->increment("stock",1);
            }else if ($loan->type == "regulation") {
                $dt = Regulation::where("id",$loan->regulation_id)->first();
                $dt->increment("stock",1);
            }
            $wa = new DashboardController();
            $loanDate = Carbon::parse($loan->loan_at); // Tanggal peminjaman
$returnedDate = Carbon::parse($reversion->returned_at); // Tanggal pengembalian

// Menghitung selisih antara dua tanggal
$duration = $loanDate->diff($returnedDate);

// Menghitung lama peminjaman dalam hari
$day = $duration->days; // Pastikan menggunakan $duration->days, bukan $duration saja

$message = "
*Halo {$loan->member->name}*,
Berhasil Pengembalian
Detail Pengembalian :
=========================
*Jenis:* ".$loan->type."
*Judul:* ".$dt->title."
*Pengarang:* ".$dt->author."
*Tanggal Peminjaman:* ".date('d-m-Y H:i', strtotime($loan->loan_at))."
*Tanggal Pengembalian:* ".date('d-m-Y H:i', strtotime($reversion->returned_at))."
*Lama Peminjaman:* {$day} Hari
*Denda:* ".number_format($reversion->penalty, 0, ',', '.')."
=========================
Terimakasih!*";            
            $wa->sendMessage($loan->member->phone,$message);
        }
        return redirect()->route('admin.reversion')->with('success', 'Peminjaman buku berhasil dilakukan');
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
            'loan_id' => 'required',
            'returned_at' => 'required',
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
            'loan_id' => 'Peminjaman',
            'returned_at' => 'Tanggal Pengembalian',
        ];
    }
}