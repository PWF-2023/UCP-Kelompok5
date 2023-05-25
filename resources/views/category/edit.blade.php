<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ ('Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7x1 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                <form method="post" action="{{ route('category.update', $category) }}" class="">
                        @csrf
                        @method('patch')
                        <div class="mb-6">
                            <x-input-label for="tittle" :value="('Tittle')"/>
                            <x-text-input id="tittle" name="tittle" type="text" class="mt-1 block w-full" 
                                :value="old('tittle',$category->tittle)" required autofocus autocomplete="tittle"/>
                            <x-input-error class="mt-2" :messages="$errors->get('tittle')"/>
                        </div>
                        <div class="flex item-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                            <x-cancel-button href=""/>
                        </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>