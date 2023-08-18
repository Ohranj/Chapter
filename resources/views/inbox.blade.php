<x-layouts.auth>
    <x-slot name="main_wrapper">
        <div class="flex flex-col h-full gap-8">
            <x-navbarTop></x-navbarTop>
            <div class="flex grow gap-8 sm:w-5/6 mx-auto">
                <x-navbarSide />
                <div class="grow py-4" x-data="inbox">
                    <h1 class="text-xl text-amber-500 font-semibold">My Inbox</h1>
                    <small>Use this space to check out your private conversations with members of the community. Additionally, you'll find replies to any public comments you make here.</small>
                    <div class="flex flex-col gap-4 mt-12"> 
                        <small class="font-semibold ml-auto">Total Unread:- <span x-text="countUnread"></span></small>
                        <div class="flex flex-col gap-2">
                            <template x-for="item in items">
                                <x-inbox.chat-log />
                            </template>
                            <div x-cloak x-show="items.length" class="flex items-center">
                                <small>Showing page <span x-text="params.currentPage"></span> of <span x-text="params.lastPage"></span></small>
                                <div x-cloak x-show="params.lastPage > 1" class="ml-auto text-sm text-slate-800 font-semibold">
                                    <button class="bg-indigo-400 rounded w-[75px]">Prev</button>
                                    <button class="bg-indigo-400 rounded w-[75px]">Next</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-layouts.auth>

<script>
    const inbox = () => ({
        items: [],
        countUnread: 0,
        params: {
            paginate: 10,
            currentPage: 1,
            lastPage: 1,
        },
        openMessage: {},
        init() {
            this.fetchInbox();
        },
        async fetchInbox() {
            const response = await fetch(route('list_inbox', { paginate: this.params.paginate }));
            const json = await response.json();
            this.items = json.data;
            this.countUnread = json.countUnread;
            this.params.lastPage = json.meta.last_page;
        },
        async toggleIsReadState() {
            if (!this.openMessage.hasOwnProperty('id') || this.openMessage.is_read) {
                return;
            }
            const response = await fetch(route('toggle_read_state', { id: this.openMessage.id }), {
                method: 'put',
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
            this.fetchInbox();
        }
    })
</script>