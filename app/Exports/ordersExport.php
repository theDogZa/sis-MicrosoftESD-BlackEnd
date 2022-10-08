<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Contracts\View\View;
// use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class OrdersExport implements FromView, ShouldAutoSize, WithStyles, WithColumnFormatting, WithCustomCsvSettings
{
    use Exportable;

    public function styles(Worksheet $sheet)
    {

        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],

            // // Styling a specific cell by coordinate.
            // 'B2' => ['font' => ['italic' => true]],

            // // Styling an entire column.
            // 'C'  => ['font' => ['size' => 16]],
        ];
    }

    public function columnFormats(): array
    {
        return [
            'E' => '#',
            'F' => '#',
            'G' => '#',
            'I' => '#',
            'J' => '#',
        ];
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ',',
            'use_bom' => true,
        ];
    }

    
    public function forSerach(array $search)
    {
        //$search = (object) $search;

        $results = Order::select('*');
        $results = $results->leftJoin('order_items', 'order_items.order_id', '=', 'orders.id')
        ->leftJoin('inventory', 'order_items.inventory_id', '=', 'inventory.id')
        ->leftJoin('billings', 'inventory.billing_id', '=', 'billings.id');

        //------ search
        $input = (object)[];
        if (count($search)) {
            $input = (object)$search;
            if (@$input->search) {
                $results = $this->_easySearch($results, $input->search);
            } else {
                $results = $this->_advSearch($results, $input);
            }
        }

        if (!@$input->sort) {
            $input->sort = 'sale_at';
            $input->direction = 'desc';
        }

        $results = $results->orderBy($input->sort, $input->direction)->get();

        $this->Orders = $results;

       // dd($this->Orders);

        return  $this;
    }

    public function view(): View
    {

        return view('exports.orders', [
            'orders' => $this->Orders
        ]);
    }


    protected function _easySearch($results, $search = "")
    {
        $results = $results->orWhere('orders.customer_name', 'LIKE', '%' . @$search . '%');
        $results = $results->orWhere('orders.email', 'LIKE', '%' . @$search . '%');
        $results = $results->orWhere('orders.tel', 'LIKE', '%' . @$search . '%');
        $results = $results->orWhere('orders.path_no', 'LIKE', '%' . @$search . '%');
        $results = $results->orWhere('orders.receipt_no', 'LIKE', '%' . @$search . '%');
        $results = $results->leftJoin('users', 'orders.sale_uid', '=', 'users.id')->orWhere('users.username', 'LIKE', '%' . @$search . '%');
        $results = $results->orWhere('orders.sale_at', 'LIKE', '%' . @$search . '%');
        $results = $results->orWhere('inventory.serial', 'LIKE', '%' . @$search . '%');
        $results = $results->orWhere('billings.sold_to', 'LIKE', '%' . @$search . '%');
        return $results;
    }

    protected function _advSearch($results, $input)
    {
        if (@$input->customer_name) {
            $results = $results->where('orders.customer_name', 'LIKE', "%" .  $input->customer_name . "%");
        }
        if (@$input->email) {
            $results = $results->where('orders.email', 'LIKE', "%" .  $input->email . "%");
        }
        if (@$input->tel) {
            $results = $results->where('orders.tel', 'LIKE', "%" .  $input->tel . "%");
        }
        if (@$input->path_no) {
            $results = $results->where('orders.path_no', 'LIKE', "%" .  $input->path_no . "%");
        }
        if (@$input->receipt_no) {
            $results = $results->where('orders.receipt_no', 'LIKE', "%" .  $input->receipt_no . "%");
        }
        if (@$input->serial) {
            $results = $results->where('inventory.serial', 'LIKE', "%" .  $input->serial . "%");
        }
        if (@$input->sale_uid) {
            $results = $results->where('orders.sale_uid',  $input->sale_uid);
        }
        if (@$input->sale_at_start && @$input->sale_at_end) {
            $sd = date_create($input->sale_at_start . "00:00:01");
            $sDate = date_format($sd, "Y-m-d H:i:s");
            $ed = date_create(@$input->sale_at_end . "23:59:59");
            $eDate = date_format($ed, "Y-m-d H:i:s");
            $results = $results->whereBetween('orders.sale_at',  [$sDate, $eDate]);
        }
        if (@$input->sold_to) {
            $results = $results->where('billings.sold_to', 'LIKE', "%" .  $input->sold_to . "%");
        }
        return $results;
    }
}
