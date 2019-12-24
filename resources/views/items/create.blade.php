@extends('layouts.app')

@section('content')
<div class="container">
    @if ($errors->any())
    <div class="row justify-content-center">
        <div class="col-6">
            @component('components.simple-error-alert')
            @endcomponent
        </div>
    </div>
    @endif
    <div class="row justify-content-center">
        <form action="{{ route('items.store') }}" method="post" class="col-6">
            @csrf
            <label for="name">Name</label><input class="form-control" type="text" name="name" value="{{ old('name') }}" id="name" autocomplete="off">
            <label for="price">Price</label><input class="form-control" type="number" name="price" value="{{ old('price') }}" id="price" autocomplete="off">
            <input type="submit" class="btn btn-primary" value="submit" />
        </form>
    </div>
</div>
@endsection
