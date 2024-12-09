<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class VisitorController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Visitor::with('member')->orderBy('created_at', 'desc')->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('name', function($row){
                        return $row->member->name;
                    })
                    ->addColumn('phone', function($row){
                        return $row->member->phone;
                    })
                    ->addColumn('action', function($row){
                        return $this->getActionColumn($row);
                    })
                    ->addColumn('created_at', function($row){
                        return date('d-m-Y H:i:s',strtotime($row->created_at));
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('pages.admin.visitors.index');
    }

    public function getActionColumn($row)
    {
        $id = Crypt::encrypt($row->id);

        return "<button type='button' class='btn btn-sm btn-danger btn-delete' data-id='$id'><i class='fa fa-trash'></i></button>";
    } 

    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        $item = Visitor::find($id);
        if ($item) {
            $item->delete();
            return response()->json(['success' => 'Daftar pengunjung berhasil dihapus.']);
        } else {
            return response()->json(['error' => 'Item not found.'], 404);
        }
    }
}
