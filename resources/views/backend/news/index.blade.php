@extends('backend.layouts.app')

@section('title', 'Berita')

@push('css')
    <style>
        .description {
            cursor: pointer;
            padding: 5px 10px;
            background-color: #007bff;
            color: white;
            border-radius: 4px;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .description:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .description:focus {
            outline: none;
        }

        /* Optional: For adding icon to description */
        .description i {
            margin-right: 5px;
        }

        /* Optional: Modal Customization */
        .modal-body {
            font-size: 16px;
        }

        /* CSS untuk menampilkan teks lengkap di modal */
        #modalDescriptionBody {
            white-space: pre-line; /* Menjaga line breaks pada teks */
            word-wrap: break-word;
        }
    </style>
@endpush

@section('content')

    <div class="row">
        <div class="col-md-6 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('news.create') }}" class="btn btn-success mb-3">
                        <i class="fas fa-plus"></i> Tambah Berita
                    </a>
                    <table id="news-table" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Penulis</th>
                                <th>Gambar</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                    <!-- Modal -->
                    <div class="modal fade" id="descriptionModal" tabindex="-1" role="dialog" aria-labelledby="descriptionModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="descriptionModalLabel">Deskripsi Berita</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body" id="modalDescriptionBody">
                                    <!-- Deskripsi lengkap akan ditampilkan di sini -->
                                </div>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>

        $(document).ready(function () {
            // Inisialisasi DataTable
            const table = $('#news-table').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: '/api/news',
                    type: 'GET',
                    dataSrc: "data",
                    error: function (xhr, status, error) {
                        console.error('Error fetching data:', xhr.responseText);
                        let message = 'Failed to load data.';
                        if (xhr.status === 401) message = 'Unauthorized access. Please login.';
                        else if (xhr.status === 500) message = 'Server error. Please try again later.';
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
                        data: 'author'
                    },
                    {
                        data: 'image',
                        render: function (data) {
                            return `<img src="${data}" width="100">`
                        }
                    },
                    {
                        data: 'description',
                        render: function (data) {
                            return `
                                <span class="description" data-description="${data}">
                                    <i class="fas fa-info-circle"></i>
                                </span>`;
                        }
                    },
                    {
                        data: null,
                        render: function (data, type, row) {
                            return `
                                <a href="/news/${row.id}/edit" class="btn btn-primary btn-sm my-1">Ubah</a>
                                <button class="btn btn-danger btn-sm delete-news" data-id="${row.id}">Hapus</button>
                            `;
                        }
                    }
                ],
                drawCallback: function () {
                    // Event listener for description clicks to show modal
                    const descriptionModal = new bootstrap.Modal(document.getElementById('descriptionModal'));
                    $('.description').on('click', function() {
                        $('#modalDescriptionBody').text($(this).data('description'));
                        descriptionModal.show();
                    });

                    $('.delete-news').off('click').on('click', function () {
                        const newsId = $(this).data('id');
                        const apiUrl = `/api/news/${newsId}`;

                        Swal.fire({
                            title: 'Apakah Anda yakin?',
                            text: "Berita ini akan dihapus permanen!",
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
                                                throw new Error(err.message || 'Network response was not ok');
                                            });
                                        }
                                        return response.json();
                                    })
                                    .then(data => {
                                        if (data.message === 'News deleted successfully') {
                                            Swal.fire('Berhasil!', 'Berita telah dihapus.', 'success').then(() => {
                                                table.ajax.reload();
                                            });
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error deleting News:', error);
                                        Swal.fire('Gagal!', 'Gagal menghapus Berita: ' + error.message, 'error');
                                    });
                            }
                        });
                    });
                }
            });

            // Menambahkan event listener untuk modal close
            $('#descriptionModal').on('hidden.bs.modal', function () {
                $('#modalDescriptionBody').text(''); // Clear modal content when it is closed
            });
        });

    </script>
@endpush