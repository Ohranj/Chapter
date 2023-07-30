<x-layouts.auth>
    <x-slot name="main_wrapper">
        <div class="flex flex-col h-full gap-8">
            <x-navbarTop></x-navbarTop>
            <div class="flex grow gap-8 sm:w-5/6 mx-auto">
                <x-navbarSide />
                <div class="grow py-4" x-data="community">
                    <h1 class="text-xl text-amber-500 font-semibold">There's a world out there...</h1>
                    <small>Use this space to explore our ever-growing community. Network with like-minded readers, expand your interests and discover your next chapter.</small>
                    <div class="flex flex-col gap-4 mt-12">
                        <div class="flex gap-6">
                            <div class="grow flex flex-col basis-2/3 gap-3">
                                <template x-for="nabu in nabus.list">
                                    <div class="relative shadow rounded p-2 flex gap-4 items-center hover:scale-[1.01] hover:bg-slate-700 cursor-pointer" :class="nabus.selected?.id === nabu.id ? 'shadow-amber-400' : 'shadow-slate-500'" @click="nabus.selected?.id == nabu.id ? nabus.selected = null : nabus.selected = nabu">
                                        <template x-if="!nabu.profile.has_avatar">
                                            <small class="w-9 h-9 bg-red-500 rounded-full flex items-center justify-center tracking-wide font-semibold shadow shadow-amber-500 bg-gradient-to-tr text-center from-amber-400 to-red-300 text-slate-700" x-text="nabu.initials"></small>
                                        </template>
                                        <template x-if="nabu.profile.has_avatar">
                                            <img class="object-cover rounded-full w-9 h-9 inline shadow-sm shadow-amber-200" :src="'/storage/avatars/' + nabu.profile.avatar" />
                                        </template>                     
                                        <div class="flex flex-col justify-around gap-2 grow">
                                            <div class="flex flex-col">
                                                <small class="font-semibold text-amber-500" x-text="nabu.full_name"></small>
                                                <small x-text="nabu.profile.slogan"></small>
                                            </div>
                                            <small>
                                                <x-svg.book stroke="currentColor" class="w-4 h-4 inline" fill="none" />
                                                <span x-text="nabu.profile.current_read"></span>
                                            </small>
                                        </div>
                                        <div class="text-xs self-end">
                                            <template x-for="tag in nabu.tags">
                                                <button class="border border-slate-500 rounded px-1" x-text="tag.tag"></button>
                                            </template>
                                        </div>
                                        <x-svg.star stroke="#f59e0b" class="w-5 h-5 absolute top-2 right-2" fill="#f59e0b" />
                                    </div>
                                </template>
                            </div>
                            <div class="basis-1/3">
                                <div x-cloak x-show="nabus.selected" x-transition class="border border-amber-400 rounded p-4">
                                    <small>Show their profile</small>
                                </div>
                               
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
    const community = () => ({
        nabus: {
            list: [],
            currentPage: 1,
            lastPage: 1,
            perPage: 10,
            selected: null
        },
        init() {
            this.fetchNabus()
        },
        async fetchNabus() {
            const response = await fetch(route('list_nabus') + '?' + new URLSearchParams({
                perPage: this.nabus.perPage,
                page: this.nabus.currentPage
            }));
            if (response.status != 200) {
                Alpine.store('toast').toggle('Error fetching Nabuz\'s', false)
                return;
            }
            const json = await response.json();
            const { last_page, data } = json.data
            this.nabus.list = data;
            this.nabus.lastPage = last_page
            console.log(json.data.data[0]);
        }
    })
</script>