<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';
import SecondaryButton from '@/Components/SecondaryButton.vue'

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});

const searches = ref([
    'Matrix',
    'Matrix Reloaded',
    'Matrix Revolutions'
]);

const results = ref([]);

const search = async (term) => {
    // await axios.get('/sanctum/csrf-cookie');
    await window.axios.post('/api/search',
        {
                s: term
        }).then(({ data }) => {
            if (data?.errors) {
                results.value = []
            } else {
                results.value = data;
            }
    })
}

</script>

<template>
    <Head title="Fabric Movies" />

    <div
        class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0"
    >
        <div v-if="canLogin" class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            <Link
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                class="text-sm text-gray-700 dark:text-gray-500 underline"
                >Dashboard</Link
            >

            <template v-else>
                <Link :href="route('login')" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</Link>

                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline"
                    >Register</Link
                >
            </template>
        </div>

        <div class="max-w-6xl mx-auto my-5 sm:px-6 lg:px-8 text-white border border-yellow-700 py-4 rounded-md" style="max-height: 80vh; min-width: 50vw;">
            <div class="grid grid-cols-3 gap-4">
                <secondary-button v-for="(searchText, index) in searches" :key="`btn_${index}`" @click="search(searchText)">Button {{ index + 1 }}</secondary-button>
            </div>
            <div style="max-height: 70vh;" class="overflow-y-scroll">
                <div v-if="results.length" class="mt-5 grid grid-cols-1 gap-4">
                    <div v-for="movie in results" :key="movie.id" class="flex justify-start">
                        <div class="flex flex-wrap justify-start">
                            <img v-if="movie.poster !== 'N/A'" class="p-1 bg-white border rounded max-w-sm" style="max-width: 70px; max-height: 100px;" :src="movie.poster" :alt="movie.title" />
                            <div v-else class="p-1 bg-gray-800 border rounded max-w-sm" style="width: 70px; height: 100px;"></div>
                        </div>
                        <div class="row-cols-1 pl-2">
                            <h3 class="font-extrabold text-yellow-500">{{ movie.title }}</h3>
                            <div class="text-md">Year: <span class="font-bold">{{ movie.year }}</span></div>
                            <div class="text-md">Type: {{ movie.type }}</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>
