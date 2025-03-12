<!-- header -->
@include('template/backend/header')

{{-- sidebar --}}
@include('template/backend/sidebar')

{{-- navbar --}}
@include('template/backend/navbar')

{{-- konten --}}
@yield('konten')

<!-- footer -->
@include('template/backend/footer')
