@extends('layouts.admin')

@section('title', 'Settings')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- General Settings -->
    <div class="card">
        <div class="card-body">
            <div class="flex items-center mb-4">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-900">General Settings</h3>
                    <p class="text-sm text-gray-500">Site information and contact details</p>
                </div>
            </div>
            <a href="{{ route('admin.settings.general') }}" class="btn btn-primary w-full">
                Configure
            </a>
        </div>
    </div>

    <!-- SEO Settings -->
    <div class="card">
        <div class="card-body">
            <div class="flex items-center mb-4">
                <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-900">SEO Settings</h3>
                    <p class="text-sm text-gray-500">Meta tags and search optimization</p>
                </div>
            </div>
            <a href="{{ route('admin.settings.seo') }}" class="btn btn-primary w-full">
                Configure
            </a>
        </div>
    </div>

    <!-- Social Media -->
    <div class="card">
        <div class="card-body">
            <div class="flex items-center mb-4">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Social Media</h3>
                    <p class="text-sm text-gray-500">Social media links and integration</p>
                </div>
            </div>
            <a href="{{ route('admin.settings.social') }}" class="btn btn-primary w-full">
                Configure
            </a>
        </div>
    </div>

    <!-- Analytics -->
    <div class="card">
        <div class="card-body">
            <div class="flex items-center mb-4">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Analytics</h3>
                    <p class="text-sm text-gray-500">Google Analytics and tracking</p>
                </div>
            </div>
            <a href="{{ route('admin.settings.analytics') }}" class="btn btn-primary w-full">
                Configure
            </a>
        </div>
    </div>

    <!-- Company Profile -->
    <div class="card">
        <div class="card-body">
            <div class="flex items-center mb-4">
                <div class="p-3 rounded-full bg-indigo-100 text-indigo-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Company Profile</h3>
                    <p class="text-sm text-gray-500">Company info, CTA, and server pulsa settings</p>
                </div>
            </div>
            <a href="{{ route('admin.settings.company') }}" class="btn btn-primary w-full">
                Configure
            </a>
        </div>
    </div>

    <!-- Contact Settings -->
    <div class="card">
        <div class="card-body">
            <div class="flex items-center mb-4">
                <div class="p-3 rounded-full bg-red-100 text-red-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2 2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Contact Form</h3>
                    <p class="text-sm text-gray-500">Contact form and auto-reply settings</p>
                </div>
            </div>
            <a href="{{ route('admin.settings.contact') }}" class="btn btn-primary w-full">
                Configure
            </a>
        </div>
    </div>

    <!-- Email Settings -->
    <div class="card">
        <div class="card-body">
            <div class="flex items-center mb-4">
                <div class="p-3 rounded-full bg-pink-100 text-pink-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Email Settings</h3>
                    <p class="text-sm text-gray-500">Gmail SMTP configuration</p>
                </div>
            </div>
            <a href="{{ route('admin.settings.email') }}" class="btn btn-primary w-full">
                Configure
            </a>
        </div>
    </div>

    <!-- Email Template Settings -->
    <div class="card">
        <div class="card-body">
            <div class="flex items-center mb-4">
                <div class="p-3 rounded-full bg-orange-100 text-orange-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Template & Logo Email</h3>
                    <p class="text-sm text-gray-500">Konfigurasi logo dan tampilan email profesional</p>
                </div>
            </div>
            <a href="{{ route('admin.settings.email-template') }}" class="btn btn-primary w-full">
                Configure
            </a>
        </div>
    </div>
</div>
@endsection