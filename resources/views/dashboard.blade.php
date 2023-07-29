<x-layouts.auth>
    <x-slot name="main_wrapper">
        <div class="flex flex-col h-full gap-8" x-data="dashboard({ csrfToken: '{{ csrf_token() }}' })">
            <x-navbarTop></x-navbarTop>
            <div class="flex grow gap-8">
                <x-navbarSide />
                <div class="grow py-4 flex flex-col gap-4">
                    <div class="shadow-sm shadow-slate-500 p-2 rounded flex flex-col gap-2">
                        <div class="flex gap-2 items-center">
                            <img x-cloak x-show="user.profile.has_avatar" class="object-cover rounded-full w-9 h-9 inline shadow-sm shadow-amber-200" :src="'/storage/' + user.profile.avatar" />
                            <x-svg.avatar x-cloak x-show="!user.profile.has_avatar" class="w-9 h-9 rounded-full inline align-middle" stroke="white" />   
                            <textarea rows="1" class="font-semibold w-full text-xs bg-slate-700 rounded-full py-1 px-2 focus-visible:outline-none focus-visible:border resize-none focus-visible:border-slate-500" placeholder="What is on your mind?" maxlength="225" x-model="entry.text"></textarea>
                        </div>
                        <div class="flex justify-between">
                            <x-svg.image class="ml-11 w-6 h-6 cursor-pointer hover:scale-[1.05]" stroke="currentColor" fill="none" />
                            <div>
                                <button class="bg-indigo-300 text-slate-800 w-[105px] rounded text-xs py-1 font-semibold hover:bg-indigo-400" @click="postBtnClicked">Post</button>
                            </div>
                        </div>
                    </div>
                    <small class="font-semibold mt-3 mb-6">Currently Reading: <span class="text-amber-500">The Lord of The Rings</span></small>
                    <template x-for="entry in timeline">
                        <div class="bg-slate-700 rounded p-4">
                            <small x-text="entry.entry"></small>
                            <small x-text="entry.created_at_human"></small>
                        </div>
                    </template>
                </div>
                <div class="hidden xl:flex xl:flex-col xl:gap-4 xl:max-w-[275px] xl:basis-[275px] py-4" x-data="{showTrending: true, showFriends: true}">
                    <div class="rounded shadow shadow-slate-500 p-2 flex flex-col bg-slate-700">
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
                                <p class="text-inherit overflow-hidden text-ellipsis whitespace-nowrap block group-hover:italic">JK Rowling</p>
                            </div>
                            <div class="text-xs group cursor-pointer pt-1">
                                <p class="text-inherit overflow-hidden text-ellipsis whitespace-nowrap block group-hover:italic">
                                    The Lord of the Rings. The Fellowship of the Rings
                                </p>
                                <p class="text-inherit overflow-hidden text-ellipsis whitespace-nowrap block group-hover:italic">JRR Tolkien</p>
                            </div>
                            <div class="text-xs group cursor-pointer pt-1">
                                <p class="text-inherit overflow-hidden text-ellipsis whitespace-nowrap block group-hover:italic">
                                    The Art of Motorcycle Maintenance
                                </p>
                                <p class="text-inherit overflow-hidden text-ellipsis whitespace-nowrap block group-hover:italic">Posh Name</p>
                            </div>
                        </div>
                    </div>
                    <div class="rounded shadow shadow-slate-500 p-2 flex flex-col bg-slate-700">
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
            text: ''
        },
        init() {
            this.fetchTimeline();
        },
        async fetchTimeline() {
            const response = await fetch(route('list_timeline_entries'))
            const json = await response.json();
            this.timeline = json.data;
        },
        async postBtnClicked() {
            const response = await fetch(route('post.timeline_entry'), {
                method: 'post',
                body: JSON.stringify({ ...this.entry }),
                headers: {
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                }
            })
            const json = await response.json();
            if (response.status != 201) {
                Alpine.store('toast').toggle(json.message, false)
                return;
            }
            this.entry.text = '';
            this.fetchTimeline();
            Alpine.store('toast').toggle(json.message) 
                        
        },
        ...e
    })
</script>