@extends('layouts.main')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-3xl">

        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                        Новый заказ
                    </h1>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">
                        Добавление нового заказа на услуги сервисного центра
                    </p>
                </div>

                <a href="{{ route('orders.index') }}"
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
                <form method="POST" action="{{ route('orders.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-6">

                        <!-- Номер документа-->
                        <div>
                            <label for="orderNumber" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Номер документа <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   name="orderNumber"
                                   id="orderNumber"
                                   readonly
                                   value="{{ old('orderNumber', $currentOrderNumber) }}"
                                   required
                                   autocomplete="orderNumber"
                                   class="block w-full rounded-lg border-gray-300 dark:border-gray-600
                                       dark:bg-gray-700 dark:text-white shadow-sm
                                       focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5
                                       @error('orderNumber') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">

                            @error('orderNumber')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Дата создания -->
                        <div>
                            <label for="created_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Дата создания <span class="text-red-500">*</span>
                            </label>
                            <input type="datetime-local"
                                   name="created_at"
                                   id="created_at"
                                   value="{{ old('created_at') }}"
                                   required
                                   autocomplete="on"
                                   class="block w-full rounded-lg border-gray-300 dark:border-gray-600
                                    dark:bg-gray-700 dark:text-white shadow-sm
                                    focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5
                                    @error('created_at') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">

                            @error('created_at')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Описание заказа -->
                        <div>
                            <label for="orderDescription" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Описание заказа <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   name="orderDescription"
                                   id="orderDescription"
                                   value="{{ old('orderDescription') }}"
                                   required
                                   autocomplete="orderDescription"
                                   class="block w-full rounded-lg border-gray-300 dark:border-gray-600
                                    dark:bg-gray-700 dark:text-white shadow-sm
                                    focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5
                                    @error('orderDescription') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">

                            @error('orderDescription')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Заказчик -->
                        <div class="flex-1 space-y-4">
                            <div>
                                <label for="userId" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Заказчик <span class="text-red-500">*</span>
                                </label>
                                <select
                                    name="userId"
                                    id="userId"
                                    required
                                    class="block w-full rounded-lg border-gray-300 dark:border-gray-600
                                    dark:bg-gray-700 dark:text-white shadow-sm
                                    focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5
                                    @error('userId') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                                    <option value="">Выберите заказчика...</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>

                                @error('userId')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Кнопки -->
                        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200 dark:border-gray-700 mt-8">
                            <a href="{{ route('orders.index') }}"
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
                                Создать заказ
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
