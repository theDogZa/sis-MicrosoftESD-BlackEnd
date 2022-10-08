@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                    
                    @role('developer')

                    <h1>Hello from the developer</h1>

                    @endrole

                     @role('admin')

                    <h1>Hello from the admin</h1>

                    @endrole

                    @permissions('read.users')
                        <p>read users</p>
                    @endpermissions

                    @permissions('create.users')
                        <p>create users</p>
                    @endpermissions

                     @permissions('create.097097')
                        <p>create 98798</p>
                    @endpermissions

                   {{ auth()->user()->username }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection