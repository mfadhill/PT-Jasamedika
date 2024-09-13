<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
            <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>
            <form @submit.prevent="handleLogin">
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2" for="name"
                        >Name</label
                    >
                    <input
                        type="text"
                        id="name"
                        v-model="name"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    />
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 mb-2" for="password"
                        >Password</label
                    >
                    <input
                        type="password"
                        id="password"
                        v-model="password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    />
                </div>
                <button
                    type="submit"
                    class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    Login
                </button>
                <p v-if="errorMessage" class="mt-4 text-red-500">
                    {{ errorMessage }}
                </p>
            </form>
        </div>
    </div>
</template>

<script>
import { ref } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";

export default {
    setup() {
        const router = useRouter();
        const name = ref("");
        const password = ref("");
        const errorMessage = ref("");

        const handleLogin = async () => {
            if (!name.value.trim() || !password.value.trim()) {
                errorMessage.value = "Both fields are required.";
                return;
            }

            try {
                console.log("Sending data:", {
                    name: name.value,
                    password: password.value,
                });

                const response = await axios.post(
                    "http://127.0.0.1:8000/api/login",
                    {
                        name: name.value,
                        password: password.value,
                    }
                );

                console.log("Response data:", response.data);

                if (response.data.success) {
                    router.push({ name: "Home" });
                } else {
                    errorMessage.value = "Invalid credentials";
                }
            } catch (error) {
                console.error(
                    "Login failed:",
                    error.response ? error.response.data : error.message
                );
                errorMessage.value =
                    error.response?.data?.message ||
                    "Login failed, please try again.";
            }
        };

        return {
            name,
            password,
            handleLogin,
            errorMessage,
        };
    },
};
</script>

<style scoped>
/* Tambahkan CSS khusus untuk komponen ini jika diperlukan */
</style>
