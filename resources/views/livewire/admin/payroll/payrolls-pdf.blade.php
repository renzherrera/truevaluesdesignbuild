<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('/main.css') }}" rel="stylesheet">

    <title>List of Employees -  True Values</title>
</head>
<body>
    <style>
         div.page_break + div.page_break{
        page-break-after: always;
}
        thead {
            display: table-header-group;
        }
        tfoot {
            display: table-row-group;
        }
        tr {
            page-break-inside: avoid;
        }
        .table{
            table-layout: fixed !important;
    
        }
        tbody{
            font-size: 16px;
        }
        thead tr{
            font-size: 22px;
            font-weight: bold;
        }
        h6 {
            font-size: 12px;
            margin-top: -5px;
        }
        h5{
            padding-top: 25px;
        }
        .text-xs
        {
            font-size: .69rem !important;
            font-weight: 300;

        }
        .text-sm
        {
            font-size: .875rem !important;
            font-weight: 500;
        }
        .media-body
        {
            flex: 1 1;
        }
        th{
            font-size: 15px;
        }
</style>
   
   <div class="col-md-12 ">
        <h5 class=" mb-2 text-center"><strong>{{$allMode ? 'List of All Payrolls' : ($approvedMode ? 'List of Approved Payrolls' : 'List of Pending Payrolls')}}</strong></h5>
        <div class="float-left">
        @if($projectName)
        <h6><strong>Department/Project:</strong>  {{$projectName->project_name}}</h6>
        @else
        <h6><strong>Department/Project:</strong>  All</h6>
        @endif
        @if($date_filter)
        <h6><strong>Date:</strong> {{$date_filter}}</h6>
        @else
        <h6><strong>Date:</strong> All</h6>
        @endif
        </div>

        

        <div class="float-right">
        <h6 class="text-right"><strong>Payroll Counts: </strong> {{$payrolls->count()}}</h6>
        <h6 class="text-right"><strong>Prepared By: </strong>  {{auth()->user()->name}}</h6>
        </div> 

        <table  class="table table-striped " id="position-table" >
                                    
            <thead>
                <tr>
                    <th width="200px">ID</th>
                    <th>Payroll Title</th>
                    <th>No. of Employees</th>
                    <th class="text-center">Payroll Date</th>
                    <th class="text-center">Project / Department</th>
                    <th class="text-center">Pay Run</th>
                    <th class="text-center">Status</th>
                </tr>

            </thead>
            <tbody>
                @if($payrolls->count() < 1)
                    <tr><td colspan="6" class="text-center"><h4>No payroll data found</h4></td></tr>
                
                @endif
                @foreach ($payrolls as $payroll)
                <tr>
                    <td># {{$payroll->id}}</td>
                    <td>{{$payroll->payroll_description}}</td>
                    <td>{{$payroll->payrolls->count()}}</td>
                    <td class="text-center">{{Carbon\Carbon::parse($payroll->payroll_from_date)->format('F d, Y') .' - '.Carbon\Carbon::parse($payroll->payroll_to_date)->format('F d, Y') }}</td>
                    <td class="text-center">
                        @if ($payroll->project_id)
                        {{$payroll->projects->project_name}}
                        @else
                        All
                        @endif
                    </td>
                    <td><span>&#8369;</span>{{number_format($payroll->payrolls->sum('total_net_pay'),2)}}</td>
                    <td class="text-center">
                        <span class="badge mr-2  badge-sm badge-pill
                        @if ($payroll->payroll_status == "approved")
                        badge-success
                        @elseif($payroll->payroll_status == "printed")
                        badge-primary
                        @elseif($payroll->payroll_status == "pending")
                        badge-warning
                        @endif
                        ">{{ucwords($payroll->payroll_status)}}
                        </span>
                    </td>
                    
                </tr>    
                @endforeach
                
            </tbody>
          </table>
    </div>
    
    
</body>
</html>