@extends('layouts.app')

@section('title', 'Attendance')

@section('content')
    <div class="card py-4">
        <div class="text-center">
            <img src="{{ asset('image/scan.png') }}" alt="Scan" class="img-fluid" width="200">
            <p class="text-muted">Please Scan Attendance QR</p>
        </div>
    </div>

    <div class="card p-2 mt-4">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-secondary" data-mdb-toggle="modal" data-mdb-target="#scanModal">
            Scan QR Code
        </button>

        <!-- Modal -->
        <div class="modal fade" id="scanModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Scan Your QR Code</h5>
                        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <video id="video" width="400" height="300"></video>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
                    </div>
                </div>
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

            var videoElem = document.getElementById('video');
            let qrScanner = new QrScanner(
                videoElem,
                function(result) {
                    console.log('decoded qr code:', result);
                    if (result) {
                        $('#scanModal').modal('hide');
                        qrScanner.stop();

                        $.ajax({
                            url: '/attendance-scan/scan-store',
                            method: 'POST',
                            data: {
                                'hashed_value': result.data,
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
                            }
                        })
                    }
                }, {
                    DetailedScanResult: true
                }
            );
            $('#scanModal').on('shown.bs.modal', function(event) {
                qrScanner.start();
            });
            $('#scanModal').on('hidden.bs.modal', function(event) {
                qrScanner.stop();
            });



        });
    </script>
@endpush
