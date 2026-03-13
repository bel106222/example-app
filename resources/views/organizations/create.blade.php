@extends('layouts.main')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-3xl">

        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                        Новая организация
                    </h1>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">
                        Добавление новой организации в систему
                    </p>
                </div>

                <a href="{{ route('organizations.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700
                      hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200
                      font-medium rounded-lg transition-colors">
                    ← Назад к списку
                </a>
            </div>
        </div>

        <!-- Card -->
        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">

            <div class="p-6 sm:p-8">
{{--                <form method="POST" action="{{ route('organizations.create') }}" enctype="multipart/form-data">--}}
                <form method="POST" action="{{ route('organizations.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="space-y-6">

                        <!-- Префикс / наименование -->
                        <div class="flex flex-col sm:flex-row sm:items-start gap-6">
{{--                            <div class="flex-shrink-0">--}}
{{--                                <div class="h-20 w-20 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600--}}
{{--                                        flex items-center justify-center text-white font-bold text-3xl shadow-md overflow-hidden">--}}
{{--                                        {{ strtoupper(substr($organization->title, 0, 3)) }}--}}
{{--                                </div>--}}
{{--                            </div>--}}

                            <div class="flex-1 space-y-4">
                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Наименование организации <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text"
                                           name="title"
                                           id="title"
                                           value="{{ old('title') }}"
                                           required
                                           autocomplete="title"
                                           class="block w-full rounded-lg border-gray-300 dark:border-gray-600
                                              dark:bg-gray-700 dark:text-white shadow-sm
                                              focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5
                                              @error('title') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">

                                    @error('title')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Адрес -->
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Адрес <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   name="address"
                                   id="address"
                                   value="{{ old('address') }}"
                                   required
                                   autocomplete="address"
                                   class="block w-full rounded-lg border-gray-300 dark:border-gray-600
                                      dark:bg-gray-700 dark:text-white shadow-sm
                                      focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5
                                      @error('address') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">

                            @error('address')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Реквизиты -->
                        <div class="flex-1 space-y-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Реквизиты <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                       name="details"
                                       id="details"
                                       value="{{ old('details') }}"
                                       required
                                       autocomplete="details"
                                       class="block w-full rounded-lg border-gray-300 dark:border-gray-600
                                              dark:bg-gray-700 dark:text-white shadow-sm
                                              focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5
                                              @error('details') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">

                                @error('details')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Признак юр.лица -->
                        <div>
                            <label for="isLegal" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Юридическое лицо?
                            </label>
                            <input type="checkbox"
                                   name="isLegal"
                                   id="isLegal"
                                   value="1"
                                   {{ old('isLegal') ? 'checked' : '' }}
                                   class="rounded border-gray-300 dark:border-gray-600
                                      dark:bg-gray-700 dark:text-white shadow-sm
                                      focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">

                            @error('isLegal')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Кнопки -->
                        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200 dark:border-gray-700 mt-8">
                            <a href="{{ route('organizations.index') }}"
                               class="px-5 py-2.5 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600
                                  text-gray-800 dark:text-gray-200 font-medium rounded-lg transition">
                                Отмена
                            </a>

                            <button type="submit"
                                    class="inline-flex items-center px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700
                                       text-white font-medium rounded-lg shadow-md transition-all duration-200
                                       focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Создать организацию
                            </button>
                        </div>

                    </div>
                </form>

            </div>
        </div>

    </div>

@endsection
