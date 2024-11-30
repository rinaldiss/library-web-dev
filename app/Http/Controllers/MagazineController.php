<?php

namespace App\Http\Controllers;

use App\Models\Magazine;
use App\Exports\MagazineExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class MagazineController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Magazine::orderBy('id', 'desc')->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        return $this->getActionColumn($row);
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('pages.admin.magazines.index');
    }

    protected function getActionColumn($row): string
    {
        $id = Crypt::encrypt($row->id);
        $showUrl = route('admin.magazine.show', $id);
        $editUrl = route('admin.magazine.edit', $id);

        return "<a class='btn btn-sm btn-secondary' href='$showUrl'><i class='fa fa-eye'></i></a> 
                <a class='btn btn-sm btn-info' href='$editUrl'><i class='fa fa-pencil-alt'></i></a>
                <button type='button' class='btn btn-sm btn-danger btn-delete' data-id='$id'><i class='fa fa-trash'></i></button>";
    }


    public function create()
    {
        return view('pages.admin.magazines.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->rules(), $this->messages(), $this->attributes());
        $data = $request->all();
        Magazine::create($data);
        return redirect()->route('admin.magazine')->with('success', 'Buku Induk Majalah berhasi ditambahkan');
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $magazine = Magazine::find($id);
        return view('pages.admin.magazines.edit', compact('magazine'));
    }

    public function update(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        $magazine = Magazine::find($id);
        $this->validate($request, $this->rules(), $this->messages(), $this->attributes());
        $magazine->update($request->all());

        return redirect()->route('admin.magazine')->with('success', 'Buku Induk Majalah berhasi diubah');
    }

    public function show($id)
    {
        $id = Crypt::decrypt($id);
        $magazine = Magazine::find($id);
        return view('pages.admin.magazines.show', compact('magazine'));
    }

    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        $item = Magazine::find($id);
        if ($item) {
            $item->delete();
            return response()->json(['success' => 'Item deleted successfully.']);
        } else {
            return response()->json(['error' => 'Item not found.'], 404);
        }
    }

    public function export()
    {
        return Excel::download(new magazineExport, 'Buku Induk Majalah.xlsx');
    }

    private function rules()
    {
        return [
            'title' => 'required|max:255',
            'magazine_serial_number' => 'nullable|integer',
            'number' => 'nullable|max:255',
            'volume' => 'nullable|max:255',
            'times_published' => 'nullable|max:255',
            'issn' => 'nullable|max:255',
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
            'magazine_serial_number' => 'No. Urut Majalah',
            'number' => 'Nomor',
            'volume' => 'Volume',
            'times_published' => 'Kata Terbit',
            'issn' => 'ISSN',
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
