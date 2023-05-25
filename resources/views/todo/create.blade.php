<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ ('Todo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                <form method="post" action="{{ route('todo.store') }}" class="">
                        @csrf
                        @method('post')
                        <div class="mb-6">
                            <x-input-label for="tittle" :value="('Title')" />
                            <x-text-input id="tittle" name="tittle" type="text" class="block w-full mt-1" required
                                autofocus autocomplete="tittle" />
                            <x-input-error class="mt-2" :messages="$errors->get('tittle')" />
                        </div>

                        <div class="mb-6">
                            <x-input-label for="category" :value="('Category')" />
                            <x-select id="category" name="category_id" class="block w-full mt-1">
                                <option value="">Empty</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->tittle }}</option>
                                @endforeach
                            </x-select>
                            <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ ('Save') }}</x-primary-button>
                            <a href="{{ route('todo.index') }}"
                                class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest
                                            text-gray-700 uppercase transition duration-150 ease-in-out
                                            bg-white border border-gray-300 rounded-md shadow-sm dark:bg-gray-800
                                            dark:border-gray-500 dark:text-gray-300 hover:bg-gray-50
                                            dark:hover:bg-gray-700 focus:outline-none focus:ring-2
                                            focus:ring-indigo-500 focus:ring-offset-2
                                            dark:focus:ring-offset-gray-800 disabled:opacity-25">{{ __('Cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>