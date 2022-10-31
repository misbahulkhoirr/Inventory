<?php

namespace App\Exports;

use App\Models\Mutasi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ProductExport implements FromView, WithColumnFormatting
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $start;
    private $end;
    private $supplier;
    private $gudang;
    private $type;
    private $where;

    public function __construct(string $start, string $end, string $supplier, string $gudang, string $type)
    {
        $this->start = date('Y-m-d',strtotime($start));
        $this->end = date('Y-m-d',strtotime($end));
        $this->supplier = $supplier == 'all' ? null : $supplier;
        $this->gudang = $gudang == 'all' ? null : $gudang;
        $this->type = $type;
        if ($this->type == 'In') {
            $this->where = 'supplier_id';
        }else{
            $this->where = 'product_id';
        }
    }

    public function view(): View
    {
        $datas =  Mutasi::whereBetween('created_at',[$this->start.' 00:00:00',$this->end.' 23:59:59'])->where($this->where,'ILIKE',$this->supplier)->where('gudang_id','ILIKE',$this->gudang)->where('mutasi',$this->type)->get();
        return view('exports.product', [
            'datas' => $datas,
            'type'=>$this->type
        ]);
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A1:O1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },
        ];
    }
    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}
