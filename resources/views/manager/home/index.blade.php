@extends('layouts.manager')

@section('page-title')
Dashboard
@endsection

@section('page-subtitle')
Welcome, {{ auth()->user()->first_name }}
@endsection

@section('content')
<!-- Icon Navigation -->
<div class="row gutters-tiny push">
    <div class="col-6 col-md-4 col-xl-2">
        <a class="block block-rounded block-bordered block-link-shadow text-center" href="javascript:void(0)">
            <div class="block-content">
                <p class="mt-5">
                    <i class="fal fa-home fa-3x text-muted"></i>
                </p>
                <p class="font-w600">Home</p>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <a class="block block-rounded block-bordered block-link-shadow ribbon ribbon-primary text-center" href="javascript:void(0)">
            <div class="ribbon-box">5</div>
            <div class="block-content">
                <p class="mt-5">
                    <i class="fal fa-gavel fa-3x text-muted"></i>
                </p>
                <p class="font-w600">Bids</p>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <a class="block block-rounded block-bordered block-link-shadow text-center" href="javascript:void(0)">
            <div class="block-content">
                <p class="mt-5">
                    <i class="fal fa-futbol fa-3x text-muted"></i>
                </p>
                <p class="font-w600">Leagues</p>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <a class="block block-rounded block-bordered block-link-shadow ribbon ribbon-primary text-center" href="javascript:void(0)">
            <div class="ribbon-box">3</div>
            <div class="block-content">
                <p class="mt-5">
                    <i class="fal fa-user-shield fa-3x text-muted"></i>
                </p>
                <p class="font-w600">Players</p>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <a class="block block-rounded block-bordered block-link-shadow text-center" href="javascript:void(0)">
            <div class="block-content">
                <p class="mt-5">
                    <i class="fal fa-exchange-alt fa-3x text-muted"></i>
                </p>
                <p class="font-w600">Transfers</p>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <a class="block block-rounded block-bordered block-link-shadow text-center" href="javascript:void(0)">
            <div class="block-content">
                <p class="mt-5">
                    <i class="fal fa-chart-line fa-3x text-muted"></i>
                </p>
                <p class="font-w600">Statistics</p>
            </div>
        </a>
    </div>
</div>
<!-- END Icon Navigation -->

<!-- Mini Stats -->
<div class="row">
    <div class="col-md-6 col-xl-3">
        <a class="block block-rounded block-bordered" href="javascript:void(0)">
            <div class="block-content p-5">
                <div class="py-30 text-center bg-body-light rounded">
                    <div class="font-size-h2 font-w700 mb-0 text-muted">78</div>
                    <div class="font-size-sm font-w600 text-uppercase">Points last week</div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-xl-3">
        <a class="block block-rounded block-bordered" href="javascript:void(0)">
            <div class="block-content p-5">
                <div class="py-30 text-center bg-body-light rounded">
                    <div class="font-size-h2 font-w700 mb-0 text-muted">278</div>
                    <div class="font-size-sm font-w600 text-uppercase">Points last month</div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-xl-3">
        <a class="block block-rounded block-bordered" href="javascript:void(0)">
            <div class="block-content p-5">
                <div class="py-30 text-center bg-body-light rounded">
                    <div class="font-size-h2 font-w700 mb-0 text-muted">4,500</div>
                    <div class="font-size-sm font-w600 text-uppercase">Total points</div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-xl-3">
        <a class="block block-rounded block-bordered" href="javascript:void(0)">
            <div class="block-content p-5">
                <div class="py-30 text-center bg-body-light rounded">
                    <div class="font-size-h2 font-w700 mb-0 text-muted">$19,700</div>
                    <div class="font-size-sm font-w600 text-uppercase">Total Earnings</div>
                </div>
            </div>
        </a>
    </div>
</div>
<!-- END Mini Stats -->
<!-- Progress -->
<div class="row">
    <div class="col-md-4">
        <div class="block block-rounded block-bordered">
            <div class="block-content block-content-full">
                <div class="py-20 text-center">
                    <div class="mb-20">
                        <i class="fal fa-coffee fa-3x"></i>
                    </div>
                    <div class="font-size-h4 font-w600">Pro plan</div>
                    <div class="text-muted">Active plan.</div>
                    <div class="pt-20">
                        <a class="btn btn-rounded btn-alt-primary" href="javascript:void(0)">
                            <i class="fal fa-arrow-up mr-5"></i> Upgrade to VIP
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="block block-rounded block-bordered">
            <div class="block-content block-content-full">
                <div class="py-20 text-center">
                    <div class="mb-20">
                        <i class="fal fa-user-tag fa-3x"></i>
                    </div>
                    <div class="font-size-h4 font-w600">+107 followers</div>
                    <div class="text-muted">Awesome!</div>
                    <div class="pt-20">
                        <a class="btn btn-rounded btn-alt-primary" href="javascript:void(0)">
                            <i class="fal fa-link mr-5"></i> Check them out
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="block block-rounded block-bordered">
            <div class="block-content block-content-full">
                <div class="py-20 text-center">
                    <div class="mb-20">
                        <i class="fal fa-envelope-open fa-3x"></i>
                    </div>
                    <div class="font-size-h4 font-w600">10,000 Subscribers</div>
                    <div class="text-muted">Keep it up!</div>
                    <div class="pt-20">
                        <a class="btn btn-rounded btn-alt-primary" href="javascript:void(0)">
                            <i class="fal fa-cog mr-5"></i> Manage list
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Progress -->
@endsection
