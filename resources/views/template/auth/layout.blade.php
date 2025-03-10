<!-- navbar -->
@include('template/auth/header')

{{-- main --}}
<main class="page-center">
    {{-- konten --}}
    @yield('konten')
</main>

<!-- footer -->
@include('template/auth/footer')
