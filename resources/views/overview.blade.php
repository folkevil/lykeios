@extends('layouts.backoffice.authenticated')

@section('content')
<!-- Content Heading -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div class="lg:w-3/4">
            <h2 class="font-light tracking-tight text-grey-darker">Overview</h2>
        </div>

        <!-- Search Input -->
        <div class="hidden text-grey-dark md:block w-1/4 relative">
            <input type="search" name="q" class="rounded-full w-full px-4 pl-10 py-2 bg-grey-light text-sm" placeholder="Search...">

            <div class="absolute pin-y flex items-center px-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-4 h-4" viewBox="0 0 20 20"><path d="M12.9 14.32a8 8 0 1 1 1.41-1.41l5.35 5.33-1.42 1.42-5.33-5.34zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"/></svg>
            </div>
        </div>
    </div>
</div>

<!-- Overview -->
<div class="mb-8">
    <div class="flex flex-wrap">
        <div class="w-1/3 mb-4 md:w-1/6 md:m-0">
            <div class="text-3xl text-grey-darker mb-2">39</div>
            <div class="text-sm text-grey-dark tracking-tight font-light">Published Courses</div>
        </div>
        <div class="w-1/3 mb-4 md:w-1/6 md:m-0">
            <div class="text-3xl text-grey-darker mb-2">245</div>
            <div class="text-sm text-grey-dark tracking-tight font-light">Enrolled Students</div>
        </div>
    </div>
</div>

<!-- Panel -->
<div class="mb-8">
    <div class="bg-white shadow rounded p-4">
        <div>
            <div class="text-grey-darker mb-2">Panel Heading</div>
            <div class="text-grey text-xs">Panel Sub-Heading</div>
        </div>
    </div>
</div>

<!-- Simple Table -->
<div class="mb-8">
    <table class="w-full" style="border-collapse: collapse;">
        <thead class="bg-grey-light text-2xs uppercase text-grey-darkest tracking-tight">
            <tr>
                <th class="p-3 text-left">Name</th>
                <th class="hidden md:table-cell p-3 text-left">E-mail</th>
                <th class="p-3 text-left">Status</th>
                <th class="hidden md:table-cell p-3 text-left">Role</th>
                <th width="10%" class=""></th>
            </tr>
        </thead>

        <tbody class="text-sm">
            <tr class="border-b border-grey-light">
                <td class="p-3">
                    <div class="flex items-center">
                        <img src="img/avatar.jpg" class="block rounded-full h-8 w-8 mr-3">
                        Ian Rodrigues
                    </div>
                </td>
                <td class="hidden md:table-cell p-3 text-grey-darker vertical-center">ian@lykeios.org</td>
                <td class="p-3 text-grey-darker">Active</td>
                <td class="hidden md:table-cell p-3 text-grey-darker">Administrator</td>
                <td class="p-3 text-center">
                    <div class="inline-block relative">
                        <a href="#" role="button" class="row-actions inline-flex items-center px-2 py-2 rounded text-grey-dark text-xs rounded-full hover:bg-grey-light">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 12a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0-6a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 12a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"/></svg>
                        </a>

                        <div class="text-left bg-white shadow absolute pin-r flex flex-col rounded w-32 z-10">
                            <span class="px-4 py-4 text-grey-darker text-2xs uppercase font-bold">Actions</span>
                            <a href="" class="px-4 py-2 text-grey-dark text-xs hover:bg-grey-lighter">Edit</a>
                            <a href="" class="px-4 py-2 text-grey-dark text-xs hover:bg-grey-lighter">Delete</a>
                        </div>
                    </div>
                </td>
            </tr>

            <tr class="border-b border-grey-light">
                <td class="p-3">
                    <div class="flex items-center">
                        <div class="block rounded-full mr-3 p-2 bg-grey-light inline-flex items-center ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 fill-current text-grey-dark" viewBox="0 0 20 20"><path d="M5 5a5 5 0 0 1 10 0v2A5 5 0 0 1 5 7V5zM0 16.68A19.9 19.9 0 0 1 10 14c3.64 0 7.06.97 10 2.68V20H0v-3.32z"/></svg>
                        </div>
                        John Doe
                    </div>
                </td>
                <td class="hidden md:table-cell p-3 text-grey-darker">john@lykeios.org</td>
                <td class="p-3 text-grey-darker">Inactive</td>
                <td class="hidden md:table-cell p-3 text-grey-darker">Administrator</td>
                <td class="p-3 text-center">
                    <div class="inline-block relative">
                        <a href="" role="button" class="inline-flex items-center px-2 py-2 rounded text-grey-dark text-xs rounded-full hover:bg-grey-light">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 12a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0-6a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 12a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"/></svg>
                        </a>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
