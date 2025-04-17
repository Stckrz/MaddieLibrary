<script lang="ts" setup>
import { ref } from 'vue';
import { loginUser } from '../../Lib/Api/auth/login';
import Cookies from 'js-cookie';

defineOptions({
    name: 'LoginView',
})
const emailInput = ref('');
const passwordInput = ref('');

const attemptUserLogin = async () => {
    try{
        const loginResponse = await loginUser(emailInput.value, passwordInput.value);
        const userLoginInfo = {
          token: loginResponse.token,
          id: loginResponse.user.id,
          name: loginResponse.user.name,
        };
        Cookies.set('userInfo', JSON.stringify(userLoginInfo), { expires: 7, secure: true, sameSite: 'Strict' });

    } catch (error){
        console.error('Unable to login');
    }
}
</script>

<template>
    <input v-model="emailInput"/>
    <input v-model="passwordInput"/>
    <button @click="attemptUserLogin">Login</button>
</template>
