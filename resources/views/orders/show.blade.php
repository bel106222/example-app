@extends('layouts.main')
@section('content')
    <div class="container mx-auto px-4 py-8 max-w-8xl">
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
                        Редактирование заказа
                    </h1>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">
                        Изменение данных заказа №: {{ $order->orderNumber }}
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
                <form method="POST" action="{{ route('orders.update', $order->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="space-y-6">
                        <!-- Номер документа -->
                        <div>
                            <label for="orderNumber" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Номер документа <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   name="orderNumber"
                                   id="orderNumber"
                                   value="{{ old('orderNumber', $order->orderNumber) }}"
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
                                   value="{{ old('created_at', $order->created_at) }}"
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
                                   value="{{ old('orderDescription', $order->orderDescription) }}"
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
                                        <option value="{{ $user->id }}" {{ old('userId', $order->userId) === $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('userId')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Признак завершения работ -->
                        <div>
                            <label for="isCompleted" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Заказ выполнен?
                            </label>
                            <input type="checkbox"
                                   name="isCompleted"
                                   id="isCompleted"
                                   value="1"
                                   {{ old('isCompleted', $order->isCompleted) ? 'checked' : '' }}
                                   class="rounded border-gray-300 dark:border-gray-600
                              dark:bg-gray-700 dark:text-white shadow-sm
                              focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">

                            @error('isCompleted')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Признак оплаты услуг -->
                        <div>
                            <label for="isPaid" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Заказ оплачен?
                            </label>
                            <input type="checkbox"
                                   name="isPaid"
                                   id="isPaid"
                                   value="1"
                                   {{ old('isPaid', $order->isPaid) ? 'checked' : '' }}
                                   class="rounded border-gray-300 dark:border-gray-600
                              dark:bg-gray-700 dark:text-white shadow-sm
                              focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">

                            @error('isPaid')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="container mx-auto px-4 py-8 max-w-8xl">

                            <!-- Header -->
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                                <div>
                                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                                        Услуги по заказу
                                    </h1>
                                    <p class="mt-2 text-gray-600 dark:text-gray-400">
                                        Все оказанные услуги по этой заявке
                                    </p>
                                </div>

                                <a href="{{ route('orderItems.create') }}"
                                   class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700
                                    text-white font-medium rounded-lg shadow-md transition-all duration-200
                                    transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Добавить услугу в заказ
                                </a>
                            </div>

                            <!-- Card -->
                            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700">

                                <!-- Table -->
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                        <thead class="bg-gray-50 dark:bg-gray-900/50">
                                        <tr>
                                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                Услуга
                                            </th>
                                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                Исполнитель
                                            </th>
                                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                Удалённо
                                            </th>
                                            <th scope="col" class="px-6 py-4 break-words text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                Количество
                                            </th>
                                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                Сумма
                                            </th>
                                            <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                Действия
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @forelse ($orderItems as $orderItem)
                                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900 dark:text-gray-300">
                                                        {{ $services->firstWhere('id', $orderItem->serviceId)->serviceName }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900 dark:text-gray-300">
                                                        {{ $users->firstWhere('id', $orderItem->userId)->name }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                    @if($orderItem->isOnline)
                                                        <span title="Удалённо" style="color: green; font-size: 18px;">●</span>
                                                    @else
                                                        <span title="У заказчика" style="color: red; font-size: 18px;">●</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 break-words whitespace-normal">
                                                    <div class="text-sm text-gray-900 dark:text-gray-300">
                                                        {{ $orderItem->quantity }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900 dark:text-gray-300">
                                                        {{ $orderItem->cost }}
                                                    </div>
                                                </td>

                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <div class="flex items-center justify-end gap-4">
                                                        <!-- Просмотр -->
                                                        <a href="{{ route('orderItems.show', $orderItem) }}"
                                                           class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition"
                                                           title="Просмотр">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                            </svg>
                                                        </a>

                                                        <!-- Редактирование -->
                                                        <a href="{{ route('orderItems.show', $orderItem) }}"
                                                           class="text-amber-600 dark:text-amber-400 hover:text-amber-800 dark:hover:text-amber-300 transition"
                                                           title="Редактировать">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.828 2.828L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zM16.862 4.487L19.5 7.125" />
                                                            </svg>
                                                        </a>

                                                        <!-- Удаление -->
                                                        <form action="{{ route('orderItems.destroy', $orderItem) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                    onclick="return confirm('Вы уверены, что хотите удалить услугу {{ addslashes($services->firstWhere('id', $orderItem->serviceId)->serviceName) }}?')"
                                                                    class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 transition"
                                                                    title="Удалить">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="px-6 py-16 text-center text-gray-500 dark:text-gray-400">
                                                    <div class="text-6xl mb-4">😔</div>
                                                    <p class="text-lg">Услуги пока отсутствуют</p>
                                                    <a href="{{ route('orderItems.create') }}"
                                                       class="mt-4 inline-block text-indigo-600 dark:text-indigo-400 hover:underline">
                                                        Добавить первую услугу в заказ →
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
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
                                Ok
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
