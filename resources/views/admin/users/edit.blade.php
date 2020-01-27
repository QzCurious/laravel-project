@extends('layouts.admin')

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
        <form action="{{ route('admin.users.update', $user) }}" method="post" class="col-6">
            @csrf @method('put')
            <label for="name">Name</label><input value="{{ $user->name }}" class="form-control" type="text" name="name" id="name" autocomplete="off">
            <label for="phone">Phone</label><input value="{{ $user->phone }}" class="form-control" type="tel" name="phone" id="phone">
            <label for="email">E-mail</label><input value="{{ $user->email }}" class="form-control" type="email" name="email" id="email">
            <label for="password">Password</label><input class="form-control" type="password" name="password" id="password" required>
            <label for="password_confirmation">Confirmation Password</label><input class="form-control" type="password_confirmation" name="password_confirmation" id="password_confirmation" required>
            <label for="birthday">Birthday</label><input value="{{ $user->birthday }}" class="form-control" type="date" name="birthday" id="birthday" autocomplete="off">
            <label for="gender">Gender</label>
            <select name="gender" id="gender" class="form-control">
                <option value="">Select One</option>
                <option value="1" {{ $user->gender == 1 ? 'selected' : '' }}>Male</option>
                <option value="2" {{ $user->gender == 2 ? 'selected' : '' }}>Female</option>
            </select>
            <label for="address">Address</label><input value="{{ $user->address }}" class="form-control" type="text" name="address" id="address">
            <input type="submit" class="btn btn-primary" value="submit" />
        </form>
    </div>
</div>
@endsection
