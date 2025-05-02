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
    <div class="loginWrapper">
        <div class="loginInputBox">
            <label class="inputLabel" for="emailInputBox">E-mail
                <input id="emailInputBox" name="emailInputBox" v-model="emailInput" />
            </label>
            <label class="inputLabel" for="passwordInputBox">Password
                <input id="passwordInputBox" name="passwordInputBox"  class="passwordInput" type="password" v-model="passwordInput" />
            </label>
        </div>
        <button class="loginButton" @click="attemptUserLogin">Login</button>
    </div>
</template>
<style scoped>
    input{
        width: 100%;
    }

    .inputLabel{
        width: 100%;
    }

    .loginWrapper{
        display: flex;
        flex-direction: column;
        width: 30%;
        border: 2px solid gray;
        border-radius: 0.25rem;
        padding: 12px;
    }

    .loginInputBox{
        display: flex;
        flex-direction: column;
        gap: 5px;
        align-items: flex-end;
    }

    .passwordInput {
        background-color: gray;
        color: black;
        border-radius: 0.125em;
        padding: 4px;
    }

    .loginButton{
        align-self: flex-end;
        justify-self: flex-end;
        padding: 6px;
    }

    @media screen and (max-width: 600px){
        .loginWrapper{
            width: 80%;
        }

    }
</style>
