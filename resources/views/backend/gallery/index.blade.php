@extends('backend.layouts.app')

@section('title', 'Gallery')

@section('content')

    <div class="row">
        <div class="col-md-6 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('gallery.create') }}" class="btn btn-success mb-3">
                        <i class="fas fa-plus"></i> Tambah Galeri
                    </a>
                    <table id="gallery-table" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Gambar</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
@endsection

@push('scripts')
    <script>

        $(document).ready(function() {
            const table = $('#gallery-table').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: '/api/galery',
                    type: 'GET',
                    dataSrc: "data",
                    error: function(xhr, status, error) {
                        console.error('Error fetching data:', xhr.responseText);
                        let message = 'Failed to load data.';

                        // Handle different error codes
                        if (xhr.status === 401) {
                            message = 'Unauthorized access. Please login.';
                        } else if (xhr.status === 500) {
                            message = 'Server error. Please try again later.';
                        }

                        Swal.fire('Error!', message, 'error');
                    }
                },
                columns: [{
                        data: null,
                        render: (data, type, row, meta) => meta.row + 1
                    },
                    {
                        data: 'title'
                    },
                    {
                        data: 'description'
                    },
                    {
                        data: 'image',
                        render: function(data) {
                            return `<img src="${data}" width="100">`
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                                <a href="/galery/${row.id}/edit" class="btn btn-primary btn-sm my-1">Ubah</a>
                                <button class="btn btn-danger btn-sm delete-gallery" data-id="${row.id}">Hapus</button>
                            `;
                        }
                    }
                ],
                drawCallback: function() {
                    $('.delete-gallery').off('click').on('click', function() {
                        const galeryId = $(this).data('id');
                        const apiUrl = `/api/galery/${galeryId}`;

                        Swal.fire({
                            title: 'Apakah Anda yakin?',
                            text: "Galeri ini akan dihapus permanen!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Ya, hapus!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                fetch(apiUrl, {
                                        method: 'DELETE',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'Authorization': `Bearer ${token}`
                                        }
                                    })
                                    .then(response => {
                                        if (!response.ok) {
                                            return response.json().then(err => {
                                                throw new Error(err
                                                    .message ||
                                                    'Network response was not ok'
                                                );
                                            });
                                        }
                                        return response.json();
                                    })
                                    .then(data => {
                                        if (data.message ===
                                            'Gallery deleted successfully') {
                                            Swal.fire(
                                                'Berhasil!',
                                                'Galeri telah dihapus.',
                                                'success'
                                            ).then(() => {
                                                table.ajax.reload();
                                            });
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error deleting Gallery:',
                                            error);
                                        Swal.fire(
                                            'Gagal!',
                                            'Gagal menghapus Galeri: ' +
                                            error
                                            .message,
                                            'error'
                                        );
                                    });
                            }
                        });
                    });
                }
            });
        });
    </script>
@endpush