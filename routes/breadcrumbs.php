<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Dashboard breadcrumb (Parent for all)
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Beranda', route('dashboard'));
});

// Banner breadcrumbs
Breadcrumbs::for('banner.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Banner', route('banner.index'));
});
Breadcrumbs::for('banner.create', function (BreadcrumbTrail $trail) {
    $trail->parent('banner.index');
    $trail->push('Tambah Banner', route('banner.create'));
});
Breadcrumbs::for('banner.edit', function (BreadcrumbTrail $trail, $bannerId) {
    $trail->parent('banner.index');
    $trail->push('Edit Banner', route('banner.edit', $bannerId));
});

// Download breadcrumbs
Breadcrumbs::for('download.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Unduhan', route('download.index'));
});
Breadcrumbs::for('download.create', function (BreadcrumbTrail $trail) {
    $trail->parent('download.index');
    $trail->push('Tambah Unduhan', route('download.create'));
});

// Gallery breadcrumbs
Breadcrumbs::for('gallery.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Galeri', route('gallery.index'));
});
Breadcrumbs::for('gallery.create', function (BreadcrumbTrail $trail) {
    $trail->parent('gallery.index');
    $trail->push('Tambah Galeri', route('gallery.create'));
});
Breadcrumbs::for('gallery.edit', function (BreadcrumbTrail $trail, $galleryId) {
    $trail->parent('gallery.index');
    $trail->push('Edit Galeri', route('gallery.edit', $galleryId));
});

// Identity breadcrumbs
Breadcrumbs::for('identity.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Identitas Website', route('identity.index'));
});

// News breadcrumbs
Breadcrumbs::for('news.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Berita', route('news.index'));
});
Breadcrumbs::for('news.create', function (BreadcrumbTrail $trail) {
    $trail->parent('news.index');
    $trail->push('Tambah Berita', route('news.create'));
});
Breadcrumbs::for('news.edit', function (BreadcrumbTrail $trail, $newsId) {
    $trail->parent('news.index');
    $trail->push('Edit Berita', route('news.edit', $newsId));
});

// Field breadcrumbs
Breadcrumbs::for('field.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Bidang Kantor', route('field.index'));
});
Breadcrumbs::for('field.create', function (BreadcrumbTrail $trail) {
    $trail->parent('field.index');
    $trail->push('Tambah Bidang Kantor', route('field.create'));
});
Breadcrumbs::for('field.edit', function (BreadcrumbTrail $trail, $fieldId) {
    $trail->parent('field.index');
    $trail->push('Edit Bidang Kantor', route('field.edit', $fieldId));
});

// Organizations breadcrumbs
Breadcrumbs::for('organizations.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Daftar Organisasi', route('organizations.index'));
});
Breadcrumbs::for('organizations.create', function (BreadcrumbTrail $trail) {
    $trail->parent('organizations.index');
    $trail->push('Buat Organisasi', route('organizations.create'));
});
Breadcrumbs::for('organizations.edit', function (BreadcrumbTrail $trail, $organizationId) {
    $trail->parent('organizations.index');
    $trail->push('Edit Organisasi', route('organizations.edit', $organizationId));
});

// logs breadcrumbs
Breadcrumbs::for('logs.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Daftar Log', route('logs.index'));
});
Breadcrumbs::for('logs.show', function (BreadcrumbTrail $trail, $logsId) {
    $trail->parent('logs.index');
    $trail->push('Log Detail', route('logs.show', $logsId));
});

// Contact breadcrumbs
Breadcrumbs::for('contact.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Daftar Kontak Pesan', route('contact.index'));
});
Breadcrumbs::for('contact.show', function (BreadcrumbTrail $trail, $contactId) {
    $trail->parent('contact.index');
    $trail->push('Kontak Pesan Detail', route('contact.show', $contactId));
});