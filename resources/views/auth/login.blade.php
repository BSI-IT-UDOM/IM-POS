@extends('layouts.header')
@vite('resources/css/app.css')

@section('content')
<div class="min-h-screen flex flex-col justify-between bg-cover bg-center bg-no-repeat" style="background-image: url('/images/login_background.jpg');">
    {{-- Main content --}}
    <div class="flex-grow flex items-center justify-center">
        <div class="w-full max-w-3xl p-8 backdrop-blur-md bg-white/80 rounded-lg shadow-lg">
            <div class="flex justify-center mb-3">
                <h1 class="text-2xl font-bold text-center">BSI INVENTORY MANAGEMENT WITH POS SYSTEM</h1>
            </div>
            <div class="flex flex-col sm:flex-row lg:items-center lg:justify-between p-4">
                <div class="w-full flex flex-col items-center justify-center space-y-2 lg:w-1/2">
                    <img src="storage/logos/Home Town Coffee Logo 3.png" alt="Company Logo" class="rounded-lg" style="max-width: 150px; height: auto;" />
                    <h2 class="text-lg font-semibold text-center">HOMETOWN CAFÉ</h2>
                    <p class="text-muted-foreground text-center">#178E0E1, Street 1972, Phnom Penh Thmey, Sen Sok 120801, Cambodia</p>
                </div>
                <div class="w-full lg:w-3/5 sm:pl-4">
                    <div class="w-full border border-border p-4 rounded-lg bg-white/90 backdrop-blur-sm">
                        <h3 class="text-center text-lg font-semibold pb-2">User Information</h3>
                        @if(session('status'))
                            <div class="mb-4 text-sm text-red-600">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form class="space-y-2" method="POST" action="{{ route('login') }}">
                            @csrf
                            <input id="sys_name" type="text" class="w-full p-2 border border-input rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-md transition duration-200 @error('sys_name') is-invalid @enderror" name="sys_name" value="{{ old('sys_name') }}" required placeholder="user name" autocomplete="sys_name" autofocus>
                            @error('sys_name')
                                <span class="invalid-feedback text-red-600" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <input placeholder="password" class="w-full p-2 border border-input rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-md transition duration-200 @error('password') is-invalid @enderror" id="password" type="password" name="password" required autocomplete="current-password" />
                            @error('password')
                                <span class="invalid-feedback text-red-600" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <button type="submit" class="w-full text-white py-2 rounded-lg hover:bg-blue-700 transition duration-300 bg-blue-600">LOG IN</button>
                        </form>
                    </div>
                    <div class="text-center text-muted-foreground mt-2">
                        <p>BSI IM-POS SYSTEM</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footer')
</div>
@endsection
