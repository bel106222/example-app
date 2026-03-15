@extends('layouts.main')

@section('title', 'Заказы')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <div class="container mx-auto px-4 py-8 max-w-7xl">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                    Заказы
                </h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">
                    Все заказы сервисного центра
                </p>
            </div>

            <a href="{{ route('orders.create') }}"
               class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700
                  text-white font-medium rounded-lg shadow-md transition-all duration-200
                  transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Добавить заказ
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
                            Номер
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Дата заказа
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Заказчик
                        </th>
                        <th scope="col" class="px-6 py-4 w-1/5 break-words text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Описание
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Сумма
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Выполнен
                        </th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Оплачен
                        </th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Действия
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($orders as $order)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-gray-300">
                                    {{ $order->orderNumber }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-gray-300">
                                    {{ $order->created_at }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-gray-300">
                                    {{ $users->firstWhere('id', $order->userId)->name }}
                                </div>
                            </td>
                            <td class="px-6 py-4 w-1/5 break-words whitespace-normal">
                                <div class="text-sm text-gray-900 dark:text-gray-300">
                                    {{ $order->orderDescription }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-gray-300">
                                    {{ $order->orderSum }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                @if($order->isCompleted)
                                    <span title="Выполнен" style="color: green; font-size: 18px;">●</span>
                                @else
                                    <span title="Не выполнен" style="color: red; font-size: 18px;">●</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                @if($order->isPaid)
                                    <span title="Оплачен" style="color: green; font-size: 18px;">●</span>
                                @else
                                    <span title="Не оплачен" style="color: red; font-size: 18px;">●</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-4">
                                    <!-- Просмотр -->
                                    <a href="{{ route('orders.show', $order) }}"
                                       class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition"
                                       title="Просмотр">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>

                                    <!-- Редактирование -->
                                    <a href="{{ route('orders.show', $order) }}"
                                       class="text-amber-600 dark:text-amber-400 hover:text-amber-800 dark:hover:text-amber-300 transition"
                                       title="Редактировать">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.828 2.828L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zM16.862 4.487L19.5 7.125" />
                                        </svg>
                                    </a>

                                    <!-- Удаление -->
                                    <form action="{{ route('orders.destroy', $order) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('Вы уверены, что хотите удалить заказ №{{ addslashes($order->orderNumber) }}?')"
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
                                <p class="text-lg">Заказы пока отсутствуют</p>
                                <a href="{{ route('orders.create') }}"
                                   class="mt-4 inline-block text-indigo-600 dark:text-indigo-400 hover:underline">
                                    Добавить первый заказ →
                                </a>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($orders->hasPages())
                <div class="px-6 py-5 border-t border-gray-200 dark:border-gray-700">
                    {{ $orders->links() }}
                    <!-- или {{ $orders->links('pagination::tailwind') }} если хочешь именно tailwind-стиль -->
                </div>
            @endif

        </div>

    </div>
@endsection
