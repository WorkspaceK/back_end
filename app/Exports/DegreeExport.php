<?php

namespace App\Exports;

use App\Models\Degree;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DegreeExport implements FromArray, WithHeadings, WithStyles, WithEvents, ShouldAutoSize
{

    use RegistersEventListeners;
    /**
     * @return \Illuminate\Support\Collection
     */

    public $points;

    public function __construct(array $points)
    {
        $this->points = $points;
    }

//    public function collection()
//    {
//        return collect($this->points);
//    }

    public function array(): array
    {
        return array_map(fn($point) => [
            $point['id'] ?? '',
            $point['code'] ?? '',
            $point['name'] ?? '',
            $point['description'] ?? '',
            $point['default'] ?? ''
        ], $this->points);
    }

    public function headings(): array
    {
        return ['ID', 'Mã học vị', 'Tên học vị', 'Mô tả', 'Mặc định'];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:E1')->getFont()->setBold(true);
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()
                    ->getStyle('A1:E1')
                    ->getFont()->setSize(12)->getColor()->setRGB('FF0000');
            }
        ];
    }
}
