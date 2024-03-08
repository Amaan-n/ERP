<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithDefaultStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Style;

class UsersExport implements FromCollection, WithHeadings, ShouldAutoSize, WithColumnFormatting, WithDefaultStyles
{
    public function headings(): array
    {
        return [
            'id',
            'name',
            'phone',
            'email',
            'is_active'
        ];
    }

    public function collection()
    {
        $user = new User();
        return $user
            ->select([
                'id',
                'name',
                'phone',
                'email',
                'is_active'
            ])
            ->get();
    }

    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_NUMBER,
        ];
    }

    public function defaultStyles(Style $defaultStyle)
    {
        return $defaultStyle->getAlignment()->setHorizontal('left');
    }
}
