@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg overflow-hidden md:shadow-md">
    <div class="md:flex">
        <div class="w-full p-6">
            <div class="text-center">
                <h1 class="text-2xl font-bold text-gray-700">Înregistrare</h1>
                <p class="text-gray-500">Creează un cont nou</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="mt-6">
                @csrf

                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Nume</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" class="input input-bordered w-full @error('name') input-error @enderror" required autofocus>
                    @error('name')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <div class="form-control w-full mt-4">
                    <label class="label">
                        <span class="label-text">Email</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" class="input input-bordered w-full @error('email') input-error @enderror" required>
                    @error('email')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <div class="form-control w-full mt-4">
                    <label class="label">
                        <span class="label-text">Parolă</span>
                    </label>
                    <input type="password" name="password" class="input input-bordered w-full @error('password') input-error @enderror" required>
                    @error('password')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <div class="form-control w-full mt-4">
                    <label class="label">
                        <span class="label-text">Confirmă Parola</span>
                    </label>
                    <input type="password" name="password_confirmation" class="input input-bordered w-full" required>
                </div>

                <div class="mt-6">
                    <button type="submit" class="btn btn-primary w-full">Înregistrare</button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Ai deja un cont? <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Conectează-te</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection