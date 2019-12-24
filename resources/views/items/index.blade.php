@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-2 ml-auto"><a href="{{ route('items.create') }}" class="btn btn-primary">CREATE</a></div>
    </div>
    <div class="row justify-content-center">
        <div class="col-8">
            @forelse($items as $item)
            <div class="row mb-2">
                <div class="col-4 d-flex align-items-center"><a href="{{ route('items.show', ['item' => $item->id]) }}">{{ $item->name }}</a></div>
                <div class="col-4 d-flex align-items-center">{{ $item->price }}</div>
                <div class="col d-flex align-items-center">
                    <a class="btn btn-primary" href="{{ route('items.edit', ['item' => $item->id]) }}">EDIT</a>
                </div>
                <div class="col d-flex align-items-center">
                    <form action="{{ route('items.destroy', ['item' => $item->id]) }}">
                        @csrf @method('delete')
                        <button class="btn btn-danger" type="submit">DELETE</button>
                    </form>
                </div>
            </div>
            @empty
            <div>
                No item availabel.
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
