<?php

namespace App\Http\Controllers;

use App\Models\Regulation;
use App\Exports\RegulationExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class RegulationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Regulation::orderBy('id', 'desc')->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        return $this->getActionColumn($row);
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('pages.admin.regulations.index');
    }

    protected function getActionColumn($row): string
    {
        $id = Crypt::encrypt($row->id);
        $showUrl = route('admin.regulation.show', $id);
        $editUrl = route('admin.regulation.edit', $id);

        return "<a class='btn btn-sm btn-secondary' href='$showUrl'><i class='fa fa-eye'></i></a> 
                <a class='btn btn-sm btn-info' href='$editUrl'><i class='fa fa-pencil-alt'></i></a>
                <button type='button' class='btn btn-sm btn-danger btn-delete' data-id='$id'><i class='fa fa-trash'></i></button>";
    }


    public function create()
    {
        return view('pages.admin.regulations.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->rules(), $this->messages(), $this->attributes());
        $data = $request->all();
        Regulation::create($data);
        return redirect()->route('admin.regulation')->with('success', 'Buku Induk Peraturan berhasi ditambahkan');
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $regulation = Regulation::find($id);
        return view('pages.admin.regulations.edit', compact('regulation'));
    }

    public function update(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        $regulation = Regulation::find($id);
        $this->validate($request, $this->rules(), $this->messages(), $this->attributes());
        $regulation->update($request->all());

        return redirect()->route('admin.regulation')->with('success', 'Buku Induk Peraturan berhasi diubah');
    }

    public function show($id)
    {
        $id = Crypt::decrypt($id);
        $regulation = Regulation::find($id);
        return view('pages.admin.regulations.show', compact('regulation'));
    }

    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        $item = Regulation::find($id);
        if ($item) {
            $item->delete();
            return response()->json(['success' => 'Item deleted successfully.']);
        } else {
            return response()->json(['error' => 'Item not found.'], 404);
        }
    }

    public function export()
    {
        return Excel::download(new RegulationExport, 'Buku Induk Peraturan.xlsx');
    }

    private function rules()
    {
        return [
            'title' => 'required|max:255',
            'regulation_serial_number' => 'nullable|integer',
            'regulation_type' => 'nullable|max:255',
            'number_and_year_of_regulation' => 'nullable|max:255',
            'place_and_number_of_regulation' => 'nullable|max:255',
            'author' => 'nullable|max:255',
            'publisher' => 'nullable|max:255',
            'place_of_publication' => 'nullable|max:255',
            'year_of_publication' => 'nullable|integer',
            'classification' => 'nullable|max:255',
            'place_of_origin' => 'nullable|max:255',
            'note' => 'nullable|max:1000',
        ];
    }

    private function messages()
    {
        return [
            'required' => 'The :attribute field is required.',
            'max' => 'The :attribute may not be greater than :max characters.',
            'number' => 'The :attribute must be a number.',
            'integer' => 'The :attribute must be an integer.',
        ];
    }

    private function attributes()
    {
        return [
            'title' => 'Judul',
            'regulation_serial_number' => 'No. Urut Peraturan',
            'regulation_type' => 'Tipe Peraturan',
            'number_and_year_of_regulation' => 'Nomor dan Tahun Peraturan',
            'place_and_number_of_regulation' => 'Tempat dan Tahun Peraturan',
            'author' => 'Pengarang',
            'publisher' => 'Penerbit',
            'place_of_publication' => 'Tempat Terbit',
            'year_of_publication' => 'Tahun Terbit',
            'classification' => 'No. Klasifika',
            'place_of_origin' => 'Berasal dari',
            'note' => 'Keterangan',
        ];
    }
}
