<?php
/** @var \App\User $user */
/** @var \App\User $teamMember */
?>

@extends('_landing')

@section('title')
    <title>
        Starter website | {{ Util::appName() }}
    </title>
@endsection

@section('content')
    <div class="mt-10 mx-auto max-w-screen-xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 xl:mt-28">
        <div class="text-center">
            <h2 class="text-4xl tracking-tight leading-10 font-extrabold text-gray-900 sm:text-5xl sm:leading-none md:text-6xl">
                Do some <br class='lg:hidden'/> <span class='text-indigo-600'>cool stuff</span>
            </h2>
            <p class="mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                Using this sweet starter kit
            </p>
            <div class="mt-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8">
                <div class="rounded-md shadow">
                    <a href="#first-button" class="bg-indigo-600 hover:bg-indigo-500 focus:shadow-outline-indigo focus:outline-none  w-full flex items-center justify-center px-8 py-3 border border-transparent text-base leading-6 font-medium rounded-md text-white transition duration-150 ease-in-out md:py-4 md:text-lg md:px-10">
                        First thing to do
                    </a>
                </div>
                <div class="mt-3 rounded-md shadow sm:mt-0 sm:ml-3">
                    <a href="/auth?redirect=/account/companies/new"
                       class="text-indigo-600 bg-white hover:text-indigo-500 w-full flex items-center justify-center px-8 py-3 border border-transparent text-base leading-6 font-medium rounded-md focus:outline-none focus:shadow-outline-blue transition duration-150 ease-in-out md:py-4 md:text-lg md:px-10">
                        Second thing!
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="relative pt-16 pb-20 px-4 sm:px-6 lg:pt-24 lg:pb-28 lg:px-8 bg-gray-100 mt-16">
        <div class="relative max-w-7xl mx-auto">
            <div class="text-center">
                <h2 class="text-3xl leading-9 tracking-tight font-extrabold text-gray-900 sm:text-4xl sm:leading-10">
                    Team
                </h2>
                {{--<p class="mt-3 max-w-2xl mx-auto text-xl leading-7 text-gray-500 sm:mt-4">--}}
                {{--Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ipsa libero labore natus atque, ducimus sed.--}}
                {{--</p>--}}
            </div>
            <div class="mt-12 grid gap-5 max-w-lg mx-auto lg:grid-cols-3 lg:max-w-none">
                @foreach ($teamMembers as $teamMember)
                    <div class="flex flex-col rounded-lg shadow-lg overflow-hidden">
                        <div class="flex-1 bg-white p-6 flex flex-col justify-between">
                            <div class="flex-1">
                                <div class="mb-2">
                                    <img src="{{ $teamMember->avatar() }}" class="w-20 h-20 rounded-full">
                                </div>
                                <h3 class="mt-2 text-xl leading-7 font-semibold text-gray-900">
                                    {{ $teamMember->name() }}
                                </h3>
                                <p class="mt-3 text-base leading-6 text-gray-500">
                                    {{ $teamMember->about() }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="py-12 bg-white">
        <div class="max-w-screen-lg mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                {{--<p class="text-base leading-6 text-indigo-600 font-semibold tracking-wide uppercase">How it works</p>--}}
                <h3 class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl sm:leading-10">
                    Here's how it works
                </h3>
                <p class="mt-4 max-w-2xl text-xl leading-7 text-gray-500 lg:mx-auto">
                Lorem ipsum dolor sit amet consect adipisicing elit. Possimus magnam voluptatum cupiditate veritatis in accusamus quisquam.
                </p>
            </div>

            <div class="mt-10">
                <ul class="md:grid md:grid-cols-2 md:col-gap-8 md:row-gap-10">
                    <li>
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                    @include('svg.icon-eye', ['classes' => 'h-6 w-6'])
                                </div>
                            </div>
                            <div class="ml-4">
                                <h5 class="text-lg leading-6 font-medium text-gray-900">
                                    1. Do the first thing!
                                </h5>
                                <p class="mt-2 text-base leading-6 text-gray-500">
                                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Maiores impedit perferendis suscipit eaque, iste dolor cupiditate blanditiis ratione.
                                </p>
                            </div>
                        </div>
                    </li>
                    <li class="mt-10 md:mt-0">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                    @include('svg.icon-eye', ['classes' => 'h-6 w-6'])
                                </div>
                            </div>
                            <div class="ml-4">
                                <h5 class="text-lg leading-6 font-medium text-gray-900">
                                    2. Do the second thing!
                                </h5>
                                <p class="mt-2 text-base leading-6 text-gray-500">
                                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Maiores impedit perferendis suscipit eaque, iste dolor cupiditate blanditiis ratione.
                                </p>
                            </div>
                        </div>
                    </li>
                    <li class="mt-10 md:mt-0">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                    @include('svg.icon-eye', ['classes' => 'h-6 w-6'])
                                </div>
                            </div>
                            <div class="ml-4">
                                <h5 class="text-lg leading-6 font-medium text-gray-900">
                                    3. Do the first thing!
                                </h5>
                                <p class="mt-2 text-base leading-6 text-gray-500">
                                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Maiores impedit perferendis suscipit eaque, iste dolor cupiditate blanditiis ratione.
                                </p>
                            </div>
                        </div>
                    </li>
                    <li class="mt-10 md:mt-0">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                    @include('svg.icon-eye', ['classes' => 'h-6 w-6'])
                                </div>
                            </div>
                            <div class="ml-4">
                                <h5 class="text-lg leading-6 font-medium text-gray-900">
                                    4. Do the fourth thing!
                                </h5>
                                <p class="mt-2 text-base leading-6 text-gray-500">
                                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Maiores impedit perferendis suscipit eaque, iste dolor cupiditate blanditiis ratione.
                                </p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="bg-gray-50 pt-16 pb-20 px-4 sm:px-6 lg:pt-24 lg:pb-28 lg:px-8">
        <div class="relative max-w-lg mx-auto lg:max-w-7xl">
            <div class="grid gap-16 lg:grid-cols-3 lg:col-gap-5 lg:row-gap-12">
                @foreach ($blogs as $blog)
                    <div>
                        <div>
                            <a href="{{ $blog->url() }}" class="inline-block">
                                <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium leading-5 bg-{{ $blog->categoryColorClass() }}-100 text-{{ $blog->categoryColorClass() }}-800">
                                    {{ $blog->category() }}
                                </span>
                            </a>
                        </div>
                        <a href="{{ $blog->url() }}" class="block">
                            <h3 class="mt-4 text-xl leading-7 font-semibold text-gray-900">
                                {{ $blog->title()  }}
                            </h3>
                            <p class="mt-3 text-base leading-6 text-gray-500">
                                {{ substr($blog->content(), 0, 200) }}...
                            </p>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
