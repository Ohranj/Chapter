<x-layouts.client>
    <x-slot name="main_wrapper">
        <div class="flex flex-col h-full">
            <x-landing-page.navbar></x-landing-page.navbar>
            <div class="self-center grow flex flex-col justify-around relative w-full xl:w-2/5">
                <div class="absolute w-full text-center flex flex-col items-center gap-8" x-show="toggle" x-transition.duration.700ms>
                    <p>Card Pilot offers a unique and modern approach towards sharing your personal business card amongst your client base. We simplify the process of generating leads and maintaining contact. For more information around what we offer, click the <q class="underline font-semibold decoration-2 underline-offset-2">discover</q> tab above.</p>
                    <x-svg.undraw_professional_card />
                </div>
                <div class="absolute w-full text-center flex flex-col items-center gap-8" x-cloak x-show="!toggle" x-transition.duration.700ms>
                    <p>Card Pilot offers a quick and easy way to contact and organise your Business Network within our all-in-one networking tool. We simplify the process of finding suitable contacts for your needs. For more information around how we can help, click the <q class="underline font-semibold decoration-2 underline-offset-2">discover</q> tab above.</p>
                    <x-svg.undraw_hire />
                </div>
                <label class="mx-auto cursor-pointer mt-auto mb-20">
                    <div class="relative">
                        <input type="checkbox" :checked="toggle" @click="toggle = !toggle" class="sr-only">
                        <div class="block w-24 h-8 rounded-full" :class="toggle ? 'bg-indigo-500' : 'bg-teal-500'"></div>
                        <div class="dot absolute left-2 top-1 bg-white w-6 h-6 rounded-full transition duration-700" :class="toggle ? '' : 'translate-x-14'"></div>
                    </div>
                </label>
            </div>
        </div>
    </x-slot>
</x-layouts.client>