<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('/main.css') }}" rel="stylesheet">

    <title>List Positions -  True Values</title>
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
            font-size: 14px;
            margin-top: -5px;
        }
        h5{
            padding-top: 5px;
            font-size: 21px;
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
        hr{
            margin-top: 9%;
            margin-bottom: 9%;
        }
</style>

    @foreach ($payrollSummaries as $payrollSummary)
    @php
        $perHour = $payrollSummary->salary_rate/8;
        $totalRegularHours = $payrollSummary->total_regular_hours;
        $totalOvertime = $payrollSummary->total_overtime_hours;
        $totalHours =  $totalRegularHours + $totalOvertime;
        $totalHolidayPay = $payrollSummary->regularholiday_pay + $payrollSummary->overtimeholiday_pay;
        $payGross = $payrollSummary->total_regular_pay + $payrollSummary->total_overtime_pay + $totalHolidayPay;
        $cashAdvance = $payrollSummary->cashadvances
                                      ->where('requested_date','>=',$payroll_from_date)
                                      ->where('requested_date','<=', $payroll_to_date)
                                      ->where('status','!=','paid')
                                      ->sum('cash_amount');
        $totalPay = $payGross - $cashAdvance;

    @endphp
        <div class="container-fluid mb-3" style="width: 100%; text-align:center">
            <div style="width: 100%">
                <div class="col-md-12 " >
                <img  src="{{public_path('storage/images/TV.png')}}" width="40%" alt="">
                <h5 class="text-center" style="letter-spacing: 2px;"><strong>PAYSLIP</strong></h5>
                <h6>{{Carbon\Carbon::parse($payroll_from_date)->format('F d, Y').' - '.Carbon\Carbon::parse($payroll_to_date)->format('F d, Y');}}</h6>

                </div>
            </div>
            <div class="mt-4" style="width: 100%; ">
            <div style="width:50%;float: left;">
               
                <h6 style="text-align: left" class="mb-2" >
                    <strong>Employee Name: </strong>{{$payrollSummary->first_name . ' ' . $payrollSummary->middle_name . ' ' . $payrollSummary->last_name}}
                </h6>
                <h6 style="text-align: left" class="mb-2" >
                    <strong>Position: </strong>{{$payrollSummary->position_title}}
                </h6>
                <h6 style="text-align: left" class="mb-4" >
                    <strong>Work Designated: </strong> {{$payrollSummary->project->project_name}}
                </h6> 
                
            </div>
            <div  style="width:50%; float: right; text-align: right;">
                <h6 style="text-align: right" class="mb-2" >
                    <strong>Total Working Hours: </strong> {{$totalHours}}

                </h6> 
                <h6 style="text-align: right" class="mb-2" >
                    <strong>Salary Rate per Day: </strong>{{number_format($payrollSummary->salary_rate,2)}}

                </h6> 
                <h6 style="text-align: right" class="mb-4" >
                    <strong>Schedule: </strong> 
                    {{Carbon\Carbon::parse($payrollSummary->schedule->start_time)->format('g:i A'). ' - '.  Carbon\Carbon::parse($payrollSummary->schedule->end_time)->format('g:i A')}}
                </h6> 
            </div>
            </div>

        </div>

    
   
        <table  class="table " style="margin-top: 10px;">
            <thead>
                <tr>
                    <th style="width: 100%;">EARNINGS</th>
                    <th style="width: 100%;">Hours</th>
                    <th style="width: 100%;">Rate</th>
                    <th style="width: 100%;">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Regular Hours</td>
                    <td>{{$totalRegularHours}}</td>
                    <td>&#8369; {{number_format($payrollSummary->salary_rate/8,2)}}</td>
                    <td>&#8369; {{number_format($payrollSummary->total_regular_pay,2)}}</td>


                </tr>
                <tr>
                    <td>Overtime Hours</td>
                    <td>{{$totalOvertime}}</td>
                    <td>&#8369; {{number_format($payrollSummary->salary_rate/8,2)}}</td>
                    <td>&#8369; {{number_format($payrollSummary->total_overtime_pay,2)}}</td>
                </tr>
                @if ($holidays > 0 && $payrollSummary->position->has_holiday)
                <tr>
                    <td>Holiday Pay</td>
                    <td></td>
                    <td></td>
                    <td>&#8369; {{number_format($totalHolidayPay,2)}}</td>
                </tr>
                @endif

            <tfoot> <tr>
                <th style="width: 100%;"></th>
                <th></th>
                <th>Salary Gross: </th>
                <th style="width: 20%;">&#8369; {{number_format($payGross,2) }}</th>
                </tr>
            </tfoot>
            <thead>
                <tr>
                    <th style="width: 100%;">DEDUCTIONS</th>
                    <th style="width: 100%;"></th>
                    <th style="width: 100%;"></th>
                    <th style="width: 100%;"></th>
                </tr>
            </thead>
            <tr>
                <td>Salary Advance</td>
                <td></td>
                <td></td>
                <td class="text-danger">-&#8369; {{number_format($cashAdvance,2)}}</td>
            </tr>
            {{-- <tfoot>
                <th style="width: 100%;"></th>
                <th ></th>
                <th>Total Deductions: </th>
                <th style="width: 20%;" class="text-danger">&#8369; {{number_format($cashAdvance,2)}}</th>
                </tr>
            </tfoot> --}}
            <tfoot>
                <th style="width: 100%;"></th>
                <th ></th>
                <th><h5><strong>Total Salary Net: </strong></h5></th>
                <th style="width: 20%;" class="text-lg"><h5><strong>&#8369; {{number_format($totalPay,2)}}</strong></h5></th>
                </tr>
            </tfoot>
            
                
            </tbody>
        </table>
        </div>


        <hr >

        @endforeach

        

    
</body>
</html>