<template>
    <div class="flex items-center mr-8">
        <button class="rounded-full border border-accent w-5 h-5 mr-2" style="background: #f5f6f9" @click="selectedTheme = 'theme-light'"></button>
        <button class="rounded-full border border-accent w-5 h-5 mr-2" style="background: #222" @click="selectedTheme = 'theme-dark'"></button>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                selectedTheme: 'theme-light'
            }
        },

        watch: {
            selectedTheme() {
                document.body.className = document.body.className.replace(/theme-\w+/, this.selectedTheme);
            }
        }
    }
</script>
