<div class="basis-[250px]">
    <ul class="py-4 flex flex-col gap-2 font-semibold">
        <li class="hover:bg-slate-400 rounded cursor-pointer p-1 {{ Route::currentRouteName() == 'dashboard' ? 'bg-slate-400' : '' }}"><x-svg.home stroke="currentColor" class="w-7 h-7 inline mr-2 align-bottom" fill="none" />Dashboard</li>
        <li class="hover:bg-slate-400 rounded cursor-pointer p-1"><x-svg.container stroke="currentColor" class="w-7 h-7 inline mr-2 align-bottom" fill="none" />My Books</li>
        <li class="hover:bg-slate-400 rounded cursor-pointer p-1"><x-svg.search stroke="currentColor" class="w-7 h-7 inline mr-2 align-bottom" fill="none" />Search Books</li>
        <li class="hover:bg-slate-400 rounded cursor-pointer p-1"><x-svg.earth stroke="currentColor" class="w-7 h-7 inline mr-2 align-bottom" fill="none" />Explore community</li>
    </ul>
</div>