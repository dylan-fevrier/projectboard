<template>
    <div class="dropdown relative">
        <div
            @click="isOpen = !isOpen"
            class="dropdown-toggle"
            aria-haspopup="true"
            :aria-expanded="isOpen"
        >
            <slot name="trigger"></slot>
        </div>

        <div class="dropdown-menu"
             :class="align === 'left' ? 'pin-l' : 'pin-r'"
             :style="{ width }"
             v-show="isOpen"
        >
            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            width: { default: 'auto'},
            align: { default: 'left' }
        },
        data () {
            return {
                isOpen: false
            }
        },
        watch: {
            isOpen(isOpen) {
                if (isOpen) {
                    document.addEventListener('click', this.closeIfClickOutside);
                }
            }
        },
        methods: {
            closeIfClickOutside(event) {
                if (!event.target.closest('.dropdown')) {
                    this.isOpen = false;
                    document.removeEventListener('click', this.closeIfClickOutside);
                }
            }
        }
    }
</script>
