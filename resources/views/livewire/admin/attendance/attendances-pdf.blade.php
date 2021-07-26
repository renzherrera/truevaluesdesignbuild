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
        <h5 class=" mb-2 text-center"><strong>List of Attendances</strong></h5>
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
        @if($unenrolledId)
        <h6><strong>Unenrolled ID:</strong> {{$unenrolledId}}</h6>
        @endif
        </div>

        

        <div class="float-right">
        @if($lateCounts)
        <h6 class="text-right"><strong>Lates:</strong>  {{$lateCounts}}</h6>
        @endif
        @if($noTimeOutRecords)
        <h6 class="text-right"><strong>No time-out Records:</strong>  {{$noTimeOutRecords}}</h6>
        @endif
        <h6 class="text-right"><strong>Incomplete work hrs / Early Out:</strong> {{$earlyOutCounts}}</h6>
        </div>

        <table  class="table table-striped table-bordered" id="position-table" >
                                    
            <thead>
                <tr>
                    <th width="80px">Emp ID</th>
                    <th width="200px">Name</th>
                    <th>Biometric ID</th>
                    <th width="180px">Date</th>
                    <th>Time-in</th>
                    <th>Time-out</th>
                    <th>Total Hours</th>
                    <th>Time-in <small>[Overtime]</small></th>
                    <th>Time-out <small>[Overtime]</small></th>
                    <th>Ot Hours</th>
                </tr>

            </thead>
            <tbody>
                @if($attendances->count() < 1)
                    <tr><td colspan="100%" class="text-center"><h4>No attendance data found.</h4></td></tr>
                
                @endif
                    
                @foreach ($attendances as $attendance)

                <tr>
                    {{-- @dd($attendance->employees->schedule->start_time) --}}
                    <td><span class="text-muted ">#&nbsp;</span>{{$attendance->employees->id}}</td>
                    <td>{{$attendance->employees->first_name . ' ' . $attendance->employees->middle_name .' ' . $attendance->employees->last_name}}</td>
                    <td><span class="text-muted">#&nbsp;</span>{{$attendance->biometric_id}}</td>
                    <td>{{ Carbon\Carbon::parse($attendance->attendance_date)->format('F d, Y') }}</td>
                    <td>{{ Carbon\Carbon::parse($attendance->first_onDuty)->format('g:i A') }}</td>
                    <td class="text-center">
                        @if ($attendance->first_offDuty)
                        {{ Carbon\Carbon::parse($attendance->first_offDuty)->format('g:i A') }}
                        @elseif($attendance->second_onDuty && !$attendance->second_offDuty)
                        {{ Carbon\Carbon::parse($attendance->second_onDuty)->format('g:i A') }}
                        @else
                        -
                        @endif
                    </td>
                    @php
                    $timeIn = \Carbon\Carbon::parse($attendance->first_onDuty);
                    $timeOut = \Carbon\Carbon::parse($attendance->first_offDuty);
                    $ottimeIn = \Carbon\Carbon::parse($attendance->second_onDuty);
                    $ottimeOut = \Carbon\Carbon::parse($attendance->second_offDuty);
                    $otdiffInHours = round($ottimeOut->diffInMinutes($ottimeIn) / 60) ; 
                   
                    if ($attendance->first_offDuty){
                    $diffInHours = round($timeOut->diffInMinutes($timeIn) / 60);
                        if($diffInHours >4){
                        $diffInHours = round($timeOut->diffInMinutes($timeIn) / 60) - 1; 
                            }
                    }
                    elseif($attendance->second_onDuty && !$attendance->first_offDuty){
                    $diffInHours = round($ottimeIn->diffInMinutes($timeIn) / 60);
                    if($diffInHours > 8){
                        $diffInHours =8;
                    }
                    }
                    else {
                    $diffInHours= 4;
                    }

                    // if($diffInHours >4){
                    // $diffInHours = round($timeOut->diffInMinutes($timeIn) / 60) - 1; 
                    // }
                   
                    if($otdiffInHours >4){
                    $otdiffInHours = round($ottimeOut->diffInMinutes($ottimeIn) / 60) - 1; 
                    }
                    
                    if (!$attendance->second_offDuty){ 
                        $otdiffInHours= 0;
                    }
                   
                   @endphp
                <td style="font-weight: 700" class="text-center {{$diffInHours >= 8 ? 'text-primary' : ($diffInHours < 8 && $diffInHours > 4 ? 'text-warning' : 'text-danger')}}">{{$diffInHours}}</td>
                    <td>
                        @if ($attendance->second_onDuty && $attendance->second_offDuty)
                        {{ Carbon\Carbon::parse($attendance->second_onDuty)->format('g:i A') }}
                        @else
                        -
                        @endif
                    </td>
                  
                    <td>
                        @if ($attendance->second_offDuty)
                        {{ Carbon\Carbon::parse($attendance->second_offDuty)->format('g:i A') }}
                        @else
                        -
                        @endif
                    </td>
                    <td style="font-weight: 700" class="text-center {{$otdiffInHours >= 8 ? 'text-primary' : ($otdiffInHours < 8 && $otdiffInHours > 4 ? 'text-warning' : ($otdiffInHours == 0 ? 'text-dark' : 'text-danger'))}}">
                      
                        @if ($otdiffInHours == 0)
                        -
                        @else
                        {{$otdiffInHours}}
                        @endif
                    </td>

                    
                </tr>    
                @endforeach
                
            </tbody>
          </table>
    </div>
    
    
</body>
</html>