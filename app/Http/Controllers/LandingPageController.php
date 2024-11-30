<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Magazine;
use App\Models\Regulation;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class LandingPageController extends Controller
{
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
        ];
        
        $messages = [
            'required' => ':attribute harus diisi',
            'max' => ':attribute maksimal :max karakter',
        ];

        $attributes = [
            'name' => 'Nama',
            'nip' => 'NIP',
        ];

        $this->validate($request, $rules, $messages, $attributes);

        Visitor::create([
            'name' => $request->name,
            'nip' => $request->nip,
        ]);

        return redirect()->back()->with('success', 'Kunjungan berhasil ditambahkan');
    }
}
