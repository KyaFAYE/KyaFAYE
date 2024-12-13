<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
                <div>
                    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                        <div class="container">
                            <a class="navbar-brand" href="{{ route('dashboard') }}">Admin Panel</a>
                            <div class="collapse navbar-collapse">
                                <ul class="navbar-nav ms-auto">
                                    <li class="nav-item"><a class="nav-link" href="{{ route('categories.index') }}">Catégories</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('tables.index') }}">Tables</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}">Déconnexion</a></li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                    <div class="container mt-4">
                        @yield('content')
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

