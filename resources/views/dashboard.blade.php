<x-layouts.auth>
    <x-slot name="main_wrapper">
        <div class="flex flex-col h-full gap-8">
            <x-navbarTop></x-navbarTop>
            <div class="flex grow gap-8">
                <x-navbarSide />
                <div class="grow py-4">
                    <div class="shadow-sm shadow-slate-500 p-2 rounded flex flex-col gap-2">
                        <div class="flex gap-2 items-center">
                            <img x-cloak x-show="user.profile.has_avatar" class="object-cover rounded-full w-9 h-9 inline shadow-sm shadow-amber-200" :src="'/storage/' + user.profile.avatar" />
                            <x-svg.avatar x-cloak x-show="!user.profile.has_avatar" class="w-9 h-9 rounded-full inline align-middle" stroke="white" />   
                             
                        </div>
                    </div>
                    {{-- My Current book
                    My Timeline
                    Whats popular
                    Add a status
                    View my friendn and their status / current book --}}
                </div>
                <div class="hidden xl:flex xl:flex-col xl:gap-4 xl:max-w-[275px] xl:basis-[275px] py-4" x-data="{showTrending: true, showFriends: true}">
                    <div class="rounded shadow shadow-slate-500 p-2 flex flex-col bg-slate-700">
                        <div class="flex justify-between items-center cursor-pointer h-12" @click="showTrending = !showTrending">
                            <h2 class="text-amber-500 font-semibold" >Currently Trending</h2>
                            <x-svg.chevron-down x-cloak x-show="!showTrending" stroke="currentColor" class="w-5 h-5" fill="none" />
                            <x-svg.chevron-up x-show="showTrending" stroke="currentColor" class="w-5 h-5" fill="none" />
                        </div>
                     
                        <div class="flex flex-col gap-2 divide-y divide-dashed divide-slate-500" x-cloak x-show="showTrending" x-collapse>
                            <div class="text-xs group cursor-pointer pt-1">
                                <p class="text-inherit overflow-hidden text-ellipsis whitespace-nowrap block group-hover:italic">
                                    Harry Potter and the Philosophers Stone Volume 1 about some other stuff
                                </p>
                                <p class="text-inherit overflow-hidden text-ellipsis whitespace-nowrap block group-hover:italic">JK Rowling</p>
                            </div>
                            <div class="text-xs group cursor-pointer pt-1">
                                <p class="text-inherit overflow-hidden text-ellipsis whitespace-nowrap block group-hover:italic">
                                    The Lord of the Rings. The Fellowship of the Rings
                                </p>
                                <p class="text-inherit overflow-hidden text-ellipsis whitespace-nowrap block group-hover:italic">JRR Tolkien</p>
                            </div>
                            <div class="text-xs group cursor-pointer pt-1">
                                <p class="text-inherit overflow-hidden text-ellipsis whitespace-nowrap block group-hover:italic">
                                    The Art of Motorcycle Maintenance
                                </p>
                                <p class="text-inherit overflow-hidden text-ellipsis whitespace-nowrap block group-hover:italic">Posh Name</p>
                            </div>
                        </div>
                    </div>
                    <div class="rounded shadow shadow-slate-500 p-2 flex flex-col bg-slate-700">
                        <div class="flex justify-between items-center cursor-pointer h-9" @click="showFriends = !showFriends">
                            <h2 class="text-amber-500 font-semibold" >My Friends</h2>
                            <x-svg.chevron-down x-cloak x-show="!showFriends" stroke="currentColor" class="w-5 h-5" fill="none" />
                            <x-svg.chevron-up x-show="showFriends" stroke="currentColor" class="w-5 h-5" fill="none" />
                        </div>
                        <div class="flex flex-col gap-2 divide-y divide-dashed divide-slate-500" x-cloak x-show="showFriends" x-collapse>
                            <div class="text-xs group cursor-pointer pt-1">
                                <p class="text-inherit overflow-hidden text-ellipsis whitespace-nowrap block group-hover:italic">
                                    Friend Number1
                                </p>
                            </div>
                            <div class="text-xs group cursor-pointer pt-1">
                                <p class="text-inherit overflow-hidden text-ellipsis whitespace-nowrap block group-hover:italic">
                                    Friend Number2
                                </p>
                            </div>
                            <div class="text-xs group cursor-pointer pt-1">
                                <p class="text-inherit overflow-hidden text-ellipsis whitespace-nowrap block group-hover:italic">
                                    Friend Number3
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-layouts.auth>