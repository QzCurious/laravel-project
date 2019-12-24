@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-2 mr-auto"><a href="{{ route('items.index') }}">BACK TO LIST</a></div>
    </div>
    <div class="row justify-content-center">
        <div class="col-6">
            Name: {{ $item->name }}
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-6">
            Price: {{ $item->price }}
        </div>
    </div>
</div>
@endsection
