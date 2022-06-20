@extends('layouts.app_plain')
@section('title', 'Check In - Check Out')

@section('content')
    <div class="col-md-8 mx-auto">
        <div class="card p-4">
            <div class="visible-print text-center">
                <p class="mb-0">QR Code</p>
                {!! QrCode::size(280)->generate(Hash::make(now()->format('Y-m-d'))) !!}
                <p>Please scan QR code to checkin or checkout.</p>
            </div>
            <hr>
            <div class="text-center">
                <p>Pin Code</p>
                <input type="text" name="mycode" id="pincode-input1">
                <p class="my-4">Please enter your pin code to checkin or checkout</p>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
            $('#pincode-input1').pincodeInput({
                inputs: 6,
                complete: function(value, e, errorElement) {
                    console.log("code entered: " + value);

                    $.ajax({
                        url: "/checkin-checkout/store",
                        method: "POST",
                        data: {
                            "pin_code": value
                        },
                        success: function(res) {
                            if (res.status == 'success') {
                                Toast.fire({
                                    icon: 'success',
                                    title: res.message
                                });
                            } else {
                                Toast.fire({
                                    icon: 'error',
                                    title: res.message
                                });
                            }
                            $(".pincode-input-container .pincode-input-text").val('');
                            $(".pincode-input-text").first().select().focus();
                        }
                    });

                    // $(errorElement).html("I'm sorry, but the code not correct");
                }
            });
        })
    </script>
@endpush
