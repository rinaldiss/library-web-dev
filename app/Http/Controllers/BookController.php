<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Exports\BookExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class BookController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Book::orderBy('id', 'desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return $this->getActionColumn($row);
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.admin.books.index');
    }

    protected function getActionColumn($row): string
    {
        $id = Crypt::encrypt($row->id);
        $showUrl = route('admin.book.show', $id);
        $editUrl = route('admin.book.edit', $id);

        return "<a class='btn btn-sm btn-secondary' href='$showUrl'><i class='fa fa-eye'></i></a> 
                <a class='btn btn-sm btn-info' href='$editUrl'><i class='fa fa-pencil-alt'></i></a>
                <button type='button' class='btn btn-sm btn-danger btn-delete' data-id='$id'><i class='fa fa-trash'></i></button>";
    }


    public function create()
    {
        return view('pages.admin.books.create');
    }

    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'dokumen' => 'mimes:doc,docx,pdf,xls,xlsx,ppt,pptx',
            ], $this->messages(), $this->attributes());
            $dokumen = $request->dokumen;
            $nama_dokumen = 'FT' . date('YmdHis') . '.' . $dokumen->getClientOriginalExtension();
            $path = $dokumen->move(public_path('file'), $nama_dokumen);

            $data = $request->all();
            $data['dokumen'] = $nama_dokumen;

            Book::create($data);

            return redirect()->route('admin.book')->with('success', 'Buku Induk Buku berhasil ditambahkan');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('admin.book')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $book = Book::find($id);
        return view('pages.admin.books.edit', compact('book'));
    }

    public function update(Request $request, $id)
    {
        try {

            $id = Crypt::decrypt($id);
            $book = Book::find($id);
            $this->validate($request, [
                'dokumen' => 'mimes:doc,docx,pdf,xls,xlsx,ppt,pptx',
            ], $this->rules(), $this->messages());
            $dokumen = $request->dokumen;
            $nama_dokumen = 'FT' . date('YmdHis') . '.' . $dokumen->getClientOriginalExtension();
            $path = $dokumen->move(public_path('file'), $nama_dokumen);

            $data = $request->all();
            $data['dokumen'] = $nama_dokumen;
            $book->update($data);

            return redirect()->route('admin.book')->with('success', 'Buku Induk Buku berhasi diubah');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('admin.book')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $id = Crypt::decrypt($id);
        $book = Book::find($id);
        return view('pages.admin.books.show', compact('book'));
    }

    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        $item = Book::find($id);
        if ($item) {
            $item->delete();
            return response()->json(['success' => 'Item deleted successfully.']);
        } else {
            return response()->json(['error' => 'Item not found.'], 404);
        }
    }

    public function export()
    {
        return Excel::download(new bookExport, 'Buku Induk Buku.xlsx');
    }

    private function rules()
    {
        return [
            'title' => 'required|max:255',
            'book_serial_number' => 'nullable|integer',
            'edition' => 'nullable|max:255',
            'volume' => 'nullable|max:255',
            'printed' => 'nullable|max:255',
            'isbn' => 'nullable|max:255',
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
            'book_serial_number' => 'No. Urut Buku',
            'edition' => 'Edisi',
            'volume' => 'Volume',
            'printed' => 'Cetakan',
            'isbn' => 'ISBN',
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
