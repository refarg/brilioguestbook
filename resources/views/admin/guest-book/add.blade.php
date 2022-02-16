@php
    $path = Request::path();
    $viewMode = strpos($path, 'view');
@endphp
@extends('layouts.app_admin')
@section('main')
<div class="row">
    <!-- left column -->
    <div class="col-12">
    <!-- general form elements -->
    <div class="card card-primary">
        <form id="guestbookForm" action="@if(!empty($data) && !$viewMode) {{ route('admin.guestbook.submit_edit', $data->id) }} @elseif($viewMode) {{ null }} @else {{ route('admin.guestbook.submit_new') }} @endif" method="POST">
        <!-- form start -->
        <div class="card-body">
            @csrf
            @if(empty($data))
                @method('PUT')
            @endif
            <div class="form-group">
                <label for="firstNameInput">First Name</label>
                <input type="text" name="first_name" class="form-control @if($errors->has('first_name')) is-invalid @endif" id="firstNameInput" placeholder="Enter First Name" value="{{ $data->first_name ?? old('first_name') }}" required>
                @if($errors->has('first_name'))
                    @foreach ($errors->get('first_name') as $message)
                        <span id="firstNameInput-error" class="error invalid-feedback"> {{ $message }} </span>
                    @endforeach
                @endif
            </div>
            <div class="form-group">
                <label for="lastNameInput">Last Name</label>
                <input type="text" name="last_name" class="form-control @if($errors->has('last_name')) is-invalid @endif" id="lastNameInput" placeholder="Enter Last Name" value="{{ $data->last_name ?? old('last_name') }}" required>
                @if($errors->has('last_name'))
                    @foreach ($errors->get('last_name') as $message)
                        <span id="lastNameInput-error" class="error invalid-feedback"> {{ $message }} </span>
                    @endforeach
                @endif
            </div>
            <div class="form-group">
                <label for="organizationInput">Organization</label>
                <input type="text" name="organization" class="form-control @if($errors->has('organization')) is-invalid @endif" id="organizationInput" placeholder="Enter Organization" value="{{ $data->organization ?? old('organization') }}">
                @if($errors->has('organization'))
                    @foreach ($errors->get('organization') as $message)
                        <span id="organizationInput-error" class="error invalid-feedback"> {{ $message }} </span>
                    @endforeach
                @endif
            </div>
            <div class="form-group">
                <label for="addressInput">Address</label>
                <input type="text" name="address" class="form-control @if($errors->has('address')) is-invalid @endif" id="addressInput" placeholder="Enter Address" value="{{ $data->address ?? old('address') }}">
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
                    @foreach($province as $province_data)
                        <option value="{{ $province_data->code }}" @if(!empty($data) && ($province_data->code == $data->province_code)) selected="selected" @endif>{{ $province_data->name }}</option>
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
            <div class="form-group">
                <label for="messageInput">Message</label>
                <textarea class="form-control @if($errors->has('message')) is-invalid @endif" id="messageInput" name="message" placeholder="Enter Message" required>{{ $data->message ?? old('message') }}</textarea>
                @if($errors->has('message'))
                    @foreach ($errors->get('message') as $message)
                        <span id="messageInput-error" class="error invalid-feedback"> {{ $message }} </span>
                    @endforeach
                @endif
            </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <a href="{{ route('admin.guestbook.index') }}" class="btn btn-success float-left">Back</a>
            @if(!$viewMode)<button type="submit" class="btn btn-primary float-right">Submit</button>@endif
        </div>
        </form>
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
        @if($viewMode)
        $("#guestbookForm input, select, textarea").each(function(){
            $(this).attr("disabled", "disabled");
        })
        @endif
    });
</script>
@endpush

@push('css')
<link rel="stylesheet" href="{{ asset('a-tmp/plugins/select2/css/select2.min.css') }}">
<style>
    .dark-mode .select2-container--default .select2-selection--single, .select2-selection .select2-selection--single {
        border: 1px solid #6c757d;
        padding: 6px 12px;
        height: 34px;
        background: transparent;
    }
    .dark-mode .select2-container .select2-selection--single .select2-selection__rendered {
        padding-right: 10px;
        padding-left: 0;
        color: #fff;
    }
    .dark-mode .select2-container--default .select2-selection--single .select2-selection__arrow b {
        margin-top: 0;
    }
    .dark-mode .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 28px; right: 3px;
    }
</style>
@endpush