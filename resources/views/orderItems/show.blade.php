@extends('layouts.main')
@section('content')
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        @if (session('success'))
            <div class="fixed top-4 right-4 z-50 animate-fade-in">
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-lg max-w-md">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <p class="font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                        Редактирование услуги по заказу №{{ $orders->firstWhere('id', $orderItem->orderId)->orderNumber }}
                    </h1>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">
                        Изменение услуги: {{ $services->firstWhere('id', $orderItem->serviceId)->serviceName }}
                    </p>
                </div>

                <a href="{{ route('orders.show', $orders->firstWhere('id', $orderItem->orderId)) }}"
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
                <form method="POST" action="{{ route('orderItems.update', $orderItem->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="space-y-6">
                        <!-- Услуга -->
                        <div class="flex-1 space-y-4">
                            <div>
                                <label for="serviceId" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
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
                                        <option value="{{ $service->id }}" {{ old('serviceId', $orderItem->serviceId) === $service->id ? 'selected' : '' }}>
                                            {{ $service->serviceName }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('serviceId')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <!-- Исполнитель -->
                        <div class="flex-1 space-y-4">
                            <div>
                                <label for="userId" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Исполнитель <span class="text-red-500">*</span>
                                </label>
                                <select
                                    name="userId"
                                    id="userId"
                                    required
                                    class="block w-full rounded-lg border-gray-300 dark:border-gray-600
                                 dark:bg-gray-700 dark:text-white shadow-sm
                                 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5
                                 @error('userId') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                                    <option value="">Выберите исполнителя...</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('userId', $orderItem->userId) === $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('userId')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <!-- Количество -->
                        <div>
                            <label for="quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Количество <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   name="quantity"
                                   id="quantity"
                                   value="{{ old('quantity', $orderItem->quantity) }}"
                                   required
                                   autocomplete="quantity"
                                   class="block w-full rounded-lg border-gray-300 dark:border-gray-600
                                     dark:bg-gray-700 dark:text-white shadow-sm
                                     focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5
                                     @error('quantity') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">

                            @error('quantity')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Описание заказа -->
                        <div>
                            <label for="cost" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Стоимость <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   name="cost"
                                   id="cost"
                                   value="{{ old('cost', $orderItem->cost) }}"
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

                        <!-- Признак удалённого выполнения работ -->
                        <div>
                            <label for="isOnline" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Удалённо выполнено?
                            </label>
                            <input type="checkbox"
                                   name="isOnline"
                                   id="isOnline"
                                   value="1"
                                   {{ old('isOnline', $orderItem->isOnline) ? 'checked' : '' }}
                                   class="rounded border-gray-300 dark:border-gray-600
                              dark:bg-gray-700 dark:text-white shadow-sm
                              focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">

                            @error('isOnline')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Кнопки -->
                        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200 dark:border-gray-700 mt-8">
                            <a href="{{ route('orders.show', $orders->firstWhere('id', $orderItem->orderId)) }}"
                               class="px-5 py-2.5 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600
                                  text-gray-800 dark:text-gray-200 font-medium rounded-lg transition">
                                Отмена
                            </a>
                            <button type="submit"
                                    class="inline-flex items-center px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700
                                       text-white font-medium rounded-lg shadow-md transition-all duration-200
                                       focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Ok
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
