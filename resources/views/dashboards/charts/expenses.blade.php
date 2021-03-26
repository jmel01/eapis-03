<div class="col-12 col-sm-4">
    <div class="info-box bg-light">
        <div class="info-box-content">
            <span class="info-box-text text-center text-muted">Total Disbursement</span>
            <span class="info-box-number text-center text-muted mb-0">{{ number_format($totalAdminCost + $totalGrantDisburse, 2, '.', ',') }}</span>
        </div>
    </div>
</div>
<div class="col-12 col-sm-4">
    <div class="info-box bg-light">
        <div class="info-box-content">
            <span class="info-box-text text-center text-muted">Total Administrative Cost</span>
            <span class="info-box-number text-center text-muted mb-0">{{ number_format($totalAdminCost, 2, '.', ',') }}</span>
        </div>
    </div>
</div>
<div class="col-12 col-sm-4">
    <div class="info-box bg-light">
        <div class="info-box-content">
            <span class="info-box-text text-center text-muted">Total Grants Disbursement</span>
            <span class="info-box-number text-center text-muted mb-0">{{ number_format($totalGrantDisburse, 2, '.', ',') }}<span>
        </div>
    </div>
</div>