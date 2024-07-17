@extends('layouts.auth.redesign')

@push('header-content')
    @include('partials.auth.header')
@endpush

@section('content')

    <div class="row align-items-center justify-content-center">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="container-wrapper">
                <div class="container-body">
                    <div class="row mt-1">
                        <div class="col-12">
                            <div class="payment-text text-white">
                                Donec facilisis tortor ut augue lacinia, at viverra est semper. Sed sapien metus, scelerisque nec pharetra id, tempor a tortor.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-body">
                    <ul class="custom-list-group list-group-white mb-3">
                        <li>
                            <div class="list-element">
                                <span>Citizen Kane - Legend</span>
                                <span>£30.00</span>
                            </div>
                        </li>
                        <li>
                            <div class="list-element">
                                <span>Richard’s Team - Legend</span>
                                <span>£30.00</span>
                            </div>
                        </li>
                        <li class="font-weight-bold">
                            <div class="list-element">
                                <span>Total</span>
                                <span>£60.00</span>
                            </div>
                        </li>
                    </ul>

                    {{-- <div class="table-responsive">
                        <table class="table custom-table">
                            <tbody>
                                <tr>
                                    <td>Citizen Kane - Legend</td>
                                    <td class="text-right">£30.00</td>
                                </tr>
                                <tr>
                                    <td>Richard’s Team - Legend</td>
                                    <td class="text-right">£30.00</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <td>Total</td>
                                <td class="text-right">£60.00</td>
                            </tfoot>
                        </table>
                    </div> --}}
                    <div class="receipt-number text-white">Receipt #0018492</div>
                    <div class="my-3">
                        <button type="submit" class="btn btn-primary btn-block">Done</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('footer-content')
    @include('partials.auth.footer')
@endpush
