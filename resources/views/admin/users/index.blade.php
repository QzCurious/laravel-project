@extends('layouts.admin')

@section('title', 'User List')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-2 ml-auto"><a href="{{ route('admin.users.create') }}" class="btn btn-primary">CREATE</a></div>
    </div>
    <div class="row justify-content-center">
        <div class="col-8">
            @forelse($users as $user)
            <div class="row mb-2">
                <div class="col-4 d-flex align-items-center"><a href="{{ route('admin.users.show', ['user' => $user->id]) }}">{{ $user->name }}</a></div>
                <div class="col-4 d-flex align-items-center">{{ $user->price }}</div>
                <div class="col d-flex align-items-center">
                    <a class="btn btn-primary" href="{{ route('admin.users.edit', ['user' => $user->id]) }}">EDIT</a>
                </div>
                <div class="col d-flex align-items-center">
                    <form action="{{ route('admin.users.destroy', ['user' => $user->id]) }}">
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
