<x-layouts.auth>
    <x-slot name="main_wrapper">
        <div class="flex flex-col h-full gap-8">
            <x-navbarTop></x-navbarTop>
            <div class="flex grow gap-8 sm:w-5/6 mx-auto">
                <x-navbarSide />
                <div class="grow py-4">
                    <h1 class="text-xl text-amber-500 font-semibold">My Inbox</h1>
                    <small>Use this space to check out your private conversations with members of the community. Additionally, you'll find replies to any public comments you make here.</small>
                    <div class="flex flex-col gap-4 mt-12">
                        <div class="flex gap-6">
                            <div class="grow flex flex-col basis-7/12 gap-3">
                                <small>Write it in here.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-layouts.auth>

//WORK ON THE DIRECT MESSAGE FEATURE IN EXPLORE COMMUNITY AND RENDER THEM HERE