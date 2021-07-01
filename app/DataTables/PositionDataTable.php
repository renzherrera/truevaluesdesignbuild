<?php

namespace App\DataTables;

use App\Models\Position;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
class PositionDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Position $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Position $model,Request $request)
    {
        // $data = Position::select();
        // return $this->applyScopes($data);
        // return $model->newQuery();
    //     $start_date = $this->request()->get('start_date');
    //     $end_date   = $this->request()->get('end_date');
        // $name       = $this->request()->get('name');
    //     $name       = 'Engineer';

    //    $query = $model->newQuery();
    //    $query = $query->where('position_title',$name);
      


        // return $query;


        $startDate = $request->get('from');
        $endDate = $request->get('to');

        $query = $model->newQuery();

        if($startDate && $endDate) {
            $query->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate);
        }

        return $query;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->columns([
                        ['data' => 'position_title', 'name' => 'position_title', 'title' => 'Position Title'],
                        ['data' => 'job_description', 'name' => 'job_description', 'title' => 'Job Description'],
                        ['data' => 'salary_rate', 'name' => 'salary_rate', 'title' => 'Salary Rate'],
                    ])
                    ->setTableId('position-table')
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->dom('Bfrtip')
                    ->buttons(
                        Button::make('csv'),
                        Button::make('excel'),
                        Button::make('pdf'),
                    )
                  
                    ->parameters([
                        'responsive' => true,
                        'autoWidth' => false,
                        'columnDefs' => [
                            ['targets' => [0], 'width' => '25%'],
                            ['targets' => [1], 'width' => '50%'],
                            ['targets' => [2], 'width' => '25%'],
                        ],
                        'buttons' => ['pdfHtml5'],

                       
                    ])
                      ;
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        // return [
        //     Column::make('position_title'),
        //     Column::make('job_description'),
        //     Column::make('salary_rate'),
        // //   'position_title',
        // //   'job_description',
        // //   'salary_rate',
        // ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Position_' . date('YmdHis');
    }
}
