@extends('frontend.layouts.app')

@section('title', 'Galeri | DISBUDPORAPAR')

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

        /* Styling for the gallery container */
        .gallery-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr); /* 3 columns per row by default */
            gap: 15px;
            margin-bottom: 30px;
        }

        /* Styling for each gallery item (card) */
        .gallery-item {
            position: relative;
            overflow: hidden;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            height: 400px; /* Fixed height for uniform card size */
            width: 100%; /* Make the card take the full available width */
        }

        /* Ensuring image covers the entire card area */
        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Ensures the image covers the card area */
            transition: transform 0.3s ease-in-out;
        }

        /* Hover effect to expand the title background */
        .gallery-item:hover img {
            transform: scale(1.1); /* Slight zoom-in effect */
        }

        .gallery-item h3 {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.6); /* Dark background for text */
            color: white;
            font-size: 18px;
            padding: 10px;
            transition: background 0.3s ease;
            opacity: 0; /* Initially hide text */
        }

        .gallery-item:hover h3 {
            opacity: 1; /* Show title on hover */
        }

        /* Pagination style */
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 30px;
            margin-bottom: 30px;
        }

        .pagination a {
            padding: 8px 16px;
            margin: 0 5px;
            text-decoration: none;
            background-color: #f1f1f1;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .pagination a:hover {
            background-color: #ddd;
        }

        /* Modal gallery style */
        .gallery-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .gallery-modal img {
            max-width: 90%;
            max-height: 80%;
        }

        /* Close button */
        .close-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 30px;
            color: white;
            cursor: pointer;
        }

        /* Responsivitas untuk layar lebih kecil (Mobile View) */
        @media (max-width: 768px) {
            .main-content {
                padding-top: 0px;
                padding-left: 20px;
                padding-right: 20px;
            }

            .gallery-container {
                grid-template-columns: 1fr 1fr; /* 2 columns for mobile */
            }

            .gallery-item {
                height: 250px; /* Reduced height for mobile */
            }

            .gallery-item h3 {
                font-size: 16px; /* Smaller title for mobile */
            }
        }

        /* Untuk tablet view dan lebih besar */
        @media (max-width: 992px) and (min-width: 769px) {
            .main-content {
                padding-top: 0px;
                padding-left: 50px;
                padding-right: 50px;
            }

            .gallery-container {
                grid-template-columns: repeat(2, 1fr); /* 2 columns for tablets */
            }

            .gallery-item {
                height: 300px; /* Adjust height for tablets */
            }

            .gallery-item h3 {
                font-size: 17px; /* Slightly smaller title for tablet */
            }
        }

        /* For large screens and desktops */
        @media (min-width: 992px) {
            .gallery-container {
                grid-template-columns: repeat(3, 1fr); /* 3 columns for large screens */
            }

            .gallery-item {
                height: 400px; /* Standard height for large screens */
            }

            .gallery-item h3 {
                font-size: 18px; /* Default title size for larger screens */
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
            <h2>Galeri</h2>
            <hr>
            <div class="gallery-container" id="galleryContainer">
                <!-- Gallery items will be loaded here dynamically -->
            </div>

            <!-- Pagination -->
            <div class="pagination" id="pagination"></div>
        </div>
    </div>

    <!-- Modal for viewing images -->
    <div class="gallery-modal" id="galleryModal">
        <span class="close-btn" onclick="closeModal()">×</span>
        <img id="modalImage" src="" alt="Gallery Image">
    </div>
@endsection

@push('scripts')
    <script>
        const itemsPerPage = 12;
        let currentPage = 1;
        let galleryData = [];

        // Function to fetch gallery data from API and populate the gallery
        async function fetchGalleryData() {
            try {
                const response = await fetch('/api/galery');
                const data = await response.json();

                if (response.ok) {
                    galleryData = data.data;
                    displayGalleryItems();
                    displayPagination();
                } else {
                    console.error('Failed to fetch gallery data:', data.message);
                }
            } catch (error) {
                console.error('Error fetching gallery data:', error);
            }
        }

        // Function to display the gallery items for the current page
        function displayGalleryItems() {
            const galleryContainer = document.getElementById('galleryContainer');
            galleryContainer.innerHTML = '';

            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const currentItems = galleryData.slice(startIndex, endIndex);

            currentItems.forEach(item => {
                const galleryItem = document.createElement('div');
                galleryItem.classList.add('gallery-item');

                galleryItem.innerHTML = `
                    <img src="${item.image}" alt="${item.title}" onclick="openModal('${item.image}')">
                    <h3>${item.title}</h3>
                `;

                galleryContainer.appendChild(galleryItem);
            });
        }

        // Function to display pagination
        function displayPagination() {
            const paginationContainer = document.getElementById('pagination');
            const totalPages = Math.ceil(galleryData.length / itemsPerPage);
            paginationContainer.innerHTML = '';

            for (let i = 1; i <= totalPages; i++) {
                const pageLink = document.createElement('a');
                pageLink.href = '#';
                pageLink.textContent = i;
                pageLink.onclick = function () {
                    currentPage = i;
                    displayGalleryItems();
                };

                paginationContainer.appendChild(pageLink);
            }
        }

        // Function to open modal and display image
        function openModal(imageUrl) {
            const modal = document.getElementById('galleryModal');
            const modalImage = document.getElementById('modalImage');
            modal.style.display = 'flex';
            modalImage.src = imageUrl;
        }

        // Function to close the modal
        function closeModal() {
            const modal = document.getElementById('galleryModal');
            modal.style.display = 'none';
        }

        // Call the function when the page loads
        document.addEventListener('DOMContentLoaded', fetchGalleryData);
    </script>
@endpush