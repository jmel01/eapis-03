<div class="col-12 col-sm-4">
    <div class="info-box bg-light">
        <div class="info-box-content">
            <a href="{{ route('formE') }}">
                <span class="info-box-text text-center text-muted">Administrative Cost</span>
                <span class="info-box-number text-center mb-0"><h1>{{ number_format($totalAdminCost, 2, '.', ',') }}</h1></span>
            </a>
        </div>
    </div>
</div>
<div class="col-12 col-sm-4">
    <div class="info-box bg-light">
        <div class="info-box-content">
            <a href="{{ route('formG') }}">
                <span class="info-box-text text-center text-muted">Grants Disbursement</span>
                <span class="info-box-number text-center mb-0"><h1>{{ number_format($totalGrantDisburse, 2, '.', ',') }}</h1><span>
            </a>
        </div>
    </div>
</div>
<div class="col-12 col-sm-4">
    <div class="info-box bg-light">
        <div class="info-box-content">
            <a href="{{ route('formF') }}">
                <span class="info-box-text text-center text-muted">TOTAL</span>
                <span class="info-box-number text-center mb-0"><h1>{{ number_format($totalAdminCost + $totalGrantDisburse, 2, '.', ',') }}</h1></span>
            </a>
        </div>
    </div>
</div>