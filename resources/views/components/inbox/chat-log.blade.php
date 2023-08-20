<div class="flex flex-col border border-slate-400 p-2 rounded" @click="openMessage = openMessage.id == item.id ? {} : item; toggleIsReadState()">
    <div class="flex gap-2 cursor-pointer">          
        <div class="w-9 h-9">
            <template x-if="item.inverse.profile.has_avatar">
                <img class="object-cover rounded-full inline h-full w-full" :src="'/storage/avatars/' + item.inverse.profile.avatar" />
            </template>
            <small x-show="!item.inverse?.profile.has_avatar" class="w-full h-full flex flex-col justify-center rounded-full bg-gradient-to-tr text-center from-amber-400 to-red-300 text-slate-700 font-semibold" x-text="item.inverse?.initials"></small> 
        </div>
        <div class="grow flex flex-col">
            <small class="font-semibold" x-text="item.inverse.full_name"></small>
            <small class="italic" x-text="item.inverse.profile.slogan"></small>
            <small class="text-slate-200 mt-4" x-text="item.body_snippet"></small>
        </div>
        <template x-if="!item.is_read">
            <x-svg.envelope-closed stroke="red" class="w-4 h-4" fill="none" />
        </template>
        <x-svg.direct-message stroke="#f59e0b" class="w-4 h-4" fill="#f59e0b" />
    </div>
    <div x-cloak x-show="openMessage.id == item.id" x-collapse class="flex flex-col gap-2" :class="{'opacity-10': !openMessage.id}">
        <hr class="border border-slate-600 border-dashed mt-4">
        <div class="flex flex-col max-h-[250px] overflow-y-scroll scrollbar-hide">
            <div :class="openMessage.commentable_id == user.id ? 'text-amber-500 text-right items-end ml-auto' : 'text-slate-200'" class="flex flex-col w-2/3">
                <small class="text-slate-400" x-text="item.created_at_human"></small>
                <small x-text="item.body"></small>
            </div>   
            <template x-for="reply in item.replies">
                <div :class="reply.commentable_id == user.id ? 'text-amber-500 text-right items-end ml-auto' : 'text-slate-200'" class="flex flex-col mt-10 w-2/3">
                    <small class="text-slate-400" x-text="reply.created_at_human"></small>
                    <small x-text="reply.body"></small>
                </div>  
            </template>
        </div>       
    </div>
</div>