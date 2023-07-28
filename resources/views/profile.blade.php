<x-layouts.auth>
    <x-slot name="main_wrapper">
        <div class="flex flex-col h-full gap-2">
            <x-navbarTop></x-navbarTop>
            <div class="flex grow">
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
                            <div x-cloak x-show="!editProfile.show" class="shadow shadow-amber-400 rounded-full w-[105px] h-[105px] flex items-center justify-center text-slate-700 tracking-widest flex-col bg-gradient-to-tr from-amber-400 to-red-300">
                                <p class="text-4xl font-semibold" x-show="!user.profile.has_avatar" x-text="user.initials"></p>
                                <img x-cloak x-show="user.profile.has_avatar" class="object-cover rounded-full w-full h-full" :src="'/storage/' + user.profile.avatar" />
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
                                <div class="flex flex-col gap-2">
                                    <div class="flex flex-col items-start">
                                        <label class="font-semibold text-xs">Where are you from?</label>
                                        <input class="rounded p-1 text-slate-800 font-semibold" x-model="user.profile.country" />
                                    </div>
                                    <div class="flex flex-col items-start">
                                        <label class="font-semibold text-xs">Gender</label>
                                        <input class="rounded p-1 text-slate-800 font-semibold" x-model="user.profile.gender" />
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
                                    <small class="font-semibold hover:underline underline-offset-2 cursor-pointer">Click here to change your password</small>
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
                </div>
            </div>
        </div>
        <script>
            const profile = () => ({
                editProfile: {
                    show: false,
                    upload: null
                },
                async confirmPersonalInfoBtnClicked() {
                    const response = await fetch(route('post.update_personal_info'), {
                        method: 'post',
                        body: JSON.stringify({ ...this.user.profile }),
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
                    const response = await fetch(route('post.update_privacy'), {
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
                    const response = await fetch(route('post.update_personal_info'), {
                        method: 'post',
                        body: form,
                        headers: {
                            'X-CSRF-TOKEN': this.csrfToken,
                            'Accept': 'application/json',
                        }
                    })
                    const json = await response.json();
                    this.editProfile.show = false;
                    this.user = json.data.user;
                    response.status == 201 
                        ? Alpine.store('toast').toggle(json.message) 
                        : Alpine.store('toast').toggle(json.message, false)
                }
            })
        </script>
    </x-slot>
</x-layouts.auth>