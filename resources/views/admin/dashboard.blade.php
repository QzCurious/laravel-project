@extends('layouts.app')

@section('content')
    {{ print_r(Auth::user()->getAllPermissions()->toArray(), true) }}
@endsection
