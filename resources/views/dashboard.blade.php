<x-layouts.auth>
    <x-slot name="main_wrapper">
        <div class="flex flex-col h-full gap-8" x-data="dashboard({ csrfToken: '{{ csrf_token() }}' })">
            <x-navbarTop></x-navbarTop>
            <div class="flex grow gap-8 w-full sm:w-5/6 mx-auto">
                <x-navbarSide />
                <div class="grow py-4 flex flex-col gap-4">
                    <div class="flex flex-col gap-2 items-end xl:hidden">
                        <a href="/" class="text-amber-500 font-semibold text-sm">
                            <x-svg.group class="w-6 h-6 inline align-middle border rounded-full p-1 box-content shadow shadow-slate-500" stroke="#ffffff" fill="none" />
                            <span class="inline align-middle">My Friends</span>
                        </a>
                        <a href="/" class="text-amber-500 font-semibold text-sm">
                            <x-svg.inbox-stack class="w-6 h-6 inline align-middle border rounded-full p-1 box-content shadow shadow-slate-500" stroke="#ffffff" fill="none" />
                            <span class="inline align-middle">My Messages</span>
                        </a>
                    </div>
                    <x-timelineComment />
                    <small class="font-semibold my-3 text-right block">Currently Reading: <span class="text-amber-500" x-text="user.profile.current_read"></span></small>
                    <template x-for="entry in timeline">
                        <x-timelineItem />
                    </template>
                </div>
                <div class="hidden xl:flex xl:flex-col xl:gap-8 xl:min-w-[325px] xl:basis-[325px] py-4" x-data="{ showTrending: true, showFriends: true, showInbox: true }">
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
                                <p class="text-inherit overflow-hidden text-ellipsis whitespace-nowrap block group-hover:italic text-right">Vintage Persig</p>
                            </div>
                        </div>
                    </div>
                    <div class="rounded shadow shadow-slate-500 p-2 flex flex-col bg-transparent">
                        <div class="flex justify-between items-center cursor-pointer h-12" @click="showInbox = !showInbox">
                            <h2 class="text-amber-500 font-semibold">My Inbox</h2>
                            <x-svg.chevron-down x-cloak x-show="!showInbox" stroke="currentColor" class="w-5 h-5" fill="none" />
                            <x-svg.chevron-up x-show="showInbox" stroke="currentColor" class="w-5 h-5" fill="none" />
                        </div>
                        <div x-cloak x-show="showInbox" x-collapse class="text-center">
                            <div class="flex flex-col gap-2 divide-y divide-dashed divide-slate-500 text-left">
                                <div class="group cursor-pointer pt-1 overflow-hidden text-ellipsis whitespace-nowrap">
                                    <small class="group-hover:italic block">Sender Name1</small>
                                    <small class="text-slate-400 block group-hover:italic">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nostrum, ducimus?</small>
                                </div>
                                <div class="group cursor-pointer pt-1 overflow-hidden text-ellipsis whitespace-nowrap">
                                    <small class="group-hover:italic block">Sender Name2</small>
                                    <small class="text-slate-400 block group-hover:italic">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nostrum, ducimus?</small>
                                </div>
                            </div>
                            <small class="text-amber-500 mt-4 block font-semibold cursor-pointer hover:underline decoration-2 underline-offset-2">View all</small>
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
                                <template x-if="user.following.length">
                                    <template x-for="friend in user.following">
                                        <div class="group cursor-pointer pt-1">
                                            <small class="overflow-hidden text-ellipsis whitespace-nowrap block group-hover:italic" x-text="friend.full_name"></small>
                                        </div>
                                    </template>
                                </template>
                                <template x-if="!user.following.length">
                                    <small class="text-center">Explore our community to interact, discover and make friends.</small>
                                </template>
                            </div>
                            <small x-cloak x-show="user.following.length" class="text-amber-500 mt-4 block font-semibold cursor-pointer hover:underline decoration-2 underline-offset-2">View all</small>
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
            if (this.entry.file) {
                form.append('upload', this.entry.file);
            }
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
            this.$refs.timelineImageInput.value = ''
            this.fetchTimeline();
            Alpine.store('toast').toggle(json.message)         
        },
        async toggleEntryLike(entry) {
            const response = await fetch(route('put.like', { timeline: entry.id }), {
                method: 'put',
                headers: {
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                }
            })
            const json = await response.json();
            if (response.status != 201) {
                return;
            }
            Alpine.store('toast').toggle(json.message)  
            this.fetchTimeline();
        },
        ...e
    })
</script>