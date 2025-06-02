@extends('backend.layouts.app')

@section('title', 'Buat Daftar Organisasi')

@section('content')

    <div class="row">
        <div class="col-md-6 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form id="organizationForm" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="position">Posisi</label>
                            <input type="text" class="form-control" id="position" name="position" required>
                        </div>
                        <div class="form-group">
                            <label for="NIP">NIP</label>
                            <input type="text" class="form-control" id="NIP" name="NIP" required>
                        </div>
                        <div class="form-group">
                            <label for="field_id">Bidang</label>
                            <select class="form-control" id="field_id" name="field_id" required>
                                <option value="">Pilih Bidang</option>
                                @foreach ($fields as $field)
                                    <option value="{{ $field->id }}">{{ $field->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="image">Gambar Anggota</label>
                            <input type="file" name="image" id="image" class="form-control" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('organizationForm');  // Define the form variable
            const url = "{{ route('organizations.store') }}";  // Set the form action URL

            form.addEventListener('submit', async (e) => {
                e.preventDefault(); // Prevent default form submission

                const formData = new FormData(form); // Gather the form data

                try {
                    const res = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value // CSRF Token
                        },
                        body: formData // Send the form data with the file
                    });

                    const text = await res.text(); // Get raw response as text
                    console.log(text); // Log the response for debugging

                    if (!res.ok) {
                        throw new Error(text || 'Gagal menyimpan Anggota');
                    }

                    const data = JSON.parse(text); // Parse the text as JSON
                    Swal.fire({
                        title: 'Sukses!',
                        text: 'Anggota berhasil dibuat',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = "{{ route('organizations.index') }}"; // Redirect after success
                    });

                } catch (error) {
                    console.error('Error:', error); // Log any errors for debugging
                    Swal.fire({
                        title: 'Error!',
                        text: error.message,
                        icon: 'error'
                    });
                }
            });
        });
    </script>
@endpush
