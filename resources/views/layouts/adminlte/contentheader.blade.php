<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">@yield('title', 'NCIP-EAPIS')</h1>
            </div>
            <div class="col-sm-6">
                <!-- <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    @php
                    $link = ""
                    @endphp
                    @for ($i = 1; $i <= count(Request::segments()); $i++) @if (($i < count(Request::segments())) & ($i> 0))
                        @php
                            $link .= "/" . Request::segment($i);
                        @endphp
                        <li class="breadcrumb-item">
                            <a href="<?= $link ?>">{{ ucwords(str_replace('-', ' ', Request::segment($i))) }}</a>
                        </li>
                        @else
                        <li class="breadcrumb-item">{{ ucwords(str_replace('-', ' ', Request::segment($i))) }}</li>
                        @endif
                    @endfor
                </ol> -->
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->