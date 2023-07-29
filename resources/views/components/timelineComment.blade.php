<div class="shadow shadow-slate-500 p-2 rounded flex flex-col gap-2">
    <input type="file" class="opacity-0 absolute top-0" x-ref="timelineImageInput" @change="uploadFileInputChanged($el)" accept="image/*" />
    <div class="flex gap-2 items-center">
        <img x-cloak x-show="user.profile.has_avatar" class="object-cover rounded-full w-9 h-9 inline shadow-sm shadow-amber-200" :src="'/storage/' + user.profile.avatar" />
        <div x-cloak x-show="!user.profile.has_avatar" class="shadow shadow-amber-400 rounded-full w-9 h-9 flex items-center justify-center text-slate-700 tracking-wide flex-col bg-gradient-to-tr from-amber-400 to-red-300">
            <small class="font-semibold" x-text="user.initials"></small>                       
        </div>
        <textarea rows="3" class="font-semibold grow text-xs bg-slate-700 rounded py-1 px-2 focus-visible:outline-none focus-visible:border resize-none focus-visible:border-slate-500" :placeholder="'Hello ' + user.name + ', what is on your mind?'" maxlength="475" x-model="entry.text"></textarea>
    </div>
    <div class="flex justify-between items-end">
        <x-svg.image x-show="!entry.file" class="ml-11 w-6 h-6 cursor-pointer hover:scale-[1.05]" stroke="currentColor" fill="none" @click="$refs.timelineImageInput.click()" />
        <template x-if="entry.file">
            <div class="flex items-end gap-2">
                <image class="ml-11 w-[75px] h-auto" :src="URL.createObjectURL(entry.file)" />
                <small x-text="entry.file.name"></small>
                <x-svg.trash stroke="#ef4444" class="w-5 h-5 cursor-pointer hover:scale-[1.1]" fill="none" @click="entry.file = null; $refs.timelineImageInput.value = ''" />
            </div>
        </template>
        <button class="bg-indigo-300 text-slate-800 w-[105px] rounded text-xs py-1 font-semibold hover:bg-indigo-400" @click="postBtnClicked">Post</button>
    </div>
</div>