<div x-cloak x-show="$store.toast.show" x-transition class="w-[275px] p-2 rounded ring-2 mx-auto flex justify-between items-center fixed left-20 bottom-20 z-50 shadow-xl shadow-slate-500" :class="$store.toast.isSuccess ? 'ring-amber-500' : 'ring-red-500'">
    <small class="font-semibold" x-text="$store.toast.message"></small>
    <x-svg.cross-circle class="w-6 h-6 cursor-pointer hover:scale-[1.05]" stroke="currentColor" fill="none" @click="$store.toast.show = false" />
</div>