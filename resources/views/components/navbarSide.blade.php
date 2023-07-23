<div class="hidden 2xl:block basis-[250px]">
    <ul class="py-4 flex flex-col gap-2 font-semibold">
        <li class="hover:text-amber-500 rounded cursor-pointer p-1 {{ Route::currentRouteName() == 'dashboard' ? 'text-amber-500' : '' }}"><x-svg.home stroke="currentColor" class="w-7 h-7 inline mr-2 align-bottom" fill="none" />Dashboard</li>
        <li class="hover:text-amber-500 rounded cursor-pointer p-1"><x-svg.search stroke="currentColor" class="w-7 h-7 inline mr-2 align-bottom" fill="none" />Explore Books</li>
        <li class="hover:text-amber-500 rounded cursor-pointer p-1"><x-svg.earth stroke="currentColor" class="w-7 h-7 inline mr-2 align-bottom" fill="none" />Explore community</li>
        <li class="hover:text-amber-500 rounded cursor-pointer p-1 mt-4"><x-svg.container stroke="currentColor" class="w-7 h-7 inline mr-2 align-bottom" fill="none" />My Books</li>
    </ul>
</div>