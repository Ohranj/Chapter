<div class="bg-slate-700 rounded p-4 relative shadow-sm shadow-slate-500">
    <div class="py-4 flex gap-2 items-center">
        <div class="w-9 h-9 shadow shadow-amber-400 rounded-full font-semibold text-slate-700 tracking-wide">
            <template x-if="entry.author.profile.has_avatar">
                <img class="object-cover rounded-full inline h-full w-full" :src="'/storage/avatars/' + entry.author.profile.avatar" />
            </template>
            <small x-show="!entry.author.profile.has_avatar" class="w-full h-full flex flex-col justify-center rounded-full bg-gradient-to-tr text-center from-amber-400 to-red-300 text-inherit " x-text="entry.author.initials"></small>      
        </div>
        <div class="flex flex-col">
            <p class="text-amber-500 font-semibold text-sm" x-text="entry.author.full_name"></p> 
            <small class="text-slate-400" x-text="entry.created_at_human"></small>
            
        </div>                       
    </div>
    <div class="md:w-4/5 mx-auto mx-auto flex flex-col gap-2">
        <div>
            <small class="font-semibold" x-text="entry.entry"></small>
        </div>
        <template x-if="entry.has_image">
            <image class="rounded-lg" :src="'/storage/timelines/' + entry.image_path" />
        </template>
    </div>
    <small class="font-semibold absolute top-4 right-4 flex gap-1 items-center">
        <span x-text="entry.likes_count"></span>
        <template x-if="entry.likes_exists">
            <x-svg.love stroke="#f59e0b" class="w-6 h-6 ml-auto block cursor-pointer hover:scale-[1.05]" fill="#f59e0b" @click="toggleEntryLike(entry)" />
        </template>
        <template x-if="!entry.likes_exists">
            <x-svg.love stroke="#f59e0b" class="w-6 h-6 ml-auto block cursor-pointer hover:scale-[1.05]" fill="transparent" @click="toggleEntryLike(entry)" />
        </template>
    </small>
    <small class="font-semibold absolute top-12 right-4 flex gap-1 items-center">
        <span>0</span>
        <x-svg.comment stroke="#e2e8f0" class="w-6 h-6 ml-auto block cursor-pointer hover:scale-[1.05]" fill="#e2e8f0" />
    </small>
</div>