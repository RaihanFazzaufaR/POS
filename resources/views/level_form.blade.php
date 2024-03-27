@extends('adminlte::page')

@section('title', 'Level Form')

@section('content_header')
    <h1>Level Form</h1>
@stop

@section('content')
<div class="card card-warning">
    <div class="card-header">
        <h3 class="card-title">Level Form</h3>
    </div>

    <div class="card-body">
        <form>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Kode Level</label>
                        <input type="text" class="form-control" placeholder="NAM">
                        <br>
                        <label>Nama Level</label>
                        <input type="text" class="form-control" placeholder="Nama">
                    </div>
                    <br>
                    <button type="submit" class="btn btn-info">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
@stop

@section('CSS')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    {{-- <script> console.log("Hi, I'm using the Laravel-AdminLTE package"); </script> --}}
@stop