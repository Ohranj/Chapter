<div class="flex flex-col border border-slate-400 p-2 rounded cursor-pointer" @click="openMessage = openMessage == item ? {} : item; toggleIsReadState()">
    <div class="flex gap-2">          
        <div class="w-9 h-9">
            <template x-if="item.inverse.profile.has_avatar">
                <img class="object-cover rounded-full inline h-full w-full" :src="'/storage/avatars/' + item.inverse.profile.avatar" />
            </template>
            <small x-show="!item.inverse?.profile.has_avatar" class="w-full h-full flex flex-col justify-center rounded-full bg-gradient-to-tr text-center from-amber-400 to-red-300 text-slate-700 font-semibold" x-text="item.inverse?.initials"></small> 
        </div>
        <div class="grow flex flex-col">
            <small class="font-semibold" x-text="item.inverse.full_name"></small>
            <small class="italic" x-text="item.inverse.profile.slogan"></small>
        </div>
        <template x-if="!item.is_read">
            <x-svg.envelope-closed stroke="red" class="w-4 h-4" fill="none" />
        </template>
        <x-svg.direct-message stroke="#f59e0b" class="w-4 h-4" fill="#f59e0b" />
    </div>
    <div x-cloak x-show="openMessage.id == item.id" x-collapse class="flex flex-col gap-2">
        <hr class="border border-slate-600 border-dashed mt-4">
        <div class="flex flex-col">
            <div :class="openMessage.commentable_id == user.id ? 'text-slate-200 text-right items-end' : 'text-amber-500'" class="flex flex-col">
                <small class="text-slate-400" x-text="item.created_at_human"></small>
                <small x-text="item.body"></small>
            </div>   
            <template x-for="reply in item.replies">
                <div :class="reply.commentable_id == user.id ? 'text-slate-200 text-right items-end' : 'text-amber-500'" class="flex flex-col mt-8">
                    <small class="text-slate-400" x-text="reply.created_at_human"></small>
                    <small x-text="reply.body"></small>
                </div>  
            </template>
        </div>       
    </div>
</div>