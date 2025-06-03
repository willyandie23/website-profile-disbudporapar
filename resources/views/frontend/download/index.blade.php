@extends('frontend.layouts.app')

@section('title', 'Unduh File | DISBUDPORAPAR')

@push('css')
    <style>
        .navbar-light.opaque .navbar-nav .nav-link {
            background: var(--bs-light) !important;
            color: var(--bs-dark);
        }

        .main-content {
            position: static;
            color: var(--bs-dark);
            padding-top: 90px;
        }

        h2 {
            padding-top: 15px;
            font-size: 28px;
            font-weight: bold;
        }

        .table-container {
            padding-left: 150px;
            padding-right: 150px;
        }

        .table {
            margin-top: 20px;
            width: 100%;
            background-color: white;
            border: 1px solid black;
            font-size: 16px;
        }

        .table th, .table td {
            padding: 12px 15px;
            text-align: left;
            border: 1px solid black;
            color: black;
        }

        .table th {
            background-color: #f4f6f9;
            font-weight: bold;
        }

        .table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .table tbody tr:nth-child(even) {
            background-color: #fafafa;
        }

        .table tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }

        .table tbody tr td {
            font-size: 14px;
        }

        /* Mengubah warna tombol download */
        .btn-info {
            background-color: #4caf50;  /* Warna hijau terang untuk tombol */
            border-color: #4caf50;
            transition: background-color 0.3s ease;
            color: white; /* Warna teks putih */
            font-size: medium;
        }

        .btn-info:hover {
            background-color: #45a049;  /* Warna tombol saat hover */
            border-color: #45a049;
        }

        @media (min-width: 992px) {
            .navbar-light {
                position: absolute;
                width: 100%;
                top: 0;
                left: 0;
                border-top: 0;
                border-right: 0;
                border-bottom: 1px solid;
                border-left: 0;
                border-style: dotted;
                z-index: 999;
            }

            .navbar-light.opaque {
                background: var(--bs-light) !important;
            }

            .sticky-top.navbar-light {
                position: fixed;
                background: var(--bs-light);
                border: none;
            }
        }
    </style>
@endpush

@section('content')

    <div class="row main-content">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-container">
                        <h2>Unduh File</h2>
                        <hr>
                        <table id="downloads-table" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama File</th>
                                    <th>Jumlah Unduh</th>
                                    <th>Link Unduh</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            const table = $('#downloads-table').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: '/api/downloads',
                    type: 'GET',
                    dataSrc: "data",
                    error: function(xhr, status, error) {
                        console.error('Error fetching data:', xhr.responseText);
                        Swal.fire('Error!', 'Gagal memuat data.', 'error');
                    }
                },
                columns: [
                    { data: null, render: (data, type, row, meta) => meta.row + 1 },
                    { data: 'file_name' },
                    { data: 'total_download' },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                                <a href="${row.file_path}" class="btn btn-info btn-sm my-1 download-btn" data-id="${row.id}" target="_blank">Unduh</a>
                            `;
                        }
                    }
                ],
                drawCallback: function() {
                    $('.download-btn').on('click', function() {
                        const fileId = $(this).data('id');
                        
                        $.ajax({
                            url: `/api/downloads/${fileId}/download`,
                            type: 'POST',
                            success: function(response) {
                                table.ajax.reload();
                            }
                        });
                    });
                }
            });
        });
    </script>
@endpush
