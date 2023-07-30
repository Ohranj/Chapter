<div x-data="{showSettings: false, showMobile: false}">
    <div class="font-semibold flex gap-8 items-start 2xl:items-end">
        <p class="text-2xl tracking-wider font-extrabold align-middle"><x-svg.book stroke="orange" class="w-10 h-10 inline-block align-middle" fill="none" />24Nabu</p>
        <div class="hidden 2xl:block ml-auto relative">
            <div :class="showSettings ? 'text-amber-500' : ''" class="hover:underline decoration-2 underline-offset-4 cursor-pointer hover:text-amber-500 text-xs flex items-center gap-2" @click="showSettings = !showSettings">
                <img x-cloak x-show="user.profile.has_avatar" class="object-cover rounded-full w-9 h-9 inline shadow-sm shadow-amber-200" :src="'/storage/' + user.profile.avatar" />
                <small x-show="!user.profile.has_avatar" class="text-sm font-semibold w-9 h-9 rounded-full flex flex-col justify-center shadow shadow-amber-400 rounded-full bg-gradient-to-tr text-center from-amber-400 to-red-300 text-slate-700 tracking-wide" x-text="user.initials"></small> 
                <span class="text-inherit font-semibold" x-text="user.full_name"></span>
            </div>
            <div x-cloak x-show="showSettings" class="absolute w-[175px] right-0 rounded shadow shadow-slate-500 mt-1" x-collapse @click.away="showSettings = false">
                <ul class="p-1 text-right">
                    <li class="text-xs cursor-pointer rounded px-1 hover:text-amber-500 hover:underline underline-offset-2 decoration-2 mb-1">
                        <a href="{{ route('profile', Auth::id()) }}" class="text-inherit">My Profile</a>
                    </li>
                    <li class="text-xs cursor-pointer rounded px-1 hover:text-amber-500 hover:underline underline-offset-2 decoration-2" @click="logout">
                        <x-svg.logout stroke="currentColor" class="mr-1 w-5 h-5 inline" />
                        Logout
                    </li>
                </ul>
            </div>
        </div>
        <x-svg.menu stroke="currentColor" class="2xl:hidden ml-auto w-10 h-10 cursor-pointer hover:scale-[1.05]" fill="none" @click="showMobile = !showMobile" />
    </div>
    <div x-cloak x-show="showMobile" x-collapse class="2xl:hidden absolute bg-slate-600 top-0 left-0 right-0 px-2 z-40" @click.away="showMobile = false">
        <div class="flex justify-between items-center pt-8">
            <div :class="showSettings ? 'text-amber-500' : ''" class="hover:underline decoration-2 underline-offset-4 cursor-pointer hover:text-amber-500 text-xs flex items-center gap-2">
                <img x-cloak x-show="user.profile.has_avatar" class="object-cover rounded-full w-9 h-9 inline shadow-sm shadow-amber-200" :src="'/storage/' + user.profile.avatar" />
                <small x-show="!user.profile.has_avatar" class="text-sm font-semibold w-9 h-9 rounded-full flex flex-col justify-center shadow shadow-amber-400 rounded-full bg-gradient-to-tr text-center from-amber-400 to-red-300 text-slate-700 tracking-wide" x-text="user.initials"></small> 
                <span class="text-inherit font-semibold" x-text="user.full_name"></span>
            </div>
            <small class="text-amber-500 font-semibold cursor-pointer hover:underline underline-offset-2 decoration-2" @click="showMobile = false">Hide Menu</small>
        </div>
        <ul class="py-4 flex flex-col gap-2 font-semibold">
            <li class="w-2/5 lg:w-1/5 mx-auto hover:text-amber-500 rounded cursor-pointer p-1 {{ Route::currentRouteName() == 'dashboard' ? 'text-amber-500' : '' }}">
                <a href="{{ route('dashboard') }}" class="text-inherit">
                    <x-svg.home stroke="currentColor" class="w-7 h-7 inline mr-2 align-bottom" fill="none" />
                    Home
                </a>
           </li>
            <li class="w-2/5 lg:w-1/5 mx-auto hover:text-amber-500 rounded cursor-pointer p-1 {{ Route::currentRouteName() == 'explore_books' ? 'text-amber-500' : '' }}">
                <a href="{{ route('explore_books') }}" class="text-inherit">
                    <x-svg.search stroke="currentColor" class="w-7 h-7 inline mr-2 align-bottom" fill="none" />
                    Explore Books
                </a>
            </li>
            <li class="w-2/5 lg:w-1/5 mx-auto hover:text-amber-500 rounded cursor-pointer p-1 {{ Route::currentRouteName() == 'explore_community' ? 'text-amber-500' : '' }}">
                <a href="{{ route('explore_community') }}" class="text-inherit">
                    <x-svg.earth stroke="currentColor" class="w-7 h-7 inline mr-2 align-bottom" fill="none" />
                    Explore community
                </a>
            </li>
            <li class="w-2/5 lg:w-1/5 mx-auto hover:text-amber-500 rounded cursor-pointer p-1 {{ Route::currentRouteName() == 'my_books' ? 'text-amber-500' : '' }}">
                <a href="{{ route('my_books', Auth::id()) }}" class="text-inherit">
                    <x-svg.container stroke="currentColor" class="w-7 h-7 inline mr-2 align-bottom" fill="none" />
                    My Books
                </a>
            </li>
            <li class="w-2/5 lg:w-1/5 mx-auto hover:text-amber-500 rounded cursor-pointer p-1 {{ Route::currentRouteName() == 'profile' ? 'text-amber-500' : '' }}">
                <a href="{{ route('profile', Auth::id()) }}" class="text-inherit"><x-svg.avatar stroke="currentColor" class="w-7 h-7 inline mr-2 align-bottom" fill="none" />My Profile</a>    
            </li>
            <li class="w-2/5 lg:w-1/5 mx-auto hover:text-amber-500 rounded cursor-pointer p-1"><x-svg.logout stroke="currentColor" class="w-7 h-7 inline mr-2 align-bottom" fill="none" />Logout</li>
        </ul>
    </div>
</div>
