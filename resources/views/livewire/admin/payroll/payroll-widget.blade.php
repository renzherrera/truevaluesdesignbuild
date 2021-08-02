<div>
    <div class="row">
        <div class="col-lg-6 col-xl-3">
            <div class="card mb-3 widget-content">
                <div class="widget-content-wrapper">
                    <div class="widget-content-left">
                        <div class="widget-heading">Total Pay-Run</div>
                        <div class="widget-subheading">Total Payrolls: <strong>{{$payrolls}}</strong></div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-success"><span>{{$totalSalary}}</span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-xl-3">
            <div class="card mb-3 widget-content">
                <div class="widget-content-wrapper">
                    <div class="widget-content-left">
                        <div class="widget-heading">Total Paid Salaries</div>
                        <div class="widget-subheading">Paid Payrolls: <strong>{{$paidCounts}}</strong></div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-primary"><span>{{$paidSalary}}</span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-xl-3">
            <div class="card mb-3 widget-content">
                <div class="widget-content-wrapper">
                    <div class="widget-content-left">
                        <div class="widget-heading">Total Pending Salaries</div>
                        <div class="widget-subheading">Pending Payrolls : <strong>{{$pendingCounts}}</strong></div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-warning"><span>{{$pendingSalary}}</span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-xl-3">
            <div class="card mb-3 widget-content">
                <div class="widget-content-wrapper">
                    <div class="widget-content-left">
                        <div class="widget-heading">Total Approved Salaries</div>
                        <div class="widget-subheading">Approved Payrolls: <strong>{{$approvedCounts}}</strong></div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-danger"><span>{{$approvedSalary}}</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
