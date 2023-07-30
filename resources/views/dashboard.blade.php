<x-layouts.auth>
    <x-slot name="main_wrapper">
        <div class="flex flex-col h-full gap-8" x-data="dashboard({ csrfToken: '{{ csrf_token() }}' })">
            <x-navbarTop></x-navbarTop>
            <div class="flex grow gap-8 w-full sm:w-5/6 mx-auto">
                <x-navbarSide />
                <div class="grow py-4 flex flex-col gap-4">
                    <x-timelineComment />
                    <small class="font-semibold my-3 text-right block">Currently Reading: <span class="text-amber-500" x-text="user.profile.current_read"></span></small>
                    <template x-for="entry in timeline">
                        <div class="bg-slate-700 rounded px-4 relative shadow-sm shadow-slate-500">
                            <div class="p-4 flex flex-col gap-2">
                                <small class="text-slate-400" x-text="entry.created_at_human"></small>
                                <small class="font-semibold" x-text="entry.entry"></small>
                            </div>
                            <template x-if="entry.has_image">
                                <image :src="'/storage/timelines/' + entry.image_path" />
                            </template>
                            <x-svg.love stroke="#f59e0b" class="absolute top-4 right-4 w-6 h-6 ml-auto block cursor-pointer hover:scale-[1.05]" fill="#f59e0b" />
                            <div class="p-4 text-center">
                                <small class="text-center text-amber-500 font-semibold cursor-pointer hover:underline underline-offset-2 decoration-2">View Comments</small>
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
                                <p class="text-inherit overflow-hidden text-ellipsis whitespace-nowrap block group-hover:italic text-right">Vintage Persig</p>
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
        ...e
    })
</script>