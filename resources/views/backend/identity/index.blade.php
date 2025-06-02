@extends('backend.layouts.app')

@section('title', 'Identity')

@section('content')
    <div class="row">
        <div class="col-md-6 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form id="identityForm" method="POST" action="{{ route('identity.store') }}">

                        @csrf
                        {{-- Section Generan Section --}}
                        <h3>Identitas Umum</h3>
                        <div class="form-group mb-3 mt-3">
                            <label for="site_heading">Judul Website</label>
                            <input type="text" class="form-control" id="site_heading" name="site_heading">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="site_logo">Logo Website</label>
                                    <input type="file" class="form-control" id="site_logo" name="site_logo">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <p class="mt-2">Preview:</p>
                                    <img id="site_logo_preview" src="" alt="Logo Preview"
                                        style="display:none; max-width: 250px;" />
                                </div>
                            </div>
                        </div>

                        {{-- Contact Person Section --}}
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <h3>Kontak Website</h3>
                                <div class="form-group mb-3 mt-3">
                                    <label for="cp_address">Alamat</label>
                                    <input type="text" class="form-control" id="cp_address" name="cp_address">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="cp_phone">Nomor Telepon</label>
                                    <input type="text" class="form-control" id="cp_phone" name="cp_phone">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="cp_email">Email</label>
                                    <input type="text" class="form-control" id="cp_email" name="cp_email">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="cp_agency">Nama Instansi</label>
                                    <input type="text" class="form-control" id="cp_agency" name="cp_agency">
                                </div>
                            </div>

                            {{-- Social Media Section --}}
                            <div class="col-md-6">
                                <h3>Sosial Media</h3>
                                <div class="form-group mb-3 mt-3">
                                    <label for="sm_facebook">Facebook</label>
                                    <input type="text" class="form-control" id="sm_facebook" name="sm_facebook">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="sm_instagram">Instagram</label>
                                    <input type="text" class="form-control" id="sm_instagram" name="sm_instagram">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="sm_x">X</label>
                                    <input type="text" class="form-control" id="sm_x" name="sm_x">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="sm_youtube">Youtube</label>
                                    <input type="text" class="form-control" id="sm_youtube" name="sm_youtube">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    @endsection

    @push('scripts')
        <script>
            $(document).ready(function() {
                const form = $('#identityForm');
                const siteHeadingInput = $('#site_heading');
                const siteLogoInput = $('#site_logo')[0];

                const contactAddressInput = $('#cp_address');
                const contactPhoneInput = $('#cp_phone');
                const contactEmailInput = $('#cp_email');
                const contactAgencyInput = $('#cp_agency');

                const socialFacebookInput = $('#sm_facebook');
                const socialInstagramInput = $('#sm_instagram');
                const socialXInput = $('#sm_x');
                const socialYoutubeInput = $('#sm_youtube');

                // Mengambil data saat load page
                $.ajax({
                    url: '/api/identities',
                    type: 'GET',
                    success: function(response) {
                        if (response.success && response.data) {
                            siteHeadingInput.val(response.data.site_heading || '');

                            // Menampilkan gambar jika ada
                            if (response.data.site_logo) {
                                $('#site_logo_preview').attr('src', response.data.site_logo).show();
                            }

                            contactAddressInput.val(response.data.cp_address || '');
                            contactPhoneInput.val(response.data.cp_phone || '');
                            contactEmailInput.val(response.data.cp_email || '');
                            contactAgencyInput.val(response.data.cp_agency || '');

                            socialFacebookInput.val(response.data.sm_facebook || '');
                            socialInstagramInput.val(response.data.sm_instagram || '');
                            socialXInput.val(response.data.sm_x || '');
                            socialYoutubeInput.val(response.data.sm_youtube || '');
                        }
                    },
                    error: function(xhr) {
                        console.error('Error fetching identity data:', xhr.responseText);
                        Swal.fire('Error!', 'Failed to load identity data.', 'error');
                    }
                });

                // Handle form submission
                form.on('submit', function(event) {
                    event.preventDefault();

                    const formData = new FormData(); // Gunakan FormData untuk file upload

                    formData.append('site_heading', siteHeadingInput.val());
                    formData.append('cp_address', contactAddressInput.val());
                    formData.append('cp_phone', contactPhoneInput.val());
                    formData.append('cp_email', contactEmailInput.val());
                    formData.append('cp_agency', contactAgencyInput.val());
                    formData.append('sm_facebook', socialFacebookInput.val());
                    formData.append('sm_instagram', socialInstagramInput.val());
                    formData.append('sm_x', socialXInput.val());
                    formData.append('sm_youtube', socialYoutubeInput.val());

                    if (siteLogoInput && siteLogoInput.files && siteLogoInput.files[0]) {
                        formData.append('site_logo', siteLogoInput.files[0]);
                    }

                    $.ajax({
                        url: '/api/identities',
                        type: 'POST',
                        data: formData,
                        processData: false, // Jangan biarkan jQuery mengubah data
                        contentType: false, // Jangan tentukan contentType, biarkan FormData menangani
                        headers: {
                            'Authorization': `Bearer ${token}`
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Success!',
                                text: 'Identitas Website Berhasil Disimpan',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.reload();
                            });
                        },
                        error: function(xhr) {
                            console.error('Error saving identity data:', xhr.responseText);
                            Swal.fire('Error!', 'Failed to save identity data.', 'error');
                        }
                    });
                });
            });
        </script>
    @endpush
