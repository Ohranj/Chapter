document.addEventListener('alpine:init', () => {
    Alpine.store('toast', {
        show: false,
        isSuccess: true,
        message: '',
        async toggle(message, isSuccess = true) {
            this.message = message;
            this.isSuccess = isSuccess
            this.show = true;
            await new Promise((res) => setTimeout(() => res(), 5000))
            this.show = false;
        }
    })
})