@props(['var', 'title'])

<div x-cloak x-show="{{ $var }}" x-transition class="fixed top-0 left-0 right-0 z-50 w-full p-4 inset-0 max-h-full flex flex-col justify-center backdrop-blur-sm backdrop-brightness-75">
    <div class="relative w-full max-w-2xl max-h-full mx-auto">
        <div class="relative rounded-lg shadow shadow-gray-700 bg-slate-600">
            <div class="flex items-center justify-between p-4 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-200">
                    {{ $title }}
                </h3>
                <svg class="w-4 h-4 hover:scale-[1.1] cursor-pointer" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14" @click="{{ $var }} = false">
                    <path stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </div>
            {{ $content }}
        </div>
    </div>
</div>