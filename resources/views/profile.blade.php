<x-layouts.auth>
    <x-slot name="main_wrapper">
        <div class="flex flex-col h-full gap-2">
            <x-navbarTop></x-navbarTop>
            <div class="flex grow gap-8">
                <x-navbarSide />
                <div class="grow py-4" x-data="profile">
                    <h1 class="text-xl text-amber-500">My Profile</h1>
                    <small>Update your public facing profile and your preferences when interacting across the site.</small>
                    <div class="flex flex-col gap-4 mt-12">
                        <div class="flex gap-4 items-center border-b border-slate-500 pb-3">
                            <img class="border border-white rounded-full w-[105px] h-[105px]" />
                            <div class="flex flex-col gap-1">
                                <p class="text-amber-500" x-text="user.full_name"></p>
                                <small class="italic">Just watching the world go by.</small>
                            </div>
                            <button class="ml-auto bg-indigo-300 text-slate-800 font-semibold text-xs py-1 hover:bg-indigo-400 rounded w-[105px]">Edit</button>
                        </div>
                        <div class="border-b border-slate-500 pb-3">
                            <h1 class="text-base text-amber-500">Personal Information</h1>
                            <small>Please be aware that the information you share here is publicly accessible. As such, only share information you are happy with others knowing.</small>
                            <div class="mt-6 flex flex-col gap-4">
                                <div class="flex flex-col gap-2">
                                    <div class="flex flex-col items-start">
                                        <label class="font-semibold text-xs">Country</label>
                                        <input class="rounded p-1 text-slate-800 font-semibold" x-model="user.country" />
                                    </div>
                                    <div class="flex flex-col items-start">
                                        <label class="font-semibold text-xs">Gender</label>
                                        <input class="rounded p-1 text-slate-800 font-semibold" />
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
                                                <input type="checkbox" :checked="toggles.directMessaging" @click="toggles.directMessaging = !toggles.directMessaging" class="sr-only">
                                                <div class="block w-[45px] h-[21px] rounded-full" :class="toggles.directMessaging ? 'bg-amber-500' : 'bg-indigo-500'"></div>
                                                <div class="absolute left-[4px] top-[3px] w-[14px] h-[14px] rounded-full transition duration-700" :class="toggles.directMessaging ? 'translate-x-[22px] bg-slate-800' : 'bg-slate-100'"></div>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="flex gap-2 items-center">
                                        <label class="cursor-pointer gap-2 flex items-center text-xs font-semibold">
                                            <span class="w-[275px]">I am happy to receive replies to my comments</span>
                                            <div class="relative">
                                                <input type="checkbox" :checked="toggles.replyComments" @click="toggles.replyComments = !toggles.replyComments" class="sr-only">
                                                <div class="block w-[45px] h-[21px] rounded-full" :class="toggles.replyComments ? 'bg-amber-500' : 'bg-indigo-500'"></div>
                                                <div class="absolute left-[4px] top-[3px] w-[14px] h-[14px] rounded-full transition duration-700" :class="toggles.replyComments ? 'translate-x-[22px] bg-slate-800' : 'bg-slate-100'"></div>
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
            toggles: {
                directMessaging: true,
                replyComments: true,
            },
            async confirmPersonalInfoBtnClicked() {
                const response = await fetch(route('post.update_personal_info'), {
                    method: 'post',
                    body: JSON.stringify({ fill: this.user.email }),
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
            }
        })
    </script>
    </x-slot>
    
</x-layouts.auth>