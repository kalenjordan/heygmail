<?php
/** @var \App\Thing $thing */
?>

@extends('account._app')

@section('title')
    <title>Things | {{ env('APP_NAME') }}</title>
@endsection

@section('content')
    <header class="bg-white shadow">

        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:leading-9 sm:truncate">
                        Things
                    </h2>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <span class="shadow-sm rounded-md">
                        <a href="/account/things/new" class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:shadow-outline-indigo focus:border-indigo-700 active:bg-indigo-700 transition duration-150 ease-in-out">
                            Add Thing
                        </a>
                    </span>
                </div>
            </div>
        </div>
    </header>

    @if (empty($things))
        <main class="max-w-xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <div class="max-w-xl bg-gray-50 sm:rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Add your first thing
                        </h3>
                        <div class="mt-2 max-w-xl text-sm leading-5 text-gray-500">
                            <p>
                                To get started, just click <strong>Add thing</strong> and
                                you can add the thing.
                            </p>
                        </div>
                        <div class="mt-5">
                            <span class="inline-flex rounded-md shadow-sm">
                                <a href="/account/things/new" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150">
                                    Add thing
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    @else
        <main class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <ul>
                    @foreach ($things as $thing)
                        <li class="border-t border-gray-200">
                            <a href="/account/things/{{ $thing->id() }}" class="block hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out">
                                <div class="flex items-center px-4 py-4 sm:px-6">
                                    <div class="min-w-0 flex-1 flex items-center">
                                        <div class="min-w-0 flex-1 px-4 md:grid md:grid-cols-2 md:gap-4">
                                            <div>
                                                <div class="text-sm leading-5 font-medium text-indigo-600 truncate">
                                                    {{ $thing->name() }}
                                                </div>
                                            </div>
                                            <div class="hidden md:block">
                                                <div class="mt-1 flex items-center text-sm leading-5 text-gray-500">
                                                    <span class="truncate">
                                                        @include('svg.icon-currency-dollar', ['classes' => 'w-5 h-5 inline'])
                                                        {{ $thing->priceFormatted() }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        @include('svg.icon-chevron-right', ['classes' => 'h-5 w-5 text-gray-400'])
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
                @endif
            </div>
        </main>
@endsection