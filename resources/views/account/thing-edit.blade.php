<?php
/** @var \App\Thing $thing */
?>

@extends('account._app')

@section('title')
    <title>{{ $thing->name() }} | {{ env('APP_NAME') }}</title>
@endsection

@section('content')
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:leading-9 sm:truncate">
                        {{ $thing->name() }}
                    </h2>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto py-6 px-6 lg:px-8">
        <form action="{{ $thing->editUrl() }}" method="POST">
            {{ csrf_field() }}
            <div>
                <div>
                    <div class="mt-6 max-w-md mx-auto">

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium leading-5 text-gray-700">
                                Name
                            </label>
                            <div class="mt-1 rounded-md shadow-sm">
                                <input name="name" id="name" type="text" value="{{ $thing->name() }}"
                                       class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"/>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="about" class="block text-sm font-medium leading-5 text-gray-700">
                                Description
                            </label>
                            <div class="mt-1 rounded-md shadow-sm">
                                <textarea class="form-textarea block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                          name="description" id="description" rows="3">{{ $thing->description() }}</textarea>
                            </div>
                            <p class="mt-2 text-sm text-gray-500">
                                Add a description here
                            </p>
                        </div>

                        <div class="mb-4">
                            <label for="price" class="block text-sm font-medium leading-5 text-gray-700">Price</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm sm:leading-5">
                                        $
                                    </span>
                                </div>
                                <input id="price" name="price"
                                       class="form-input block w-full pl-7 pr-12 sm:text-sm sm:leading-5" placeholder="0.00"
                                       aria-describedby="price-currency" value="{{ $thing->priceFormatted() }}" />
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm sm:leading-5" id="price-currency">
                                        USD
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="mt-8 border-t border-gray-200 pt-5">
                <div class="flex justify-end">
                    <span class="inline-flex rounded-md shadow-sm">
                        <a href="/account/things/{{ $thing->id()  }}/delete" class="py-2 px-4 border border-gray-300 rounded-md text-sm leading-5 font-medium text-red-700 hover:text-red-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                            Delete
                        </a>
                    </span>

                    <span class="ml-3 inline-flex rounded-md shadow-sm">
                        <a href="/" class="py-2 px-4 border border-gray-300 rounded-md text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                            Cancel
                        </a>
                    </span>
                    <span class="ml-3 inline-flex rounded-md shadow-sm">
                        <input type="submit" value="Save"
                               v-shortkey="['meta', 'enter']" @shortkey="clickLink($event, '', false)" v-tooltip="'Cmd + Enter'"
                               class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                    </span>
                </div>
            </div>
        </form>

    </main>
@endsection