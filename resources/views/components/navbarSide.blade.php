<div class="hidden 2xl:block min-w-[250px] basis-[250px]">
    <ul class="py-4 flex flex-col gap-2 font-semibold">
        <li class="hover:text-amber-500 rounded cursor-pointer p-1 {{ Route::currentRouteName() == 'dashboard' ? 'text-amber-500' : '' }}">
            <a href="{{ route('dashboard') }}" class="text-inherit block">
                <x-svg.home stroke="currentColor" class="w-7 h-7 inline mr-2 align-bottom" fill="none" />
                Home
            </a>
        </li>
        <li class="hover:text-amber-500 rounded cursor-pointer p-1 {{ Route::currentRouteName() == 'explore_books' ? 'text-amber-500' : '' }}">
            <a href="{{ route('explore_books') }}" class="text-inherit block">
                <x-svg.search stroke="currentColor" class="w-7 h-7 inline mr-2 align-bottom" fill="none" />
                Explore Books
            </a>
        </li>
        <li class="hover:text-amber-500 rounded cursor-pointer p-1 {{ Route::currentRouteName() == 'explore_community' ? 'text-amber-500' : '' }}">
            <a href="{{ route('explore_community') }}" class="text-inherit block">
                <x-svg.earth stroke="currentColor" class="w-7 h-7 inline mr-2 align-bottom" fill="none" />
                Explore Community
            </a>
        </li>
        <li class="hover:text-amber-500 rounded cursor-pointer p-1 mt-8 {{ Route::currentRouteName() == 'my_books' ? 'text-amber-500' : '' }}">
            <a href="{{ route('my_books') }}" class="text-inherit block">
                <x-svg.container stroke="currentColor" class="w-7 h-7 inline mr-2 align-bottom" fill="none" />
                My Books
            </a>
        </li>
        <li class="hover:text-amber-500 rounded cursor-pointer p-1 {{ Route::currentRouteName() == 'my_stats' ? 'text-amber-500' : '' }}">
            <a href="{{ route('my_stats') }}" class="text-inherit block">
                <x-svg.chart stroke="currentColor" class="w-7 h-7 inline mr-2 align-bottom" fill="none" />
                My Stats
            </a>
        </li>
    </ul>
</div>