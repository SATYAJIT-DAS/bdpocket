@extends('backend.layouts.app')

@section('content')
{{--    <h4 class="text-center text-muted"> ADD Admin Phone </h4>--}}
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">Add Admin Phone</h5>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-lg-3">
                            <label class="col-from-label">Phone</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="admin_phone" name="admin_phone" @if (\App\Models\OtpConfiguration::where('type', 'admin_phone')->first()->value != null) value="{{ \App\Models\OtpConfiguration::where('type', 'admin_phone')->first()->value }}" placeholder="+8801********" @endif  required>
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" onclick="updateSettings( this,'admin_phone')" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">Admin Sms Activation</h5>
                </div>
                <div class="card-body">
                    <label class="aiz-switch aiz-switch-success mb-0">
                        <input type="checkbox" onchange="updateSettings(this, 'admin_oder_sms_activaton')" @if(App\Models\OtpConfiguration::where('type', 'admin_oder_sms_activaton')->first() != null && \App\Models\OtpConfiguration::where('type', 'admin_oder_sms_activaton')->first()->value == 1) checked @endif>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('script')
    <script type="text/javascript">
        function updateSettings(el,type){
            var value = null;
            if($(el).is('button')){
                 value = $('#admin_phone').val();
            }
            else if($(el).is('input')){
                if($(el).is(':checked')){
                     value = 1;
                }
                else{
                     value = 0;
                }
            }

            $.post('{{ route('otp_configurations.update.activation') }}', {_token:'{{ csrf_token() }}', type:type, value:value}, function(data){
                if(data == 1){
                    AIZ.plugins.notify('success', '{{ translate('Settings updated successfully') }}');
                }
                else{
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }
    </script>
@endsection
