<div class="font-semibold flex gap-8 items-end" x-data="{showSettings: false}">
    <p class="text-2xl tracking-wider font-extrabold"><x-svg.book stroke="orange" class="w-10 h-10 inline-block align-middle" fill="none" />Chapter</p>
    <div class="ml-auto relative">
        <small class="hover:underline decoration-2 underline-offset-4 cursor-pointer" @click="showSettings = !showSettings">
            <x-svg.avatar class="w-9 h-9 rounded-full inline align-middle" stroke="white" />
            {{ Auth::user()->fullName() }}
        </small>
        <div x-cloak x-show="showSettings" class="absolute bg-slate-500 w-[200px] right-0 rounded ring-2 ring-slate-300" x-collapse>
            <ul class="p-2">
                <li class="cursor-pointer">My Profile</li>
                <li class="cursor-pointer">Logout</li>
            </ul>
        </div>
    </div>
</div>