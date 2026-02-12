@extends('layouts.blog')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('posts.index') }}" class="text-indigo-600 hover:text-indigo-800 flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to all posts
        </a>
    </div>

    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Create New Post</h1>
        <p class="mt-2 text-gray-600">Share your thoughts with the world.</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-lg p-8">
        <form method="POST" action="{{ route('posts.store') }}">
            @csrf

            <!-- Title -->
            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Post Title <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="title" 
                    id="title" 
                    value="{{ old('title') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('title') border-red-500 @enderror"
                    placeholder="Enter an engaging title..."
                    required
                >
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Excerpt -->
            <div class="mb-6">
                <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">
                    Excerpt (Optional)
                </label>
                <textarea 
                    name="excerpt" 
                    id="excerpt" 
                    rows="2"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('excerpt') border-red-500 @enderror"
                    placeholder="A short summary of your post..."
                >{{ old('excerpt') }}</textarea>
                <p class="mt-1 text-sm text-gray-500">Brief description that appears on the blog homepage.</p>
                @error('excerpt')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Content -->
            <div class="mb-6">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                    Content <span class="text-red-500">*</span>
                </label>
                <textarea 
                    name="content" 
                    id="content" 
                    rows="12"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('content') border-red-500 @enderror"
                    placeholder="Write your post content here..."
                    required
                >{{ old('content') }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div class="mb-8">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Status <span class="text-red-500">*</span>
                </label>
                <div class="flex items-center space-x-6">
                    <label class="flex items-center">
                        <input 
                            type="radio" 
                            name="status" 
                            value="draft" 
                            {{ old('status', 'draft') === 'draft' ? 'checked' : '' }}
                            class="w-4 h-4 text-indigo-600 focus:ring-indigo-500"
                        >
                        <span class="ml-2 text-gray-700">Draft</span>
                    </label>
                    <label class="flex items-center">
                        <input 
                            type="radio" 
                            name="status" 
                            value="published"
                            {{ old('status') === 'published' ? 'checked' : '' }}
                            class="w-4 h-4 text-indigo-600 focus:ring-indigo-500"
                        >
                        <span class="ml-2 text-gray-700">Published</span>
                    </label>
                </div>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <a href="{{ route('posts.index') }}" class="text-gray-600 hover:text-gray-800">
                    Cancel
                </a>
                <button 
                    type="submit" 
                    class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    Create Post
                </button>
            </div>
        </form>
    </div>
</div>
@endsection