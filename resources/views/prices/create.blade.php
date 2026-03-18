@extends('layouts.main')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-3xl">

        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                        Новая цена
                    </h1>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">
                        Добавление новой цены на услугу сервисного центра
                    </p>
                </div>

                <a href="{{ route('prices.index') }}"
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
                <form method="POST" action="{{ route('prices.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-6">

                        <!-- Категория -->
                        <div class="flex-1 space-y-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Категория <span class="text-red-500">*</span>
                                </label>
                                <select
                                    name="categoryId"
                                    id="categoryId"
                                    required
{{--                                    onchange="filterServices(this)"--}}
                                    class="block w-full rounded-lg border-gray-300 dark:border-gray-600
                            dark:bg-gray-700 dark:text-white shadow-sm
                            focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5
                            @error('category_id') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                                    <option value="">Выберите категорию...</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->categoryName }}</option>
                                    @endforeach
                                </select>

                                @error('categoryId')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror

                            </div>
                        </div>

                        <!-- Услуга -->
                        <div class="flex-1 space-y-4">
                            <div>
                                <label for="service" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Услуга <span class="text-red-500">*</span>
                                </label>
                                <select
                                    name="serviceId"
                                    id="serviceId"
                                    required
                                    class="block w-full rounded-lg border-gray-300 dark:border-gray-600
                            dark:bg-gray-700 dark:text-white shadow-sm
                            focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5
                            @error('serviceId') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                                    <option value="">Выберите услугу...</option>
                                    @foreach($services as $service)
                                        <option data-category-id="{{ $service->categoryId }}" value="{{ $service->id }}">{{ $service->serviceName }}</option>
                                    @endforeach
                                </select>

                                @error('serviceId')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror

                            </div>
                        </div>

                        <!-- Цена -->
                        <div>
                            <label for="cost" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Цена <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   name="cost"
                                   id="cost"
                                   value="{{ old('cost') }}"
                                   required
                                   autocomplete="cost"
                                   class="block w-full rounded-lg border-gray-300 dark:border-gray-600
                      dark:bg-gray-700 dark:text-white shadow-sm
                      focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5
                      @error('cost') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">

                            @error('cost')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Признак почасовой оплаты -->
                        <div>
                            <label for="isLegal" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Цена почасовая?
                            </label>
                            <input type="checkbox"
                                   name="isTime"
                                   id="isTime"
                                   value="1"
                                   {{ old('isTime') ? 'checked' : '' }}
                                   class="rounded border-gray-300 dark:border-gray-600
                      dark:bg-gray-700 dark:text-white shadow-sm
                      focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">

                            @error('isTime')
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
                                   autocomplete="off"
                                   class="block w-full rounded-lg border-gray-300 dark:border-gray-600
                     dark:bg-gray-700 dark:text-white shadow-sm
                     focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5
                     @error('created_at') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">

                            @error('created_at')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Кнопки -->
                        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200 dark:border-gray-700 mt-8">
                            <a href="{{ route('prices.index') }}"
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
                                Создать цену
                            </button>
                        </div>

                    </div>
                </form>

            </div>
        </div>

    </div>

{{--    TODO: Скрипт для обработки фильтра услуг--}}
    <script>
        async function loadServices(url) {
            const response = await fetch(url);
            const result = await response.json();

            console.log(result.data);
            let select = document.getElementById('serviceId');
            select.innerHTML='';

            result.data.forEach(service => {
                const option = document.createElement('option');

                option.value = service.id;
                option.textContent = service.serviceName;

                select.appendChild(option);
            });
        }

        document.getElementById('categoryId').addEventListener('change', function (){
            //alert(document.getElementById('categoryId').value);
            let categoryId = document.getElementById('categoryId').value;
            loadServices('/categories/' + categoryId + '/services');
        })

        //serviceId
    </script>

@endsection
