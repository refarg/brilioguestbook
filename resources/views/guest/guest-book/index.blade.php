@extends('layouts.guest-onepage')
@section('main')
@php
    $now = Carbon\Carbon::now()->format('Y-m-d H:i:s');
@endphp
<div class="container-fluid d-flex flex-column g-4" style="margin-top: 5vh;">
    <div class="row">
        <div class="col-md-6 my-auto">
            <h2 class="text-center mb-2">Guest Message</h2>
            <div class="row g-1" style="overflow-y: auto; height: 60vh;">
                @if($data->count() == 0)
                   NO DATA
                @else
                    @foreach($data as $data)
                        <div class="card text-black" style="height: 125px;">
                            <div class="card-header">
                                <span>{{ $data->first_name . " " . $data->last_name }} <small>says...</small></span>
                                <span class="float-end">{{ Carbon\Carbon::parse($data->created_at)->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s'); }}</span>
                            </div>
                            <div class="card-body">
                                {{ $data->message }}
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="col-md-6 mt-4">
            <form action="{{ route('guestbook-submit') }}" id="guestbook-form" method="POST">
                @csrf
                @method('PUT')
                <div class="form-row">
                    <div class="form-group">
                        <div class="form-input">
                            <label for="first_name">First name</label>
                            <input type="text" class="form-control @if($errors->has('first_name')) is-invalid @endif" name="first_name" id="first_name" placeholder="Your first name" value="{{ old('first_name') }}" required/>
                            @if($errors->has('first_name'))
                                @foreach ($errors->get('first_name') as $message)
                                    <span id="firstNameInput-error" class="error invalid-feedback"> {{ $message }} </span>
                                @endforeach
                            @endif
                        </div>
                        <div class="form-input">
                            <label for="last_name">Last name</label>
                            <input type="text" class="form-control @if($errors->has('last_name')) is-invalid @endif" name="last_name" id="last_name" placeholder="Your last name" value="{{ old('last_name') }}" required/>
                            @if($errors->has('last_name'))
                                @foreach ($errors->get('last_name') as $message)
                                    <span id="lastNameInput-error" class="error invalid-feedback"> {{ $message }} </span>
                                @endforeach
                            @endif
                        </div>
                        <div class="form-input">
                            <label for="organization">Organization</label>
                            <input type="text" class="form-control @if($errors->has('organization')) is-invalid @endif" name="organization" id="organization" placeholder="Your organization name" value="{{ old('organization') }}"/>
                            @if($errors->has('organization'))
                                @foreach ($errors->get('organization') as $message)
                                    <span id="organizationInput-error" class="error invalid-feedback"> {{ $message }} </span>
                                @endforeach
                            @endif
                        </div>
                        <div class="form-input">
                            <label for="address">Address</label>
                            <input type="text" class="form-control @if($errors->has('address')) is-invalid @endif" name="address" id="address" placeholder="Your address" value="{{ old('address') }}"/>
                            @if($errors->has('address'))
                                @foreach ($errors->get('address') as $message)
                                    <span id="addressInput-error" class="error invalid-feedback"> {{ $message }} </span>
                                @endforeach
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="provinceInput">Province</label>
                            <select class="form-control select2 @if($errors->has('province')) is-invalid @endif" name="province" id="provinceInput" style="width: 100%;" required>
                                <option selected="selected" value="">Choose Province</option>
                                @foreach($province_datas as $province_data)
                                    <option value="{{ $province_data->code }}">{{ $province_data->name }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('province'))
                                @foreach ($errors->get('province') as $message)
                                    <span id="provinceInput-error" class="error invalid-feedback"> {{ $message }} </span>
                                @endforeach
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="cityInput">City</label>
                            <select class="form-control select2 @if($errors->has('city')) is-invalid @endif" id="cityInput" name="city" style="width: 100%;" required>
                                    <option selected="selected" value="">Choose City</option>
                            </select>
                            @if($errors->has('city'))
                                @foreach ($errors->get('city') as $message)
                                    <span id="cityInput-error" class="error invalid-feedback"> {{ $message }} </span>
                                @endforeach
                            @endif
                        </div>
                        <div class="form-input">
                            <label for="message">Message</label>
                            <textarea class="form-control @if($errors->has('message')) is-invalid @endif" name="message" id="message" placeholder="Your message" required>{{ old('message') }}</textarea>
                            @if($errors->has('message'))
                                @foreach ($errors->get('message') as $message)
                                    <span id="messageInput-error" class="error invalid-feedback"> {{ $message }} </span>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="form-group mt-3 float-end">
                        <input type="submit" class="submit btn btn-primary" id="submit" />
                        <input type="button" value="Reset" class="submit btn btn-secondary" id="resetButton" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('a-tmp/plugins/select2/js/select2.full.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.select2').select2();
        $('select[name="province"]').on('change', function(){
            if( this.value == ""){
                $('select[name="city"] option').each(function(){
                            if($(this).val() != "") $(this).remove();
                });
            } else {
                $.ajax({
                        url: "{{ route('get-city') }}",
                        type: "post",
                        data: {
                        "_token": $('input[name="_token"]').attr('value'),
                        "province_code": this.value,
                        },
                        success: function (response) {
                            let resp = response;
                            $('select[name="city"] option').each(function(){
                                if($(this).val() != "") $(this).remove();
                            });
                            $.each(resp, function(i, data){
                                @if(!empty($data->city_code))
                                    const citySelected = (data.code == {{ $data->city_code }}) ? "selected" : null;
                                @else
                                    const citySelected = null;
                                @endif
                                $('select[name="city"]').append("<option value=" + data.code + " " + citySelected + ">" + data.name + "</option>");
                            });
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            if(jqXHR.responseJSON.message.length >= 1){
                                toastr.error('Terjadi error:<br>'+jqXHR.responseJSON.message);
                            } else{
                                toastr.error('Terjadi error:<br>'+jqXHR.responseText);
                            }
                        }
                });
            }
        });
        $('select[name="province"]').trigger('change');
        $('#resetButton').on('click', function(){
            $('select[name="province"]').val("");
            $('select[name="province"]').trigger('change');
            document.querySelector("#guestbook-form").reset();
        });
    });
</script>
@endpush

@push('css')
<link rel="stylesheet" href="{{ asset('a-tmp/plugins/select2/css/select2.min.css') }}">
<style type="text/css">
    #wrapper{
        background:url('{{ asset('image/bg.jpg') }}') no-repeat center;
        background-size: cover;
    }
    .select2-container--default .select2-selection--single, .select2-selection .select2-selection--single {
        border: 1px solid #6c757d;
        padding: 6px 12px;
        height: 34px;
    }
    .select2-container .select2-selection--single .select2-selection__rendered {
        padding-right: 0px;
        padding-left: 0;
        margin-top: -4px;

    }
    .select2-container--default .select2-selection--single .select2-selection__arrow b {
        margin-top: 0;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 28px; right: 3px;
    }
</style>
@endpush