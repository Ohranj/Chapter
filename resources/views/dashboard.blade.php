<x-layouts.auth>
    <x-slot name="main_wrapper">
        <div class="flex flex-col h-full gap-8" x-data="dashboard({ csrfToken: '{{ csrf_token() }}' })">
            <x-navbarTop></x-navbarTop>
            <div class="flex grow gap-8 sm:w-5/6 mx-auto">
                <x-navbarSide />
                <div class="grow py-4 flex flex-col gap-4">
                    <div class="shadow-sm shadow-slate-500 p-2 rounded flex flex-col gap-2">
                        <input type="file" class="opacity-0 absolute top-0" x-ref="timelineImageInput" @change="uploadFileInputChanged($el)" accept="image/*" />
                        <div class="flex gap-2 items-center">
                            <img x-cloak x-show="user.profile.has_avatar" class="object-cover rounded-full w-9 h-9 inline shadow-sm shadow-amber-200" :src="'/storage/' + user.profile.avatar" />
                            <x-svg.avatar x-cloak x-show="!user.profile.has_avatar" class="w-9 h-9 rounded-full inline align-middle" stroke="white" />   
                            <textarea rows="1" class="font-semibold w-full text-xs bg-slate-700 rounded-full py-1 px-2 focus-visible:outline-none focus-visible:border resize-none focus-visible:border-slate-500" placeholder="What is on your mind?" maxlength="225" x-model="entry.text"></textarea>
                        </div>
                        <div class="flex justify-between items-end">
                            <x-svg.image x-show="!entry.file" class="ml-11 w-6 h-6 cursor-pointer hover:scale-[1.05]" stroke="currentColor" fill="none" @click="$refs.timelineImageInput.click()" />
                            <template x-if="entry.file">
                                <div class="flex items-end gap-2">
                                    <image class="ml-11 w-[75px] h-auto" :src="URL.createObjectURL(entry.file)" />
                                    <small x-text="entry.file.name"></small>
                                </div>
                            </template>
                            <div>
                                <button class="bg-indigo-300 text-slate-800 w-[105px] rounded text-xs py-1 font-semibold hover:bg-indigo-400" @click="postBtnClicked">Post</button>
                            </div>
                        </div>
                    </div>
                    <small class="font-semibold my-3 text-right block">Currently Reading: <span class="text-amber-500">The Lord of The Rings</span></small>
                    <template x-for="entry in timeline">
                        <div class="bg-slate-700 rounded px-4">
                            <div class="p-4 flex flex-col gap-2">
                                <small class="text-slate-400" x-text="entry.created_at_human"></small>
                                <small class="font-semibold" x-text="entry.entry"></small>
                            </div>
                            <template x-if="entry.image_path">
                                <image :src="'/storage/timelines/' + entry.image_path" />
                            </template>
                        
                            <div class="p-4">
                                <small class="text-center block text-amber-500 font-semibold cursor-pointer hover:underline underline-offset-2 decoration-2">View Comments</small>
                            </div>
                        </div>
                    </template>
                </div>
                <div class="hidden xl:flex xl:flex-col xl:gap-4 xl:min-w-[325px] xl:basis-[325px] py-4" x-data="{showTrending: true, showFriends: true}">
                    <div class="rounded shadow shadow-slate-500 p-2 flex flex-col bg-transparent">
                        <div class="flex justify-between items-center cursor-pointer h-12" @click="showTrending = !showTrending">
                            <h2 class="text-amber-500 font-semibold" >Top Trending</h2>
                            <x-svg.chevron-down x-cloak x-show="!showTrending" stroke="currentColor" class="w-5 h-5" fill="none" />
                            <x-svg.chevron-up x-show="showTrending" stroke="currentColor" class="w-5 h-5" fill="none" />
                        </div>
                        <div class="flex flex-col gap-2 divide-y divide-dashed divide-slate-500" x-cloak x-show="showTrending" x-collapse>
                            <div class="text-xs group cursor-pointer pt-1">
                                <p class="text-inherit overflow-hidden text-ellipsis whitespace-nowrap block group-hover:italic">
                                    Harry Potter and the Philosophers Stone Volume 1 about some other stuff
                                </p>
                                <p class="text-inherit overflow-hidden text-ellipsis whitespace-nowrap block group-hover:italic text-right">JK Rowling</p>
                            </div>
                            <div class="text-xs group cursor-pointer pt-1">
                                <p class="text-inherit overflow-hidden text-ellipsis whitespace-nowrap block group-hover:italic">
                                    The Lord of the Rings. The Fellowship of the Rings
                                </p>
                                <p class="text-inherit overflow-hidden text-ellipsis whitespace-nowrap block group-hover:italic text-right">JRR Tolkien</p>
                            </div>
                            <div class="text-xs group cursor-pointer pt-1">
                                <p class="text-inherit overflow-hidden text-ellipsis whitespace-nowrap block group-hover:italic">
                                    The Art of Motorcycle Maintenance
                                </p>
                                <p class="text-inherit overflow-hidden text-ellipsis whitespace-nowrap block group-hover:italic text-right">Posh Name</p>
                            </div>
                        </div>
                    </div>
                    <div class="rounded shadow shadow-slate-500 p-2 flex flex-col bg-transparent">
                        <div class="flex justify-between items-center cursor-pointer h-9" @click="showFriends = !showFriends">
                            <h2 class="text-amber-500 font-semibold" >My Friends</h2>
                            <x-svg.chevron-down x-cloak x-show="!showFriends" stroke="currentColor" class="w-5 h-5" fill="none" />
                            <x-svg.chevron-up x-show="showFriends" stroke="currentColor" class="w-5 h-5" fill="none" />
                        </div>
                        <div x-cloak x-show="showFriends" x-collapse class="text-center">
                            <div class="flex flex-col gap-2 divide-y divide-dashed divide-slate-500 text-left">
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
                            <small class="text-amber-500 mt-4 font-semibold cursor-pointer hover:underline decoration-2 underline-offset-2">View all</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-layouts.auth>

<script>
    const dashboard = (e) => ({
        timeline: [],
        entry: {
            text: '',
            file: null
        },
        init() {
            this.fetchTimeline();
        },
        async fetchTimeline() {
            const response = await fetch(route('list_timeline_entries'))
            const json = await response.json();
            this.timeline = json.data;
        },
        uploadFileInputChanged(el) {
            this.entry.file = el.files[0];
        },
        async postBtnClicked() {
            const form = new FormData;
            form.append('text', this.entry.text);
            form.append('upload', this.entry.file);
            const response = await fetch(route('post.timeline_entry'), {
                method: 'post',
                body: form,
                headers: {
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json',
                }
            })
            const json = await response.json();
            if (response.status != 201) {
                Alpine.store('toast').toggle(json.message, false)
                return;
            }
            this.entry.text = '';
            this.entry.file = null;
            this.fetchTimeline();
            Alpine.store('toast').toggle(json.message)         
        },
        ...e
    })
</script>