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
            $data = Visitor::orderBy('id', 'desc')->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        return $this->getActionColumn($row);
                    })
                    ->addColumn('status', function($row){
                        return ($row->is_verified) ? '<span class="badge text-white bg-success">Verified</span>' : '<span class="badge text-white bg-danger">Not Verified</span>';
                    })
                    ->rawColumns(['action','status'])
                    ->make(true);
        }
        return view('pages.admin.visitors.index');
    }

    public function getActionColumn($row)
    {
        $id = Crypt::encrypt($row->id);

        return "<button type='button' class='btn btn-sm btn-danger btn-delete' data-id='$id'><i class='fa fa-trash'></i></button>";
    } 
}
