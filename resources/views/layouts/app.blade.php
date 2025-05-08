<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Task Manager') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-100">
    <div class="flex flex-col min-h-screen">

        <div class="navbar bg-base-100 shadow-md">
            <div class="flex-1">
                <a href="{{ route('tasks.index') }}" class="btn btn-ghost normal-case text-xl">Task Manager</a>
            </div>
            <div class="flex-none">
                <ul class="menu menu-horizontal px-1">
                    <li><a href="{{ route('tasks.index') }}">Tasks</a></li>
                    @auth
                        <li><a href="{{ route('tasks.create') }}">Create Task</a></li>
                        <li>
                            <div class="dropdown dropdown-end">
                                <label tabindex="0" class="btn btn-ghost">
                                    {{ Auth::user()->name }}
                                </label>
                                <ul tabindex="0" class="menu dropdown-content z-[1] p-2 shadow bg-base-100 rounded-box w-52 mt-4">
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-error w-full">Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @else
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                    @endauth
                </ul>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success shadow-lg max-w-4xl mx-auto mt-4">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error shadow-lg max-w-4xl mx-auto mt-4">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <main class="flex-grow container mx-auto py-6 px-4">
            @yield('content')
        </main>

        <footer class="footer footer-center p-4 bg-base-300 text-base-content">
            <div>
                <p>&copy; {{ date('Y') }} Task Manager. All rights reserved.</p>
            </div>
        </footer>
    </div>
</body>
</html>