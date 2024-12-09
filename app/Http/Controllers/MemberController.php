<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Member::orderBy('name', 'asc')->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        return $this->getActionColumn($row);
                    })
                    ->addColumn('status', function($row){
                        return ($row->is_verified) ? '<span class="badge bg-success text-white">Verified</span>' : '<span class="badge bg-danger text-white">Not Verified</span>';
                    })
                    ->rawColumns(['action','status'])
                    ->make(true);
        }
        return view('pages.admin.members.index');
    }

    protected function getActionColumn($row): string
    {
        $id = Crypt::encrypt($row->id);
        $editUrl = route('admin.member.edit', $id);

        return "<a class='btn btn-sm btn-info' href='$editUrl'><i class='fa fa-pencil-alt'></i></a>
                <button type='button' class='btn btn-sm btn-danger btn-delete' data-id='$id'><i class='fa fa-trash'></i></button>";
    }


    public function create()
    {
        return view('pages.admin.members.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,$this->rules(), $this->messages(), $this->attributes());

        Member::create([
            "name" => $request->name,
            "phone" => $request->phone,
            "is_verified" => $request->is_verified,
        ]);

        return redirect()->route('admin.member')->with('success', 'Anggota berhasil ditambahkan');
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $member = Member::find($id);
        return view('pages.admin.members.edit', compact('member'));
    }

    public function update(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        $member = Member::find($id);
        $rules = $this->rules();
        $rules["phone"] = "required|numeric|unique:members,phone,".$id;
        $this->validate($request,$rules, $this->messages(), $this->attributes());
        $member->update([
            "name" => $request->name,
            "phone" => $request->phone,
            "is_verified" => $request->is_verified,
        ]);
        return redirect()->route('admin.member')->with('success', 'Anggota berhasil diubah');
    }

    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        $item = Member::find($id);
        if ($item) {
            $item->delete();
            return response()->json(['success' => 'Anggota berhasil dihapus.']);
        } else {
            return response()->json(['error' => 'Item not found.'], 404);
        }
    }

    private function rules()
    {
        return [
            'name' => 'required|max:255',
            'phone' => 'required|numeric|unique:members,phone',
            'is_verified' => 'required',
        ];
    }

    private function messages()
    {
        return [
            'required' => ':attribute Wajib diisi.',
            'unique' => ':attribute telah digunakan.',
            'numeric' => ':attribute harus berupa angka.',
        ];
    }

    private function attributes()
    {
        return [
            'name' => 'Nama',
            'phone' => 'No HP',
            'is_verified' => 'Status',
        ];
    }
}
