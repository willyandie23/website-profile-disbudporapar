@extends('backend.layouts.app')

@section('title', 'Edit News')

@section('content')

    <div class="row">
        <div class="col-md-6 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form id="newsForm">

                        <div class="form-group">
                            <label for="title">Judul</label>
                            <input type="text" class="form-control" id="title" name="title"
                                value="{{ $news->title }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="author">Penulis</label>
                            <input type="text" class="form-control" id="author" name="author"
                                value="{{ $news->author }}" required>
                        </div>

                        <div class="form-group">
                            <label>Gambar Saat Ini</label><br>
                            <img src="{{ $news->image }}" width="150" alt="News Image" class="mb-3">
                        </div>

                        <div class="form-group">
                            <label for="image">Ubah Gambar Berita (opsional)</label>
                            <input
                                type="file"
                                name="image"
                                id="image"
                                class="form-control"
                            >
                        </div>

                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea class="form-control" id="description" name="description" rows="4" required>{{ $news->description }}</textarea>
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
        document.getElementById('newsForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const fileInput    = document.getElementById('image');
            const title        = document.getElementById('title').value;
            const author       = document.getElementById('author').value;
            const description  = document.getElementById('description').value;
            const apiUrl       = `/api/news/{{ $news->id }}`;

            if (fileInput.files.length) {
                const fd = new FormData();
                fd.append('_method', 'PUT');
                fd.append('title', title);
                fd.append('author', author);
                fd.append('image', fileInput.files[0]);
                fd.append('description', description);

                const res = await fetch(apiUrl, {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: fd
                });

                return handleResponse(res);
            }

            const payload = { title, description };
            const res = await fetch(apiUrl, {
                method: 'PUT',
                headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify(payload)
            });

            handleResponse(res);
        });

        async function handleResponse(response) {
            const data = await response.json();
            if (response.ok && data.message === 'News updated successfully') {
                Swal.fire(
                    'Sukses!',
                    'Berita berhasil diperbarui.',
                    'success'
                )
                .then(() => window.location.href = '{{ route("news.index") }}');
            } else {
                Swal.fire('Error!', data.message || 'Update gagal', 'error');
            }
        }
    </script>
@endpush