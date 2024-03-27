@extends('adminlte::page')

@section('title', 'User Form')

@section('content_header')
    <h1>User Form</h1>
@stop

@section('content')
<div class="card card-warning">
    <div class="card-header">
        <h3 class="card-title">User Form</h3>
    </div>

    <div class="card-body">
        <form>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" placeholder="Username">
                        <br>
                        <label>Nama</label>
                        <input type="text" class="form-control" placeholder="Nama">
                        <br>
                        <label>Password</label>
                        <input type="password" class="form-control" placeholder="Password">
                        <br>
                        <label>Level</label>
                        <select name="var6" size="1" class="form-control">
                            <option value="1">Administrator</option>
                            <option value="2">Manager</option>
                            <option value="3">Staff/Kasir</option>
                            <option value="4">Customer</option>
                        </select>
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