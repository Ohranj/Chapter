<div class="font-semibold flex gap-8">
    <p class="text-xl tracking-wider font-extrabold" :class="toggle ? 'text-indigo-500' : 'text-teal-500'">Card Pilot</p>
    <small class="ml-auto hover:underline decoration-2 underline-offset-4 cursor-pointer">Search</small>
    <small class="hover:underline decoration-2 underline-offset-4 cursor-pointer">Discover</small>
    <small class="hover:underline decoration-2 underline-offset-4 cursor-pointer" @click="showAccountModal = true">My Account</small>
</div>