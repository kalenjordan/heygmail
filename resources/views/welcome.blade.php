<?php
/** @var \App\User $user */
/** @var \App\User $teamMember */
?>

@extends('_landing')

@section('title')
    <title>
        It's like Hey but for Gmail | {{ Util::appName() }}
    </title>
@endsection

@section('content')
    <div class="mx-auto max-w-screen-xl py-16 sm:px-6">
        <div class="text-center">
            <h2 class="text-4xl tracking-tight leading-10 font-extrabold text-gray-900 sm:text-5xl sm:leading-none md:text-6xl">
                It's like Hey <br class='lg:hidden'/> <span class='text-indigo-600'>but for Gmail</span>
            </h2>
            <div class="mt-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8">
                <div class="rounded-md shadow">
                    <a href="#how-it-works"
                       class="bg-indigo-600 hover:bg-indigo-500 focus:shadow-outline-indigo focus:outline-none  w-full flex items-center justify-center px-8 py-3 border border-transparent text-base leading-6 font-medium rounded-md text-white transition duration-150 ease-in-out md:py-4 md:text-lg md:px-10">
                        How it works
                    </a>
                </div>
                <div class="mt-3 rounded-md shadow sm:mt-0 sm:ml-3">
                    <a href="https://github.com/kalenjordan/heygmail"
                       class="text-indigo-600 bg-white hover:text-indigo-500 w-full flex items-center justify-center px-8 py-3 border border-transparent text-base leading-6 font-medium rounded-md focus:outline-none focus:shadow-outline-blue transition duration-150 ease-in-out md:py-4 md:text-lg md:px-10">
                        @include('svg.icon-github', ['classes' => 'w-6 h-6 mr-2'])
                        Download
                    </a>
                </div>
            </div>

            <div class="mt-12 mx-auto max-w-lg justify-center">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/oydseLZGoz4" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>

        </div>
    </div>

    <div id="how-it-works" class="py-12 bg-white">
        <div class="max-w-screen-lg mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                {{--<p class="text-base leading-6 text-indigo-600 font-semibold tracking-wide uppercase">How it works</p>--}}
                <h3 class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl sm:leading-10">
                    Here's how it works
                </h3>
                <p class="mt-4 max-w-2xl text-xl leading-7 text-gray-500 lg:mx-auto">
                    This is a quick tool I built for myself to use. If you're not a developer familiar with Laravel,
                    you'll probably have some trouble setting it up.
                </p>
            </div>

            <div class="mt-10">
                <ul class="md:grid md:grid-cols-2 md:col-gap-8 md:row-gap-10">
                    <li>
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                    1
                                </div>
                            </div>
                            <div class="ml-4">
                                <h5 class="text-lg leading-6 font-medium text-gray-900">
                                    Download and install locally
                                </h5>
                            </div>
                        </div>
                    </li>
                    <li class="mt-10 md:mt-0">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                    2
                                </div>
                            </div>
                            <div class="ml-4">
                                <h5 class="text-lg leading-6 font-medium text-gray-900">
                                    Install the Chrome extension
                                </h5>
                            </div>
                        </div>
                    </li>
                    <li class="mt-10 md:mt-0">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                    3
                                </div>
                            </div>
                            <div class="ml-4">
                                <h5 class="text-lg leading-6 font-medium text-gray-900">
                                    Setup a minutely cron to process incoming mail
                                </h5>
                            </div>
                        </div>
                    </li>
                    <li class="mt-10 md:mt-0">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                    4
                                </div>
                            </div>
                            <div class="ml-4">
                                <h5 class="text-lg leading-6 font-medium text-gray-900">
                                    Setup a single Gmail filter to send all mail to "To Process"
                                </h5>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

@endsection
