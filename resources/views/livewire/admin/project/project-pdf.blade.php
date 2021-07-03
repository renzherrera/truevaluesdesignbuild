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
        <h5 class=" mb-2 text-center"><strong>List of Projects</strong></h5>

        <table  class="table table-striped table-bordered " >
                                
            <thead>
                <tr>
                    <th style="width: 30px;" class="text-center"></th>
                    <th style="width: 100%;">Project Name</th>
                    <th style="width: 100%;">Owner</th>
                    <th style="width: 100%;">Estimated Budget</th>
                    <th style="width: 100%;">Service</th>
                    <th style="width: 100%;">Status</th>

                    {{-- <th>Job Description</th> --}}
                </tr>
    
            </thead>
            <tbody>
                @if($projects->count() < 1)
                    <tr><td colspan="4" class="text-center"><h4>No Project found</h4></td></tr>
                
                @endif
                @foreach ($projects as $index => $project)
                                        <tr>
                                           <td>{{$index+1}}</td>
                                            <td>
                                                <div class="media-body flex items-center">
                                                    <h2 class="name mb-0 text-sm">{{$project->project_name}}</h2>
                                                    <p class="text-xs mb-0">{{$project->project_location}}</p>
                                                </div>
                                            </td>
                                            <td>{{$project->project_owner}}</td>
                                            <td><span>&#8369; </span>{{number_format($project->estimated_budget,2)}}</td>
                                            
                                            <td>
                                                @foreach ($project->services as $projectServicetype)
                                                        @if ($project->count() < 2)
                                                        {{$projectServicetype->service_name}}
                                                        @elseif (!$loop->last)
                                                        {{$projectServicetype->service_name}},

                                                        @else
                                                        {{$projectServicetype->service_name}}

                                                        @endif
                                                @endforeach
                                             </td>


                                                @if ($project->project_status == "1")
                                                <td class="text-center">
                                                    <span class="badge ">Active</span>
                                                </td>
                                                @elseif ($project->project_status == "2")
                                                <td class="text-center">
                                                    <span class="badge ">Completed</span>
                                                </td>
                                                @elseif ($project->project_status == "3")
                                                <td class="text-center">
                                                    <span class="badge ">Pending</span>
                                                </td>
                                                @elseif ($project->project_status == "4")
                                                <td class="text-center">
                                                    <span class="badge  ">Stopped</span>
                                                </td>
                                                @endif    
                                        </tr>    
                                        @endforeach
                
            </tbody>
        </table>
    </div>
    
    
</body>
</html>