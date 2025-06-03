@extends('frontend.layouts.app')

@section('title', 'Berita | DISBUDPORAPAR')

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
            padding-left: 150px;
            padding-right: 150px;
        }

        h2 {
            padding-top: 15px;
            font-size: 28px;
            font-weight: bold;
        }

        /* Styling untuk daftar berita */
        .news-card {
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 20px;
            padding: 15px;
            background-color: white;  /* Background card putih */
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);  /* Efek bayangan card */
            display: flex;
            flex-direction: row;
            gap: 15px;
            opacity: 0; /* Mulai dengan opacity 0 */
            transform: translateY(20px); /* Mulai sedikit di bawah */
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .news-card.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Animasi wipe down */
        @keyframes wipeDown {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Gambar pada card */
        .news-card img {
            width: 200px;  /* Membatasi lebar gambar */
            height: 200px;  /* Membatasi tinggi gambar */
            object-fit: cover;  /* Menjaga gambar terpotong */
            border-radius: 5px;
        }

        /* Konten berita */
        .news-card .content {
            flex-grow: 1;
        }

        /* Styling untuk judul */
        .news-card .title {
            font-size: 22px;
            font-weight: bold;
            margin-top: 10px;
            color: #007bff;  /* Warna biru untuk judul */
        }

        /* Penulis dan tanggal */
        .news-card .author,
        .news-card .date {
            font-size: 14px;
            color: #666;
        }

        /* Deskripsi */
        .news-card .description {
            font-size: 16px;
            color: #333;
            margin-top: 10px;
        }

        /* Tombol detail */
        .news-card .btn-detail {
            margin-top: 15px;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 8px 15px;
            font-size: 14px;
            cursor: pointer;
            text-align: center;
            border-radius: 5px;
        }

        .news-card .btn-detail:hover {
            background-color: #0056b3;
        }

        /* Styling untuk pagination */
        .pagination {
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 0;
            margin-top: 20px;
        }

        .pagination .page-item {
            margin: 0 5px;
        }

        .pagination .page-link {
            background-color: white;
            border: 1px solid #007bff;
            color: #007bff;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .pagination .page-link:hover {
            background-color: #007bff;
            color: white;
        }

        .pagination .page-item.active .page-link {
            background-color: #007bff;
            color: white;
        }

        .pagination .page-item.disabled .page-link {
            background-color: #f1f1f1;
            color: #ddd;
            cursor: not-allowed;
        }

        .pagination .prev-next {
            background-color: #007bff;
            color: white;
        }

        .pagination .prev-next:hover {
            background-color: #0056b3;
        }

        .pagination .page-item a {
            text-decoration: none;
        }

        /* Responsivitas untuk layar lebih kecil (Mobile View) */
        @media (max-width: 768px) {
            .main-content {
                padding-top: 0px;
                padding-left: 20px;
                padding-right: 20px;
            }

            /* Menampilkan gambar lebih kecil */
            .news-card img {
                width: 150px;
                height: 150px;
            }

            /* Flex direction menjadi column */
            .news-card {
                flex-direction: column;
                align-items: center;
            }

            /* Penyesuaian ukuran font */
            .news-card .title {
                font-size: 20px;
            }

            .news-card .author, .news-card .description {
                font-size: 14px;
            }

            /* Menambahkan padding pada tombol detail */
            .news-card .btn-detail {
                padding: 8px 20px;
                font-size: 16px;
            }

            /* Pagination adjustments */
            .pagination .page-link {
                font-size: 12px;
                padding: 6px 10px;
            }

            /* Membuat pagination lebih compact di mobile */
            .pagination {
                font-size: 12px;
            }
        }

        /* Untuk tablet view dan lebih besar */
        @media (max-width: 992px) and (min-width: 769px) {
            .main-content {
                padding-top: 0px;
                padding-left: 50px;
                padding-right: 50px;
            }

            /* Adjust image size for tablet */
            .news-card img {
                width: 180px;
                height: 180px;
            }

            /* Adjust title font size for medium screens */
            .news-card .title {
                font-size: 22px;
            }
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
            <div class="card-body">
                <h2>Berita</h2>
                <hr>
                <!-- Tempat untuk menampilkan daftar berita -->
                <div id="news-list"></div> 
                <!-- Pagination -->
                <nav id="pagination-container"></nav>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            const itemsPerPage = 10;
            let currentPage = 1;

            // Mengambil data berita menggunakan AJAX
            $.ajax({
                url: '/api/news', // Endpoint API untuk mendapatkan daftar berita
                type: 'GET',
                success: function(response) {
                    const news = response.data; // Data berita yang diterima dari API
                    let newsHtml = '';
                    let totalPages = Math.ceil(news.length / itemsPerPage);

                    // Function untuk format tanggal
                    function formatDate(dateString) {
                        const months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
                        const date = new Date(dateString);
                        return `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()}`;
                    }

                    // Function untuk memotong judul jika panjangnya lebih dari 50 karakter
                    function truncateTitle(title) {
                        if (title.length > 60) {
                            return title.substring(0, 60) + '...';
                        }
                        return title;
                    }

                    // Menampilkan berita berdasarkan halaman saat ini
                    function displayNews(page) {
                        const start = (page - 1) * itemsPerPage;
                        const end = start + itemsPerPage;
                        const pageNews = news.slice(start, end);
                        
                        pageNews.forEach(function(item, index) {
                            const formattedDate = formatDate(item.created_at);
                            const truncatedTitle = truncateTitle(item.title); // Memotong judul jika perlu

                            newsHtml += `
                                <div class="news-card" data-id="${item.id}">
                                    <img src="${item.image}" alt="${item.title}">
                                    <div class="content">
                                        <div class="title">${truncatedTitle}</div>
                                        <div class="author">Penulis: ${item.author} | Tanggal: ${formattedDate}</div>
                                        <div class="description">${item.description.substring(0, 300)}...</div>
                                        <button class="btn-detail" onclick="window.location.href='/berita/${item.id}'">Selengkapnya...</button>
                                    </div>
                                </div>
                            `;
                        });

                        $('#news-list').html(newsHtml);
                        addIntersectionObserver(); // Menambahkan observer setelah berita dimuat
                    }

                    // Memanggil fungsi untuk menampilkan berita halaman pertama
                    displayNews(currentPage);

                    // Menambahkan pagination
                    let paginationHtml = `
                        <ul class="pagination">
                            <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                                <a class="page-link prev-next" href="#" data-page="prev">&lt;</a>
                            </li>
                    `;

                    // Membuat tombol untuk setiap halaman
                    for (let i = 1; i <= totalPages; i++) {
                        paginationHtml += `
                            <li class="page-item ${i === currentPage ? 'active' : ''}">
                                <a class="page-link" href="#" data-page="${i}">${i}</a>
                            </li>
                        `;
                    }

                    paginationHtml += `
                        <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                            <a class="page-link prev-next" href="#" data-page="next">&gt;</a>
                        </li>
                        </ul>
                    `;

                    $('#pagination-container').html(paginationHtml);

                    // Klik tombol pagination
                    $('.page-link').on('click', function(event) {
                        event.preventDefault();
                        const page = $(this).data('page');
                        
                        if (page === 'prev') {
                            currentPage = currentPage > 1 ? currentPage - 1 : 1;
                        } else if (page === 'next') {
                            currentPage = currentPage < totalPages ? currentPage + 1 : totalPages;
                        } else {
                            currentPage = parseInt(page);
                        }

                        newsHtml = '';
                        displayNews(currentPage);

                        // Update active page class
                        $('.page-item').removeClass('active');
                        $('.page-item').eq(currentPage).addClass('active');
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire('Error!', 'Gagal memuat berita.', 'error');
                }
            });

            // Fungsi untuk menambahkan Intersection Observer
            function addIntersectionObserver() {
                const observer = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('visible'); // Menambahkan kelas visible saat elemen terlihat
                            observer.unobserve(entry.target); // Menghentikan observasi pada elemen ini
                        }
                    });
                }, {
                    threshold: 0.5 // Mendeteksi saat 50% elemen terlihat
                });

                // Observasi setiap berita
                document.querySelectorAll('.news-card').forEach(card => {
                    observer.observe(card);
                });
            }
        });

    </script>
@endpush
