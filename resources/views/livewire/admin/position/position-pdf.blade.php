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
        h5 {
            padding-top: 25px;
        }
</style>
   
    <div class="col-md-12 ">
        <h5 class=" mb-2 text-center"><strong>List of Positions</strong></h5>


        <table  class="table table-striped table-bordered " >
                                
            <thead>
                <tr>
                    <th>ID</th>
                    <th class="title-col">Position Title</th>
                    {{-- <th>Job Description</th> --}}
                    <th>Salary Rate <small>(PER DAY)</small></th>
                </tr>
    
            </thead>
            <tbody>
                @if($positions->count() < 1)
                    <tr><td colspan="4" class="text-center"><h4>No data found</h4></td></tr>
                
                @endif
                @foreach ($positions as $position)
                <tr>
                   <td>{{$position->id}}</td>
                    <td width="500px">{{$position->position_title}}</td>
                    {{-- <td>{{$position->job_description}}</td> --}}
                    <td><span>&#8369; </span>{{number_format($position->salary_rate,2)}}</td>
                    
                </tr>    
                @endforeach
                
            </tbody>
        </table>
    </div>
    
    
</body>
</html>