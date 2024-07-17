@extends('layouts.auth.redesign')

@push('header-content')
    @include('partials.auth.header')
@endpush

@push('plugin-styles')
    <link rel="stylesheet" href="{{ asset('js/plugins/datetimepicker/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/codebase/js/plugins/select2/css/select2.min.css') }}">
@endpush

@push('plugin-scripts')
    <script src="{{ asset('themes/codebase/js/plugins/moment/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('js/plugins/fileuploader/dist/jquery.fileuploader.min.js') }}" type="text/javascript"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script> --}}
@endpush

@section('content')

    <div class="row align-items-center justify-content-center">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="container-wrapper">
                <div class="container-body">
                    <div class="row mt-1">
                        <div class="col-12 text-white">
                            <form action="" method="POST" class="user-account-form">
                                <h6 class="section-title">Basic Information</h6>

                                <div class="form-group">
                                    <label for="first-name">First Name</label>
                                    <input type="text" class="form-control" id="first-name" name="first-name">
                                </div>
                                <div class="form-group">
                                    <label for="last-name">Last Name</label>
                                    <input type="text" class="form-control" id="last-name" name="lirst-name">
                                </div>
                                <div class="form-group">
                                    <label for="dob" class="required">Date of Birth</label>
                                    <input type="text" class="form-control dob-datetimepicker"
                                            id="dob"
                                            name="dob"
                                            value=""
                                            placeholder="DD/MM/YYYY"
                                            data-date-format="DD/MM/Y"
                                            data-date-end-date="0d"
                                            data-week-start="1"
                                            data-autoclose="true"
                                            data-today-highlight="true"
                                            autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label>Please send me:</label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="game-updates">
                                        <label class="custom-control-label" for="game-updates">News about game updates</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="from-partners">
                                        <label class="custom-control-label" for="from-partners">News from our partners</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email-id">Email Address</label>
                                    <input type="email" class="form-control" id="email-id" name="email-id">
                                </div>
                                <div class="form-group">
                                    <label for="pwd">Password</label>
                                    <input type="password" class="form-control" id="pwd" name="pwd">
                                </div>
                                <div class="form-group">
                                    <label for="display-name">Display Name</label>
                                    <input type="text" class="form-control" id="display-name" name="display-name">
                                </div>

                                <h6 class="section-title">Contact details</h6>
                                <div class="form-group">
                                    <label for="address-line-1">Address 1</label>
                                    <textarea class="form-control" id="address-line-1" name="address-line-1" rows="1" placeholder="12 York Place"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="address-line-2">Address 2</label>
                                    <textarea class="form-control" id="address-line-2" name="address-line-2" rows="1"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="city-name">Town/City</label>
                                    <input type="text" class="form-control" id="city-name" name="city-name" placeholder="Brighton">
                                </div>
                                <div class="form-group">
                                    <label for="country-name">Country</label>
                                    <input type="text" class="form-control" id="country-name" name="country-name" placeholder="United Kingdom">
                                </div>
                                <div class="form-group">
                                    <label for="postcode">Postcode</label>
                                    <input type="text" class="form-control" id="postcode" name="postcode" placeholder="BN1 2PL">
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <select class="country-code-select2">
                                                <option value="+44">+44</option>
                                                <option value="+91">+91</option>
                                            </select>
                                        </div>
                                        <input type="text" class="form-control" id="phone" name="phone">
                                    </div>
                                </div>

                                <h6 class="section-title">Profile</h6>
                                <div class="form-group">
                                    <label for="about-user">About me</label>
                                    <textarea class="form-control" id="about-user" name="about-user" rows="3"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="photograph">Photograph</label>
                                    <input type="file" name="files">
                                    {{-- <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="inputGroupFile01">
                                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="form-group">
                                    <label for="favourite-club" class="d-block">Favourite Club</label>
                                    <select id="favourite-club" class="club-select2 input-group-addon">
                                        <option value="Brighton and Hove Albion">Brighton and Hove Albion</option>
                                        <option value="Hove Albion">Hove Albion</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block">Save and continue</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('page-scripts')
    <script src="{{ asset('js/plugins/fileuploader/dist/custom.js') }}" type="text/javascript"></script>
    <script>
        $(function () {
            $('.dob-datetimepicker').datetimepicker({
            });
            $('.country-code-select2').select2();
            $('.club-select2').select2();
        });
    </script>
@endpush
