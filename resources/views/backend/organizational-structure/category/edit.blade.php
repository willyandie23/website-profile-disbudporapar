@extends('backend.layouts.app')

@section('title', 'Edit Kategori')

@section('content')

    <div class="row">
        <div class="col-md-6 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form id="categoryForm">
                        <div class="form-group">
                            <label for="name">Kategori Struktur Organisasi</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ $categories->name }}" required>
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
        const categoryId = "{{ $categories->id }}";
        const apiUrl = `/api/categories/${categoryId}`;

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('categoryForm');
            if (!form) {
                console.error('Form tidak ditemukan');
                return;
            }

            if (!token) {
                console.error('API token tidak tersedia');
                alert('Silakan login kembali untuk mendapatkan token');
                return;
            }

            form.addEventListener('submit', function(event) {
                event.preventDefault();
                const formData = new FormData(form);
                const data = {};
                formData.forEach((value, key) => {
                    data[key] = value;
                });

                fetch(apiUrl, {
                        method: 'PUT', // Use PUT for updating
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': `Bearer ${token}`
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => {
                                throw new Error(err.message || 'Network response was not ok');
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('API Response:', data);
                        if (data.message ===
                            'Organization Categories updated successfully') {
                            Swal.fire({
                                title: 'Success!',
                                text: 'Kategori berhasil diperbarui',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = '/organizational-structure/category';
                            });
                        } else {
                            throw new Error('Response tidak valid');
                        }
                    })
                    .catch(error => {
                        console.error('Error updating Kategori:', error);
                        alert('Gagal memperbarui Kategori: ' + error.message);
                    });
            });
        });
    </script>
@endpush
