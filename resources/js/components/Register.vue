<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
            <h2 class="text-2xl font-bold mb-6 text-center">Register</h2>
            <form @submit.prevent="handleRegister">
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2" for="name"
                        >Name</label
                    >
                    <input
                        type="text"
                        id="name"
                        v-model="form.name"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    />
                    <span v-if="errors.name" class="text-red-500 text-sm">{{
                        errors.name
                    }}</span>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2" for="address"
                        >Address</label
                    >
                    <input
                        type="text"
                        id="address"
                        v-model="form.address"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    />
                    <span v-if="errors.address" class="text-red-500 text-sm">{{
                        errors.address
                    }}</span>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2" for="phone_number"
                        >Phone Number</label
                    >
                    <input
                        type="text"
                        id="phone_number"
                        v-model="form.phone_number"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    />
                    <span
                        v-if="errors.phone_number"
                        class="text-red-500 text-sm"
                        >{{ errors.phone_number }}</span
                    >
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2" for="sim_number"
                        >SIM Number</label
                    >
                    <input
                        type="text"
                        id="sim_number"
                        v-model="form.sim_number"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    />
                    <span
                        v-if="errors.sim_number"
                        class="text-red-500 text-sm"
                        >{{ errors.sim_number }}</span
                    >
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2" for="password"
                        >Password</label
                    >
                    <input
                        type="password"
                        id="password"
                        v-model="form.password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    />
                    <span v-if="errors.password" class="text-red-500 text-sm">{{
                        errors.password
                    }}</span>
                </div>

                <!-- Tampilkan pesan error umum -->
                <div v-if="errors.general" class="text-red-500 text-sm mb-4">
                    {{ errors.general }}
                </div>

                <button
                    type="submit"
                    class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    Register
                </button>
                <div class="mt-4 text-center">
                    <p class="text-gray-700">Already have an account?</p>
                    <router-link
                        to="/login"
                        class="text-blue-500 hover:underline"
                        >Click here to login</router-link
                    >
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { useRouter } from "vue-router";
import axios from "axios";
import { ref } from "vue";

export default {
    setup() {
        const router = useRouter();
        const form = ref({
            name: "",
            password: "",
            address: "",
            phone_number: "",
            sim_number: "",
        });
        const errors = ref({});

        const handleRegister = async () => {
            console.log("Form data:", form.value);
            try {
                const response = await axios.post(
                    "http://127.0.0.1:8000/api/register",
                    form.value
                );
                console.log("Registration successful:", response.data);
                router.push({ name: "Login" });
            } catch (error) {
                console.error("Registration failed:", error.message);
                if (error.response) {
                    r;
                    console.error("Response error data:", error.response.data);
                    errors.value = error.response.data.errors || {
                        general: "An error occurred",
                    };
                } else if (error.request) {
                    console.error("Request error data:", error.request);
                    errors.value = { general: "No response from server" };
                } else {
                    console.error("Error message:", error.message);
                    errors.value = { general: "An error occurred" };
                }
            }
        };

        return {
            form,
            errors,
            handleRegister,
        };
    },
};
</script>

<style scoped>
.error {
    color: red;
    font-size: 12px;
}
</style>
