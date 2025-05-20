@extends('backend.layouts.app')

@section('title', 'Beranda')

@section('content')
    <div>
        Dashboard
        @hasrole('admin')
            <p>Ini adalah Admin</p>
        @endhasrole
        @hasrole('superadmin')
            <p>Ini adalah superadminn</p>
        @endhasrole
    </div>
@endsection