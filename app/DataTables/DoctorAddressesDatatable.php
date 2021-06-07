<?php

namespace App\DataTables;

use App\Models\District;
use App\Models\Doctor;
use App\Models\DoctorAddress;

use Yajra\DataTables\Services\DataTable;

class DoctorAddressesDatatable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
            ->addColumn('checkbox', 'admin.doctor.doctor-addresses.btn.checkbox')
            ->addColumn('actions', 'admin.doctor.doctor-addresses.btn.actions')
            ->rawColumns([
                'checkbox',
                'actions',
            ]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\DoctorDegreeDatatable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return DoctorAddress::query()->with(['doctor','district']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
        ->columns($this->getColumns())
        ->minifiedAjax()
        ->parameters([
            'dom'        => 'Blfrtip',
            'lengthMenu' => [[10, 25, 50, 100], [10, 25, 50, 100]],
            'buttons'    => [
                ['text'   => '<i class="fa fa-plus" style="margin-right:2px;"></i> '.trans('admin.add'), 'className' => 'btn btn-info ajax-create'],
                ['text'   => '<i class="fa fa-trash"></i>', 'className' => 'btn btn-danger delBtn'],
                ['extend' => 'csv', 'className' => 'btn btn-info', 'text' => '<i class="fas fa-file-csv" style="margin:0 2px;"></i> '.trans('admin.ex_csv')],
                ['extend' => 'excel', 'className' => 'btn btn-success', 'text' => '<i class="fas fa-file-excel" style="margin:0 2px;"></i> '.trans('admin.ex_excel')],
                ['extend' => 'pdfHtml5', 'className' => 'btn btn-warning', 'text' => '<i class="fas fa-file-pdf" style="margin:0 2px;"></i> '.trans('admin.ex_pdf')],
                ['extend' => 'print', 'className' => 'btn btn-primary', 'text' => '<i class="fas fa-print"></i>'],
                ['extend' => 'reload', 'className' => 'btn btn-default', 'text' => '<i class="fas fa-sync-alt"></i>'],
            ],
            'initComplete' => ' function () {
                this.api().columns([3,4,5,6]).every(function () {
                    var column = this;
                    var input = document.createElement("input");
                    $(input).appendTo($(column.footer()).empty())
                    .on("keyup", function () {
                        column.search($(this).val(), false, false, true).draw();
                    });
                });
            }',
            'language'   => datatableLang(),
            'responsive' => true,
            'autoWidth'  => true,

        ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        // dd(Doctor::where('id', 1)
        // ->pluck('name_en')
        // ->all()[0]);
        return [
            [
                'name'          => 'checkbox',
                'data'          => 'checkbox',
                'title'         => '<input type="checkbox" class="check_all" onclick="check_all()" style="width:20px"/>',
                'exportable'    => false,
                'printable'     => false,
                'orderable'     => false,
                'searchable'    => false,
            ], [
                'name'  => 'id',
                'data'  => 'id',
                'title' => trans('admin.admin_id'),
            ], [
                'name'  => 'doctor id',
                'data'  => 'doctor_id',
                'title' => trans('admin.doctor_id'),
            ],[
                'name'  => 'doctor name',
                'data'  => 'doctor.name_'. session('lang'),
                'title' => trans('doctor.name_'. session('lang')),
            ],[
                'name'  => 'district name',
                'data'  => 'district.name_'. session('lang'),
                'title' => trans('admin.district'),
            ],[
                'name'  => 'address_' . session('lang'),
                'data'  => 'address_' . session('lang'),
                'title' => trans('admin.address'),
            ], [
                'name'  => 'fees',
                'data'  => 'fees',
                'title' => trans('doctor.fees'),
            ], [
                'name'  => 'created_at',
                'data'  => 'created_at',
                'title' => trans('admin.created_at'),
            ], [
                'name'       => 'actions',
                'data'       => 'actions',
                'title'      => trans('admin.actions'),
                'exportable' => false,
                'printable'  => false,
                'orderable'  => false,
                'searchable' => false,
            ],

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'DoctorDegree_' . date('YmdHis');
    }
}
