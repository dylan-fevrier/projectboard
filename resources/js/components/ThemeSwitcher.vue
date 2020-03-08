<template>
    <div class="mr-8">
        <button
            v-for="(color, theme) in themes"
            class="rounded-full w-4 h-4 bg-white border border-accent-light mr-2 focus:outline-none"
            :class="{ 'border-accent' : selectedTheme == theme }"
            :style="{ backgroundColor: color }"
            @click="selectedTheme = theme"></button>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                themes: {
                    'theme-dark': '#222',
                    'theme-light': '#f5f6f9'
                },
                selectedTheme: ''
            };
        },
        watch: {
            selectedTheme () {
                document.body.className = document.body.className.replace(/theme-\w+/, this.selectedTheme);
                localStorage.setItem('theme', this.selectedTheme);
            }
        },
        created() {
            this.selectedTheme = localStorage.getItem('theme') || 'theme-dark';
        }
    }
</script>
