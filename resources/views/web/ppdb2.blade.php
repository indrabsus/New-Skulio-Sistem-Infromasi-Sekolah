@extends('web.layouts.template')

@section('content')

<div class="container">
    <div class="row justify-content-md-center">
        <div class="col col-md-auto"><img src="{{ asset('assets/img/logo.png') }}" width="150px"></div>
    </div>
    <div class="row justify-content-md-center mt-2">
        <h3>Silakan Masukan NISN anda!</h3>
    </div>
    <form action="{{ route('cekppdb') }}" method="post">
        @csrf
        <div class="row justify-content-md-center mt-2">
            <div class="col-4"><input type="text" name="nisn" class="form-control"></div>
        </div>
        <div class="row justify-content-md-center mt-2">
            <div class="col col-md-auto"><button class="btn btn-primary">Cek NISN</button></div>
        </div>
    </form>

</div>

@endsection
