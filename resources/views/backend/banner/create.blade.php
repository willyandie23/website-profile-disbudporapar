@extends('backend.layouts.app')

@section('title', 'Buat Banner')

@section('content')
    <div class="row">
        <div class="col-md-6 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form id="bannerForm" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="title">Judul</label>
                            <input type="text" name="title" id="title" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea name="description" id="description" class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="image">Gambar Banner</label>
                            <input type="file" name="image" id="image" class="form-control" required accept=".jpg, .jpeg">
                            <p class="text-danger">* Ukuran maksimal file upload hanya 5MB dengan dimensi 1920x1080</p>
                        </div>

                        <button type="submit" class="btn btn-success mt-3">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('bannerForm');
            const url = "{{ route('banner.store') }}";

            form.addEventListener('submit', async (e) => {
                e.preventDefault();

                // kumpulkan data form, termasuk file
                const formData = new FormData(form);

                try {
                    const res = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'Authorization': token,
                            'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
                        },
                        body: formData
                    });

                    if (!res.ok) {
                        // jika response 422 atau error lain, parse json untuk pesan validasi
                        const err = await res.json();
                        throw new Error(err.message || 'Gagal menyimpan banner');
                    }

                    const data = await res.json();
                    Swal.fire({
                        title: 'Sukses!',
                        text: 'Banner berhasil dibuat',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = "{{ route('banner.index') }}";
                    });

                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: error.message,
                        icon: 'error'
                    });
                }
            });
        });
    </script> -->

    <script>
        const apiUrl = '/api/banner';

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('bannerForm');
            // const apiUrl = '/api/banner';

            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission

                const formData = new FormData(form);  // Create FormData instance with form data

                // Log the FormData to check if the file is included
                for (let [key, value] of formData.entries()) {
                    console.log(key, value);  // This will log the form field names and values, including the image
                }

                console.log(token);

                fetch(apiUrl, {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${token}`,  // Ensure token is added
                        // Don't set Content-Type header, FormData handles this automatically
                    },
                    body: formData // Pass the FormData directly (no need for JSON.stringify)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message === 'Banner created successfully') {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Banner Berhasil Dibuat',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = '/banner'; // Redirect to the banner list
                        });
                    } else {
                        throw new Error('Invalid response');
                    }
                })
                .catch(error => {
                    console.error('Error creating Banner:', error);
                    alert('Gagal membuat Banner: ' + error.message);
                });
            });
        });

    </script>
@endpush