<?php

namespace App\Exports;

use App\Models\Billing;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class SalesReportExport implements FromCollection, WithHeadings, WithEvents
{
    protected $data;
    protected $headers;

    public function __construct($data, $headers)
    {
        $this->data = $data;
        $this->headers = $headers;
    }

    public function headings(): array
    {
        return $this->headers;
    }

    public function collection()
    {
        return collect($this->data)->map(function ($data) {
            return $data;
        });
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $event->sheet->getColumnDimension('A')->setAutoSize(true);
                $event->sheet->getColumnDimension('B')->setAutoSize(true);
                $event->sheet->getColumnDimension('C')->setAutoSize(true);
                $event->sheet->getColumnDimension('D')->setAutoSize(true);
                $event->sheet->getColumnDimension('E')->setAutoSize(true);
                $event->sheet->getStyle('A1:F1')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);
                $event->sheet->getStyle('A2:A'.$event->sheet->getHighestRow())->getAlignment()->applyFromArray(['vertical' => Alignment::VERTICAL_CENTER, 'horizontal' => Alignment::HORIZONTAL_CENTER]);
                $event->sheet->getStyle('B2:B'.$event->sheet->getHighestRow())->getAlignment()->applyFromArray(['vertical' => Alignment::VERTICAL_CENTER, 'horizontal' => Alignment::HORIZONTAL_LEFT]);
                $event->sheet->getStyle('C2:C'.$event->sheet->getHighestRow())->getAlignment()->applyFromArray(['vertical' => Alignment::VERTICAL_CENTER, 'horizontal' => Alignment::HORIZONTAL_CENTER]);
                $event->sheet->getStyle('D2:D'.$event->sheet->getHighestRow())->getAlignment()->applyFromArray(['vertical' => Alignment::VERTICAL_CENTER, 'horizontal' => Alignment::HORIZONTAL_RIGHT]);
                $event->sheet->getStyle('E2:E'.$event->sheet->getHighestRow())->getAlignment()->applyFromArray(['vertical' => Alignment::VERTICAL_CENTER, 'horizontal' => Alignment::HORIZONTAL_CENTER]);

            },
        ];
    }
}
