<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import axios from "axios";
import { ref } from "vue";
import { ArrowPathIcon } from "@heroicons/vue/24/solid";
components: {
    InputLabel;
}
const images = ref([]);
const form = {
    prompt: "",
    n: 1,
    size: "1024x1024",
};
const isLoading = ref(false);

const getImg = async () => {
    if (images.value.length >= 0) {
        images.value = [];
    }
    isLoading.value = true;
    const {
        data: { data },
    } = await axios.post(route("generate.img"), form);
    images.value = data;
    if (data) {
        isLoading.value = false;
    }
};
</script>
<template>
    <div class="container mx-auto py-8 px-10">
        <p class="text-center text-lg font-bold p-4">
            Example of ChatGPT Image Generation
        </p>
        <div class="w-full max-w-3xl mx-auto">
            <form
                class="bg-lime-200 shadow-md rounded px-8 pt-6 pb-8 mb-4"
                @submit.prevent="getImg"
            >
                <div class="flex items-center border-b border-lime-600 py-2">
                    <input
                        class="appearance-none bg-transparent border-none w-full text-lime-900 mr-3 py-1 px-2 leading-tight focus:outline-none"
                        type="text"
                        placeholder="Enter image Description"
                        aria-label="Image Description"
                        v-model="form.prompt"
                    />
                    <button
                        :class="{ 'w-28': isLoading }"
                        class="inline-flex items-center flex-shrink-0 bg-lime-500 hover:bg-lime-700 border-lime-500 hover:border-lime-700 text-sm border-4 text-white py-1 px-5 rounded"
                        type="submit"
                    >
                        Generate
                        <ArrowPathIcon
                            class="ml-3 animate-spin"
                            v-if="isLoading"
                        />
                    </button>
                </div>
            </form>
            <div
                v-if="isLoading"
                class="h-2 animate-pulse bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded"
            ></div>
        </div>

        <div class="mt-8 w-full max-w-xl mx-auto">
            <div v-for="(image, index) in images" :key="index">
                <img :src="image.url" alt="no image" height="50" />
            </div>
        </div>
    </div>
</template>
<style>
.showLoader {
    margin-left: 20px;
}
</style>
