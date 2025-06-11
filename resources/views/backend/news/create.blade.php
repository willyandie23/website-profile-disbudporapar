@extends('backend.layouts.app')

@section('title', 'Buat Berita')

@section('content')

    <div class="row">
        <div class="col-md-6 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form id="newsForm" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="title">Judul</label>
                            <input type="text" name="title" id="title" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="author">Penulis</label>
                            <input type="text" name="author" id="author" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="image">Gambar Berita</label>
                            <input type="file" name="image" id="image" class="form-control" required>
                            <p class="text-danger">* Ukuran maksimal file upload hanya 5MB</p>
                        </div>

                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea name="description" id="description" class="form-control"></textarea>
                        </div>

                        <button type="submit" class="btn btn-success mt-3">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('newsForm');
            const url = "{{ route('news.store') }}";

            form.addEventListener('submit', async (e) => {
                e.preventDefault();

                // kumpulkan data form, termasuk file
                const formData = new FormData(form);

                try {
                    const res = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
                        },
                        body: formData
                    });

                    if (!res.ok) {
                        // jika response 422 atau error lain, parse json untuk pesan validasi
                        const err = await res.json();
                        throw new Error(err.message || 'Gagal menyimpan Berita');
                    }

                    const data = await res.json();
                    Swal.fire({
                        title: 'Sukses!',
                        text: 'Berita berhasil dibuat',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = "{{ route('news.index') }}";
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
    </script>
@endpush