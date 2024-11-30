<?php

namespace App\Exports;

use App\Models\Regulation;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RegulationExport implements FromView, ShouldAutoSize, WithStyles
{
    public function view(): View
    {
        return view('pages.admin.regulations.export', [
            'datas' => Regulation::all()
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }
}
