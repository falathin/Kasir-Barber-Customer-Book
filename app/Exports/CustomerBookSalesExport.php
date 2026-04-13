<?php

namespace App\Exports;

use App\Models\CustomerBook;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class CustomerBookSalesExport implements
    FromQuery,
    WithHeadings,
    WithMapping,
    WithCustomStartCell,
    WithEvents,
    ShouldAutoSize
{
    use Exportable;

    protected string $from;
    protected string $to;

    protected int $dataCount = 0;
    protected float $totalAmount = 0;
    protected float $averageAmount = 0;

    public function __construct(CarbonInterface|string $from, CarbonInterface|string $to)
    {
        $this->from = $from instanceof CarbonInterface
            ? $from->toDateString()
            : Carbon::parse($from)->toDateString();

        $this->to = $to instanceof CarbonInterface
            ? $to->toDateString()
            : Carbon::parse($to)->toDateString();

        $this->calculateSummary();
    }

    protected function baseQuery()
    {
        return CustomerBook::query()
            ->with(['capster', 'asistenCapster'])
            ->whereBetween('created_time', [
                Carbon::parse($this->from)->startOfDay(),
                Carbon::parse($this->to)->endOfDay(),
            ]);
    }

    protected function calculateSummary(): void
    {
        $query = $this->baseQuery();

        $this->dataCount = (clone $query)->count();

        $this->totalAmount = (clone $query)->get()->sum(function ($row) {
            return
                (float) $row->price +
                (float) $row->hair_coloring_price +
                (float) $row->hair_extension_price +
                (float) $row->hair_extension_services_price;
        });

        $this->averageAmount = $this->dataCount > 0
            ? $this->totalAmount / $this->dataCount
            : 0;
    }

    public function query()
    {
        return $this->baseQuery()->orderBy('created_time', 'asc');
    }

    public function startCell(): string
    {
        return 'A3';
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Customer',
            'Cap',
            'Asisten',
            'Haircut Type',
            'Barber Name',
            'Colouring Other',
            'Sell Use Product',
            'Price',
            'Hair Coloring Price',
            'Hair Extension Price',
            'Hair Extension Services Price',
            'Total Penjualan',
            'QR',
            'Rincian',
            'Antrian',
        ];
    }

    public function map($row): array
    {
        $total =
            (float) $row->price +
            (float) $row->hair_coloring_price +
            (float) $row->hair_extension_price +
            (float) $row->hair_extension_services_price;

        return [
            optional($row->created_time)->format('Y-m-d H:i:s'),
            $row->customer,
            $row->capster?->inisial ?? $row->cap,
            $row->asistenCapster?->inisial ?? $row->asisten,
            $row->haircut_type,
            $row->barber_name,
            $row->colouring_other,
            $row->sell_use_product,
            (float) $row->price,
            (float) $row->hair_coloring_price,
            (float) $row->hair_extension_price,
            (float) $row->hair_extension_services_price,
            $total,
            $row->qr,
            $row->rincian,
            $row->antrian,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $lastDataRow = $this->dataCount + 3; // heading ada di row 3
                $summaryStartRow = $lastDataRow + 2;
                $lastColumn = 'P';

                // Judul
                $sheet->mergeCells("A1:{$lastColumn}1");
                $sheet->setCellValue('A1', 'Laporan Penjualan Customer Book');

                $sheet->getStyle('A1')
                    ->getFont()
                    ->setBold(true)
                    ->setSize(14);

                $sheet->getStyle('A1')
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->getStyle("A1:{$lastColumn}1")
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setRGB('DBEAFE');

                // Periode
                $sheet->mergeCells("A2:{$lastColumn}2");
                $sheet->setCellValue(
                    'A2',
                    'Periode: ' . Carbon::parse($this->from)->format('d M Y') .
                    ' s/d ' . Carbon::parse($this->to)->format('d M Y')
                );

                $sheet->getStyle('A2')
                    ->getFont()
                    ->setItalic(true);

                $sheet->getStyle('A2')
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->getStyle("A2:{$lastColumn}2")
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setRGB('F8FAFC');

                // Border untuk area data
                if ($this->dataCount > 0) {
                    $sheet->getStyle("A3:{$lastColumn}{$lastDataRow}")
                        ->getBorders()
                        ->getAllBorders()
                        ->setBorderStyle(Border::BORDER_THIN);
                }

                // Header style
                $sheet->getStyle('A3:P3')
                    ->getFont()
                    ->setBold(true)
                    ->getColor()
                    ->setRGB('FFFFFF');

                $sheet->getStyle('A3:P3')
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setRGB('4F46E5');

                $sheet->getStyle('A3:P3')
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);

                // Isi data
                if ($this->dataCount > 0) {
                    $sheet->getStyle("A4:{$lastColumn}{$lastDataRow}")
                        ->getAlignment()
                        ->setVertical(Alignment::VERTICAL_CENTER);

                    $sheet->getStyle("I4:M{$lastDataRow}")
                        ->getNumberFormat()
                        ->setFormatCode('#,##0.00');

                    $sheet->getStyle("A4:P{$lastDataRow}")
                        ->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setRGB('FFFFFF');
                }

                // Summary box
                $sheet->setCellValue("A{$summaryStartRow}", 'Jumlah Data');
                $sheet->setCellValue("B{$summaryStartRow}", $this->dataCount);

                $sheet->setCellValue("A" . ($summaryStartRow + 1), 'Total Penjualan');
                $sheet->setCellValue("B" . ($summaryStartRow + 1), $this->totalAmount);

                $sheet->setCellValue("A" . ($summaryStartRow + 2), 'Rata-rata Penjualan');
                $sheet->setCellValue("B" . ($summaryStartRow + 2), $this->averageAmount);

                $sheet->getStyle("A{$summaryStartRow}:B" . ($summaryStartRow + 2))
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                $sheet->getStyle("A{$summaryStartRow}:A" . ($summaryStartRow + 2))
                    ->getFont()
                    ->setBold(true);

                $sheet->getStyle("A{$summaryStartRow}:B" . ($summaryStartRow + 2))
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setRGB('ECFDF5');

                $sheet->getStyle("B" . ($summaryStartRow + 1) . ":B" . ($summaryStartRow + 2))
                    ->getNumberFormat()
                    ->setFormatCode('#,##0.00');

                $sheet->getStyle("A{$summaryStartRow}:B" . ($summaryStartRow + 2))
                    ->getAlignment()
                    ->setVertical(Alignment::VERTICAL_CENTER);
            },
        ];
    }
}