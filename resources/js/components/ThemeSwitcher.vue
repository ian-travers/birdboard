<template>
    <div class="flex items-center mr-8">
        <button v-for="(color, theme) in themes"
                class="rounded-full border w-5 h-5 mr-2 focus:outline-none"
                :class="{ 'border-accent': selectedTheme == theme}"
                :style="{ backgroundColor: color }"
                @click="selectedTheme = theme">
        </button>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                themes: {
                    'theme-light': '#f5f6f9',
                    'theme-dark': '#222',
                    'theme-halloween': 'orange'
                },
                selectedTheme: 'theme-light'
            }
        },

        created() {
            this.selectedTheme = localStorage.getItem('theme') || 'theme-light';
        },

        watch: {
            selectedTheme() {
                document.body.className = document.body.className.replace(/theme-\w+/, this.selectedTheme);

                localStorage.setItem('theme', this.selectedTheme);
            }
        }
    }
</script>
