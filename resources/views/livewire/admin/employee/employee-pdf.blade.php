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
        <h5 class=" mb-2 text-center"><strong>List of Employees</strong></h5>

        <table  class="table table-striped mt-2"  style=""   >
                                
            <thead>
                <style>
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
               
                
                </style>
               
                <tr>
                    <th style="width: 30%;">Employee Name</th>
                    <th>Position</th>
                    <th>Gender</th>
                    <th>Designated</th>
                    <th class="text-center">Status</th>

                </tr>

            </thead>
            <tbody>
                @if($employees->count() < 1)
                    <tr><td colspan="11" class="text-center"><h4>No employee data found</h4></td></tr>
                
                @endif
                @foreach ($employees as $employee)
                <tr>
                  
                    <td>
                        <div class="media-body flex items-center">
                            <h2 class="name mb-0 text-sm">{{$employee->first_name .' '. $employee->middle_name.' '. $employee->last_name}}</h2>
                           
                        </div>
                    </td>
                    <td>{{$employee->position->position_title}}</td>
                    <td>{{ucwords($employee->gender)}}</td>

                    @if($employee->project)
                    <td>{{$employee->project->project_name}}</td>
                    @else
                    <td></td>
                    @endif
                        @if ($employee->status == "1")
                        <td class="text-center">
                            <span class="badge badge-secondary text-xs"><small>Active</small></span>
                        </td>
                        @else
                        <td class="text-center">
                            <span class="badge badge-secondary text-xs"><small>Inactive</small></span>
                        </td>
                        @endif    
                    
                </tr>    
                @endforeach
                
            </tbody>
        </table>
    </div>
    
    
</body>
</html>