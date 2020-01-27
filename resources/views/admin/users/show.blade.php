@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-2 mr-auto"><a href="{{ route('admin.users.index') }}">BACK TO LIST</a></div>
    </div>
    <div class="row justify-content-center">
        <div class="col-6">
            Name: {{ $user->name }}
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-6">
            Phone: {{ $user->phone }}
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-6">
            E-mail: {{ $user->email }}
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-6">
            Birthday: {{ $user->birthday }}
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-6">
            Gender: {{ $user->gender }}
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-6">
            Address: {{ $user->address }}
        </div>
    </div>
</div>
@endsection
