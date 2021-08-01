<title>HOME | True Values - Design and Construction.</title>

@extends('layouts.master')
@section('content')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-car icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div>Analytics Dashboard
                    <div class="page-title-subheading">This is an example dashboard created using build-in elements and components.
                    </div>
                </div>
            </div>
        </div>
    </div>            
    
    @livewire('admin.attendance.widget-attendance')
    
    @livewire('admin.payroll.payroll-widget')
    

@endsection