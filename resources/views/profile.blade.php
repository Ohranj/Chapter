<x-layouts.auth>
    <x-slot name="main_wrapper">
        <div class="flex flex-col h-full gap-8">
            <x-navbarTop></x-navbarTop>
            <div class="flex grow sm:w-5/6 mx-auto">
                <x-navbarSide />
                <div class="grow py-4" x-data="profile">
                    <input type="file" class="opacity-0 h-0 w-0 absolute" x-ref="uploadAvatarInput" accept="image/*" @change="editProfile.upload = $el.files[0]" />
                    <h1 class="text-xl text-amber-500 font-semibold">My Profile</h1>
                    <small>Update your public facing profile and your preferences when interacting across the site.</small>
                    <div class="flex flex-col gap-4 mt-12">
                        <div class="flex gap-4 items-center border-b border-slate-500 pb-3 flex-wrap">
                            <div x-cloak x-show="editProfile.show" class="shadow shadow-amber-400 rounded-full w-[105px] h-[105px] flex items-center justify-center text-slate-700 tracking-widest flex-col border border-dashed border-amber-400 cursor-pointer hover:shadow-none" @click="$refs.uploadAvatarInput.click()">
                                <x-svg.image x-show="!editProfile.upload" stroke="white" class="w-6 h-6" fill="none" />
                                <small x-show="!editProfile.upload" class="text-white font-semibold">Upload</small>   
                                <template x-if="editProfile.upload">
                                    <image x-cloak x-show="editProfile.upload" class="w-full h-full rounded-full object-cover" :src="URL.createObjectURL(editProfile.upload)" />  
                                </template>
                            </div>
                            <div x-cloak x-show="!editProfile.show" class="w-[105px] h-[105px]">
                                <small x-show="!user.profile.has_avatar" class="text-4xl font-semibold w-[105px] h-[105px] rounded-full flex flex-col justify-center shadow shadow-amber-400 rounded-full bg-gradient-to-tr text-center from-amber-400 to-red-300 text-slate-700 tracking-wide" x-text="user.initials"></small> 
                                <template x-if="user.profile.has_avatar">
                                    <img class="object-cover rounded-full w-full h-full shadow shadow-amber-400" :src="'/storage/avatars/' + user.profile.avatar" />
                                </template>
                                
                            </div>
                            <div class="flex flex-col" :class="editProfile.show ? 'gap-2' : 'gap-1'">
                                <div x-cloak x-show="editProfile.show" class="flex gap-1">
                                    <input class="pl-1 border-b bg-transparent text-amber-500 w-[105px]" x-model="user.name" placeholder="Forename" />
                                    <input class="pl-1 border-b bg-transparent text-amber-500 w-[145px]" x-model="user.surname" placeholder="Surname" />
                                </div>
                                <p x-show="!editProfile.show" class="text-amber-500" x-text="user.name + ' ' + user.surname"></p>
                                <input :class="editProfile.show ? 'border-b pl-1' : ''" class="italic text-xs tracking-wider min-w-[300px] bg-transparent" x-model="user.profile.slogan" placeholder="Slogan" />
                            </div>
                            <div class="ml-auto self-end">
                                <button class="text-slate-800 font-semibold text-xs py-1 rounded w-[105px]" @click="editProfile.show = !editProfile.show; $refs.uploadAvatarInput.value = null; editProfile.upload = null" :class="editProfile.show ? 'bg-amber-300 hover:bg-amber-400' : 'bg-indigo-300 hover:bg-indigo-400'" x-text="editProfile.show ? 'Cancel' : 'Edit'"></button>
                                <button x-cloak x-show="editProfile.show" x-transition.duration.750ms class="ml-auto text-slate-800 font-semibold text-xs py-1 rounded w-[105px] self-end bg-indigo-300 hover:bg-indigo-400" @click="confirmEditProfileBtnClicked">Confirm</button>
                            </div>
                            
                        </div>
                        <div class="border-b border-slate-500 pb-3">
                            <h1 class="text-base text-amber-500">Personal Information</h1>
                            <small>Please be aware that the information you share here is publicly accessible. As such, only share information you are happy with others knowing.</small>
                            <div class="mt-6 flex flex-col gap-4">
                                <div class="flex flex-col gap-3">
                                    <div class="flex flex-col items-start">
                                        <label class="font-semibold text-xs">What is the title of the book you are currently reading?</label>
                                        <input class="rounded px-1 text-slate-800 font-semibold bg-slate-300 focus-visible:outline-none" x-model="user.profile.current_read" />
                                    </div>
                                    <div class="flex flex-col items-start">
                                        <label class="font-semibold text-xs">Please select the genres that interest you most (max: 5)</label>
                                        <div class="max-h-[125px] overflow-y-scroll bg-slate-300 text-slate-800 w-[225px] rounded scrollbar-hide">
                                            <template x-for="tag in tags.list">
                                                <div class="px-1 font-semibold hover:bg-slate-400 cursor-pointer" @click="tagClicked(tag)">
                                                    <small class="text-inherit" x-text="tag.tag"></small>
                                                </div>
                                            </template>
                                        </div>
                                        <div class="flex gap-1 mt-1">
                                            <template x-for="tag in tags.selected">
                                                <button class="border border-slate-500 px-1 text-xs rounded shadow-sm shadow-slate-500 hover:bg-red-400 font-semibold hover:text-slate-800" @click="tagClicked(tag)" x-text="tag.tag"></button>
                                            </template>
                                        </div>
                                    </div>
                                    <div x-data="{ showDropdown: false }">
                                        <div class="flex flex-col items-start">
                                            <label class="font-semibold text-xs">Where are you located?</label>
                                            <input class="rounded px-1 text-slate-800 font-semibold bg-slate-300 focus-visible:outline" x-model="countries.search" @focus="showDropdown = true; countries.search = null" @click.away="showDropdown = false; countries.search = user.profile.country" @input.debounce.500ms="filteredCountries" />
                                        </div>
                                        <div x-cloak x-show="showDropdown" class="mt-1 max-h-[125px] overflow-y-scroll bg-slate-300 text-slate-800 w-[225px] rounded scrollbar-hide">
                                            <template x-for="country in filteredCountries">
                                                <div class="px-1 font-semibold hover:bg-slate-400 cursor-pointer" @click="countries.search = country.country; user.profile.country = country.country; showDropdown = false">
                                                    <small class="text-inherit" x-text="country.country"></small>
                                                    </div>
                                            </template>
                                        </div>
                                    </div>
                                    <button class="ml-auto bg-indigo-300 text-slate-800 font-semibold text-xs py-1 hover:bg-indigo-400 rounded w-[105px]" @click="confirmPersonalInfoBtnClicked">Confirm</button>
                                </div>
                            </div>
                        </div>
                        <div class="border-b border-slate-500 pb-3">
                            <h1 class="text-base text-amber-500">Privacy & Security</h1>
                            <small>Handle how others can interact with yourself. Additionally, secure your account to keep your information safe.</small>
                            <div class="mt-6 flex flex-col gap-4">
                                <div class="flex flex-col gap-2">
                                    <div class="flex gap-2 items-center">
                                    <label class="cursor-pointer gap-2 flex items-center text-xs font-semibold">
                                        <span class="w-[275px]"> I am happy to receive direct messages</span>
                                            <div class="relative">
                                                <input type="checkbox" :checked="user.privacy.direct_messages" @click="user.privacy.direct_messages = !user.privacy.direct_messages" class="sr-only" @change="privacyToggled">
                                                <div class="block w-[45px] h-[21px] rounded-full" :class="user.privacy.direct_messages ? 'bg-amber-500' : 'bg-indigo-500'"></div>
                                                <div class="absolute left-[4px] top-[3px] w-[14px] h-[14px] rounded-full transition duration-700" :class="user.privacy.direct_messages ? 'translate-x-[22px] bg-slate-700' : 'bg-slate-100'"></div>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="flex gap-2 items-center">
                                        <label class="cursor-pointer gap-2 flex items-center text-xs font-semibold">
                                            <span class="w-[275px]">I am happy to receive replies to my comments</span>
                                            <div class="relative">
                                                <input type="checkbox" :checked="user.privacy.comment_replies" @click="user.privacy.comment_replies = !user.privacy.comment_replies" class="sr-only" @change="privacyToggled">
                                                <div class="block w-[45px] h-[21px] rounded-full" :class="user.privacy.comment_replies ? 'bg-amber-500' : 'bg-indigo-500'"></div>
                                                <div class="absolute left-[4px] top-[3px] w-[14px] h-[14px] rounded-full transition duration-700" :class="user.privacy.comment_replies ? 'translate-x-[22px] bg-slate-700' : 'bg-slate-100'"></div>
                                            </div>
                                        </label>
                                    </div>
                                    <small class="font-semibold hover:underline underline-offset-2 cursor-pointer" @click="password.show = true">Click here to change your password</small>
                                    <small class="font-semibold hover:underline underline-offset-2 cursor-pointer">Click here to download your data</small>
                                </div>
                            </div>
                        </div>
                        <div class="border-b border-slate-500 pb-3">
                            <h1 class="text-base text-amber-500">Account Management</h1>
                            <small class="text-red-500 font-semibold">Please be careful. The changes here cannot be reversed.</small>
                            <div class="mt-6 flex flex-col gap-4">
                                <div class="flex flex-col gap-2">
                                    <div class="flex justify-between items-center">
                                        <small>Reset my Account</small>
                                        <button class="ml-auto bg-amber-300 text-slate-800 font-semibold text-xs py-1 hover:bg-amber-400 rounded w-[105px]">Reset</button>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <small>Delete my Account</small>
                                        <button class="ml-auto bg-red-300 text-slate-800 font-semibold text-xs py-1 hover:bg-red-400 rounded w-[105px]">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <x-modal-wrapper var="password.show" title="Change My Password">
                        <x-slot name="content">
                            <div class="p-6 text-center text-white flex flex-col gap-2 sm:w-2/3 mx-auto">
                                <h2 class="text-lg font-semibold mb-4">Change your Password below</h2>
                                <p>Please enter your current password alongside your new desired password.</p>
                                <div class="flex flex-col">
                                    <label class="font-semibold text-xs text-left">Current Password</label>
                                    <input type="password" placeholder="Enter your current password" class="rounded p-1 text-slate-800 font-semibold" required x-model="password.current" />
                                </div>
                                <div class="flex flex-col">
                                    <label class="font-semibold text-xs text-left">New Password</label>
                                    <input type="password" placeholder="Enter your new password" class="rounded p-1 text-slate-800 font-semibold" required x-model="password.password" />
                                </div>
                                <div class="flex flex-col">
                                    <label class="font-semibold text-xs text-left">Confirm Your New Password</label>
                                    <input type="password" placeholder="Confirm your new password" class="rounded p-1 text-slate-800 font-semibold" required x-model="password.password_confirmation" />
                                </div>
                                <button class="bg-indigo-300 text-slate-800 font-semibold w-[125px] rounded text-xs py-1 mx-auto hover:bg-indigo-400" @click="changePasswordBtnClicked">Change Password</button>   
                                <small class="mt-6">If you are having trouble remembering your current password, please <q class="underline text-amber-500 underline-offset-2 decoration-2 font-semibold cursor-pointer">click here</q> to request a new one</small> 
                            </div>
                        </x-slot>
                    </x-modal-wrapper>
                </div>
            </div>
        </div>
        <script>
            const profile = () => ({
                editProfile: {
                    show: false,
                    upload: null
                },
                password: {
                    show: false,
                    current: '',
                    password: '',
                    password_confirmation: ''
                },
                tags: {
                    list: [],
                    selected: []
                },
                countries:  {
                    list: [],
                    search: ''
                },
                init() {
                    this.countries.search = this.user.profile.country;
                    this.fetchCountries();
                    this.fetchTags();
                    this.$watch('password.show', (state) => {
                        if (state) return;
                        this.password.current = '';
                        this.password.password_confirmation = ''
                        this.password.password = '';
                    })
                },
                async fetchCountries() {
                    const response = await fetch(route('list_countries'));
                    const json = await response.json();
                    this.countries.list = json.data;
                },
                async fetchTags() {
                    this.tags.selected = this.user.tags;
                    const response = await fetch(route('list_tags'));
                    const json = await response.json();
                    for (const tag of json.data) {
                        const selectedIndx = this.tags.selected.findIndex((x) => x.id == tag.id)
                        if (selectedIndx < 0) {
                            this.tags.list.push(tag);
                        }
                    }
                },
                async confirmPersonalInfoBtnClicked() {
                    const response = await fetch(route('post.update_personal_info', { user: this.user }), {
                        method: 'post',
                        body: JSON.stringify({ 
                            ...this.user.profile, 
                            tags: this.tags.selected.map((x) => x.id) 
                        }),
                        headers: {
                            'X-CSRF-TOKEN': this.csrfToken,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        }
                    })
                    const json = await response.json();
                    response.status == 201 
                        ? Alpine.store('toast').toggle(json.message) 
                        : Alpine.store('toast').toggle(json.message, false)
                },
                async privacyToggled() {
                    const response = await fetch(route('post.update_privacy', { user: this.user }), {
                        method: 'post',
                        body: JSON.stringify({ ...this.user.privacy }),
                        headers: {
                            'X-CSRF-TOKEN': this.csrfToken,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        }
                    })
                    const json = await response.json();
                    response.status == 201 
                        ? Alpine.store('toast').toggle(json.message) 
                        : Alpine.store('toast').toggle(json.message, false)
                },
                async confirmEditProfileBtnClicked() {
                    const form = new FormData;
                    form.append('slogan', this.user.profile.slogan);
                    form.append('name', this.user.name);
                    form.append('surname', this.user.surname);
                    if (this.editProfile.upload) {
                        form.append('upload', this.editProfile.upload);
                    }
                    const response = await fetch(route('post.update_personal_info', { user: this.user }), {
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
                        return
                    }
                    this.editProfile.show = false;
                    this.user = json.data.user;
                    Alpine.store('toast').toggle(json.message) 
                },
                async changePasswordBtnClicked() {
                    const response = await fetch(route('post.update_user', { user: this.user }), {
                        method: 'post',
                        body: JSON.stringify({
                            current: this.password.current,
                            password: this.password.password,
                            password_confirmation: this.password.password_confirmation
                        }),
                        headers: {
                            'X-CSRF-TOKEN': this.csrfToken,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        }
                    })
                    const json = await response.json();
                    if (response.status != 201) {
                        Alpine.store('toast').toggle(json.message, false); 
                        return;
                    }
                    this.password.show = false;
                    Alpine.store('toast').toggle(json.message);
                },
                tagClicked(tag) {
                    const selectedIndx = this.tags.selected.findIndex((x) => x.id === tag.id)
                    if (selectedIndx < 0) {
                        if (this.tags.selected.length >= 5) {
                            return;
                        }
                        const indx = this.tags.list.findIndex((x) => x.id === tag.id);
                        this.tags.list.splice(indx, 1);
                        this.tags.selected.push(tag)
                        return;
                    }
                    this.tags.selected.splice(selectedIndx, 1)
                    this.tags.list.push(tag);
                    this.tags.list.sort((a, b) => {
                        if (a.tag < b.tag) return -1;
                        if (a.tag == b.tag) return 0;
                        return 1;
                    });
                },
                filteredCountries() {
                    if (!this.countries.search) return this.countries.list;
                    return this.countries.list.filter((x) => x.country.toLowerCase().includes(this.countries.search.toLowerCase()))
                },
            })
        </script>
    </x-slot>
</x-layouts.auth>