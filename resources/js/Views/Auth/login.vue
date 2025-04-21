<script lang="ts" setup>
import { ref } from 'vue';
import { loginUser } from '../../Lib/Api/auth/login';
import { useUserInfo } from '../../Composables/useUserInfo';

defineOptions({
    name: 'LoginView',
})
const emailInput = ref('');
const passwordInput = ref('');
const { setUserInfo } = useUserInfo()

const attemptUserLogin = async () => {
    try {
        const loginResponse = await loginUser(emailInput.value, passwordInput.value);
        setUserInfo({
            token: loginResponse.token,
            id: loginResponse.user.id,
            name: loginResponse.user.name,
        })

    } catch (error) {
        console.error('Unable to login');
    }
}
</script>

<template>
    <input v-model="emailInput" />
    <input v-model="passwordInput" />
    <button @click="attemptUserLogin">Login</button>
</template>
