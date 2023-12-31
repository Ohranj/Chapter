<x-layouts.auth>
    <x-slot name="main_wrapper">
        <div class="flex flex-col h-full gap-8">
            <x-navbarTop></x-navbarTop>
            <div class="flex grow gap-8 sm:w-5/6 mx-auto">
                <x-navbarSide />
                <div class="grow py-4" x-data="community({ user: {{ $user->toJson() }} })">
                    <h1 class="text-xl text-amber-500 font-semibold">There's a world out there...</h1>
                    <small>Use this space to explore our ever-growing community. Network with like-minded readers, expand your interests and discover your next chapter.</small>
                    <div class="flex flex-col gap-4 mt-12">
                        <div class="flex gap-6">
                            <div class="grow flex flex-col basis-7/12 gap-3">
                                <template x-for="nabu in nabus.list">
                                    <div class="relative shadow rounded p-2 lg:hover:scale-[1.005] hover:bg-slate-700 cursor-pointer w-3/4" :class="nabus.selected.item?.id === nabu.id ? 'shadow-amber-400' : 'shadow-slate-500'" @click="nabus.selected.message.show = false; nabus.selected.item?.id == nabu.id ? nabus.selected.item = null : nabus.selected.item = nabu">
                                        <div class="flex gap-4 items-center ">
                                            <template x-if="!nabu.profile.has_avatar">
                                                <small class="w-9 h-9 bg-red-500 rounded-full flex items-center justify-center tracking-wide font-semibold shadow shadow-amber-500 bg-gradient-to-tr text-center from-amber-400 to-red-300 text-slate-700" x-text="nabu.initials"></small>
                                            </template>
                                            <template x-if="nabu.profile.has_avatar">
                                                <img class="object-cover rounded-full w-9 h-9 inline shadow-sm shadow-amber-200" :src="'/storage/avatars/' + nabu.profile.avatar" />
                                            </template>                     
                                            <div class="flex flex-col gap-2 grow">
                                                <div class="flex flex-col">
                                                    <p class="font-semibold text-amber-500" x-text="nabu.full_name"></p>
                                                    <small class="italic" x-text="nabu.profile.slogan"></small>
                                                </div>
                                                <div class="flex justify-between items-center">
                                                    <small>
                                                        <x-svg.book stroke="currentColor" class="w-5 h-5 inline" fill="none" />
                                                        <span class="font-semibold" x-text="nabu.profile.current_read"></span>
                                                    </small>
                                                    <small class="font-semibold text-right" x-text="nabu.profile.country"></small>
                                                </div>
                                            </div>
                                            <x-svg.star x-show="!isFollowing(nabu)" stroke="#f59e0b" class="w-6 h-6 absolute top-2 right-2" fill="none" />
                                            <x-svg.star x-cloak x-show="isFollowing(nabu)" stroke="#f59e0b" class="w-6 h-6 absolute top-2 right-2" fill="#f59e0b" />
                                        </div>
                                        <div class="flex gap-1 justify-end text-xs mt-1">
                                            <template x-for="tag in nabu.tags">
                                                <button class="border border-slate-500 rounded px-1" x-text="tag.tag"></button>
                                            </template>
                                        </div>
                                        <div x-cloak x-show="nabus.selected.item?.id == nabu.id" x-collapse.duration.500ms :class="{'opacity-10': !nabus.selected.item}" class="pl-10">
                                            <small class="font-semibold">Member since: <span class="text-amber-500" x-text="nabus.selected.item?.created_at_human"></span></small>
                                            <div class="flex justify-end gap-1">
                                                <button class="text-xs w-[75px] rounded border p-1 font-semibold" :class="isFollowing(nabus.selected.item) ? ' hover:bg-slate-500 border-slate-500' : 'border-indigo-400 hover:border-indigo-500 bg-indigo-400 hover:bg-indigo-500'" @click.stop="followBtnPressed" x-text="isFollowing(nabus.selected.item) ? 'Unfollow' : 'Follow'"></button>
                                                <button class="text-xs w-[75px] rounded border p-1 font-semibold" @click.stop="nabus.selected.message.show = !nabus.selected.message.show" :class="nabus.selected.message.show ? 'hover:bg-slate-500 border-slate-500' : 'border-green-500 bg-green-500 hover:bg-green-600'">Message</button>
                                            </div>   
                                            <div x-cloak x-show="nabus.selected.message.show" x-collapse.duration>
                                                <textarea rows="3" class="mt-2 block font-semibold text-xs bg-slate-700 rounded py-1 px-2 focus-visible:outline-none border resize-none border-slate-500 w-full" :placeholder="'Send a direct message to ' + nabus.selected.item?.name + '...'" maxlength="750" @click.stop x-model="nabus.selected.message.content"></textarea>
                                                <button class="block ml-auto mt-1 font-semibold bg-green-500 w-[75px] rounded text-white text-xs py-1 px-2" @click.stop="sendMessageBtnPressed">Send</button>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-layouts.auth>

{{-- Search by book genre and name and country --}}

<script>
    const community = (e) => ({
        nabus: {
            list: [],
            currentPage: 1,
            lastPage: 1,
            perPage: 10,
            selected: {
                item: null,
                message: {
                    show: false,
                    content: '',
                },
            }
        },
        init() {
            this.fetchNabus()
            this.$watch('nabus.selected.item', () => this.nabus.selected.message.content = '')
        },
        async fetchNabus() {
            const response = await fetch(route('list_nabus') + '?' + new URLSearchParams({
                perPage: this.nabus.perPage,
                page: this.nabus.currentPage
            }));
            if (response.status != 200) {
                Alpine.store('toast').toggle('Error fetching Nabu\'s', false)
                return;
            }
            const json = await response.json();
            const { last_page, data } = json.data
            this.nabus.list = data;
            this.nabus.lastPage = last_page
        },
        async followBtnPressed() {
            const response = await fetch(route('post.follower'), {
                method: 'post',
                body: JSON.stringify({ id: this.nabus.selected.item.id }),
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
            this.user = json.data;
            Alpine.store('toast').toggle(json.message)
        },
        isFollowing(nabu) {
            if (!nabu) return;
            return this.user.following.findIndex((x) => x.id === nabu.id) >= 0
        },
        async sendMessageBtnPressed() {
            const response = await fetch(route('post.comment'), {
                method: 'post',
                body: JSON.stringify({
                    'recipient': this.nabus.selected.item.id,
                    'comment': this.nabus.selected.message.content
                }),
                headers: {
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                }
            });
            const json = await response.json();
            if (response.status != 201) {
                Alpine.store('toast').toggle(json.message, false)
                return;
            }
            this.nabus.selected.message.show = false;
            Alpine.store('toast').toggle(json.message)
        },
        ...e
    })
</script>