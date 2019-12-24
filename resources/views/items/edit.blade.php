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
        <form action="{{ route('items.update', ['item' => $item->id]) }}" method="post" class="col-6">
            @csrf @method('put')
            <label for="name">Name</label><input value="{{ $item->name }}" class="form-control" type="text" name="name" id="name" autocomplete="off">
            <label for="price">Price</label><input value="{{ $item->price }}" class="form-control" type="number" name="price" id="price" autocomplete="off">
            <input type="submit" class="btn btn-primary" value="submit" />
        </form>
    </div>
</div>
@endsection
