<?php
/** @var \App\User $user */
?>

@extends('account._app')

@section('title')
    <title>Settings | {{ env('APP_NAME') }}</title>
    <script>
        googleApiKey = '{{ env('GOOGLE_GEOCODING_API') }}';
    </script>
@endsection

@section('content')
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:leading-9 sm:truncate">
                        Settings
                    </h2>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto py-6 px-6 lg:px-8">
        <form action="/account/settings" method="POST">
            {{ csrf_field() }}
            <div>
                <div>
                    <div class="mt-6 max-w-md mx-auto">

                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium leading-5 text-gray-700">Email</label>
                            <div class="mt-3 inline-block relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    @include('svg.icon-email', ['classes' => 'h-5 w-5 text-gray-400'])
                                </div>
                                <span class="pl-10 form-input items-center px-3 rounded-l-md border border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                                    {{ $user->email() }}
                                </span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium leading-5 text-gray-700">
                                Name
                            </label>
                            <div class="mt-1 rounded-md shadow-sm">
                                <input name="name" id="name" type="text" value="{{ $user->name() }}"
                                       class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"/>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="about" class="block text-sm font-medium leading-5 text-gray-700">
                                About
                            </label>
                            <div class="mt-1 rounded-md shadow-sm">
                                <textarea class="form-textarea block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                          name="about" id="about" rows="3">{{ $user->about() }}</textarea>
                            </div>
                            <p class="mt-2 text-sm text-gray-500">
                                Copy and paste a list of your tasks in here.
                            </p>
                        </div>

                        <location-button inline-template :api-key="'{{ $user->apiKey() }}'" location-prop="{{ $user->location() }}">
                            <div class="mb-4">
                                <label for="email" class="block text-sm font-medium leading-5 text-gray-700">Location</label>
                                <div class="mt-3 inline-block relative ">
                                    <template v-if="location">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            @include('svg.icon-location', ['classes' => 'h-5 w-5 text-gray-400'])
                                        </div>
                                        <span class="pl-10 form-input items-center px-3 rounded-l-md border border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                                            @{{ location }}
                                            <a href="javascript://" class="text-indigo-600" @click="deleteLocation" v-tooltip="'Delete location'">
                                                @include('svg.icon-minus', ['classes' => 'h-5 w-5 inline'])
                                            </a>
                                        </span>

                                        <span class="">
                                        </span>
                                    </template>
                                    <template v-else>
                                        <a href="javascript://" @click="shareLocation"
                                           class="py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                                            Share location
                                            <template v-if="loading">...</template>
                                        </a>
                                    </template>
                                </div>
                            </div>
                        </location-button>

                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium leading-5 text-gray-700">
                                Status
                            </label>
                            <div class="mt-1 rounded-md shadow-sm">
                                <select id="status" name="status" class="form-select block transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                                    <option {{ $user->status() == 'Disabled' ? 'selected' : '' }} >Disabled</option>
                                    <option {{ $user->status() == 'Private' ? 'selected' : '' }} >Private</option>
                                    <option {{ $user->status() == 'Public' ? 'selected' : '' }}>Public</option>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="mt-8 border-t border-gray-200 pt-5">
                <div class="flex justify-end">
                    <span class="inline-flex rounded-md shadow-sm">
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