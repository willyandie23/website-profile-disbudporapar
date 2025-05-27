@extends('backend.layouts.app')

@section('title', 'Edit Daftar Organisasi')

@section('content')

    <div class="row">
        <div class="col-md-6 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form id="organizationForm">
                        <div class="form-group">
                            <label for="name">Perangkat Daerah</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ $organizations->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="position">Perangkat Daerah</label>
                            <input type="text" class="form-control" id="position" name="position"
                                value="{{ $organizations->position }}" required>
                        </div>

                        <!-- Category Dropdown -->
                        <div class="form-group">
                            <label for="category_id">Kategori</label>
                            <select class="form-control" id="category_id" name="category_id" required>
                                <option value="">Pilih Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        @if ($organizations->category_id == $category->id) 
                                            selected 
                                        @endif>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
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
        const organizationId = "{{ $organizations->id }}";
        const apiUrl = `/api/organizations/${organizationId}`;

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('organizationForm');
            if (!form) {
                console.error('Form tidak ditemukan');
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
                        method: 'PUT',
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
                        console.log('API Response:', data); // Log the full response for debugging
                        if (data.message === 'Organization updated successfully') {
                            Swal.fire({
                                title: 'Success!',
                                text: 'Anggota berhasil diperbarui',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = '/organizational-structure/organizations';
                            });
                        } else {
                            throw new Error('Response tidak valid');
                        }
                    })
                    .catch(error => {
                        console.error('Error updating Organizations:', error);
                        alert('Gagal memperbarui Anggota: ' + error.message);
                    });
            });
        });
    </script>
@endpush