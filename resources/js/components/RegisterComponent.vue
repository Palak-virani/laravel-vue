<template>
<div class="grid" style="margin-top: 10%">
    <div class="error" v-if="backend_error">
        <div v-for="ed in backend_error" :key="ed">
            <p v-for="e in ed" :key="e" class="text-white">
                {{ e }}
            </p>
        </div>
    </div>
    <p class="text-white" v-for="err_data in error" :key="err_data">
        {{ err_data }}
    </p>
    <form action="" method="POST" @submit.prevent="register" class="form login">
        <div class="form__field">
            <label for="login__username"><svg class="icon">
                    <use xlink:href="#icon-user"></use>
                </svg><span class="hidden">Username</span></label>
            <input autocomplete="username" id="username" type="text" name="username" class="form__input" placeholder="Username" v-model="form.username" />
        </div>
        <div class="form__field">
            <label for="login__username"><svg class="icon">
                    <use xlink:href="#icon-user"></use>
                </svg><span class="hidden">Email</span></label>
            <input autocomplete="username" id="email" type="text" name="email" class="form__input" placeholder="Email" v-model="form.email" />
        </div>

        <div class="form__field">
            <label for="login__password"><svg class="icon">
                    <use xlink:href="#icon-lock"></use>
                </svg><span class="hidden">Password</span></label>
            <input id="password" type="password" name="password" class="form__input" placeholder="Password" v-model="form.password" />
        </div>
        <div class="form__field">
            <label for="login__password"><svg class="icon">
                    <use xlink:href="#icon-lock"></use>
                </svg><span class="hidden">Confirm Password</span></label>
            <input id="confirm-password" type="password" name="password_confirmation" class="form__input" placeholder="Confirm Password" v-model="form.password_confirmation" />
        </div>

        <div class="form__field">
            <input type="submit" value="Sign Up" @click="validateInput" />
        </div>
    </form>

    <p class="text--center">
        Already a member?
        <router-link :to="{ name: 'login' }">Login</router-link>
        <svg class="icon">
            <use xlink:href="#icon-arrow-right"></use>
        </svg>
    </p>
</div>

<svg xmlns="http://www.w3.org/2000/svg" class="icons">
    <symbol id="icon-arrow-right" viewBox="0 0 1792 1792">
        <path d="M1600 960q0 54-37 91l-651 651q-39 37-91 37-51 0-90-37l-75-75q-38-38-38-91t38-91l293-293H245q-52 0-84.5-37.5T128 1024V896q0-53 32.5-90.5T245 768h704L656 474q-38-36-38-90t38-90l75-75q38-38 90-38 53 0 91 38l651 651q37 35 37 90z" />
    </symbol>
    <symbol id="icon-lock" viewBox="0 0 1792 1792">
        <path d="M640 768h512V576q0-106-75-181t-181-75-181 75-75 181v192zm832 96v576q0 40-28 68t-68 28H416q-40 0-68-28t-28-68V864q0-40 28-68t68-28h32V576q0-184 132-316t316-132 316 132 132 316v192h32q40 0 68 28t28 68z" />
    </symbol>
    <symbol id="icon-user" viewBox="0 0 1792 1792">
        <path d="M1600 1405q0 120-73 189.5t-194 69.5H459q-121 0-194-69.5T192 1405q0-53 3.5-103.5t14-109T236 1084t43-97.5 62-81 85.5-53.5T538 832q9 0 42 21.5t74.5 48 108 48T896 971t133.5-21.5 108-48 74.5-48 42-21.5q61 0 111.5 20t85.5 53.5 62 81 43 97.5 26.5 108.5 14 109 3.5 103.5zm-320-893q0 159-112.5 271.5T896 896 624.5 783.5 512 512t112.5-271.5T896 128t271.5 112.5T1280 512z" />
    </symbol>
</svg>
</template>

<script>
import {
    reactive,
    ref,
} from "vue";
import axios from "axios";
import {
    useRouter
} from 'vue-router';

export default {
    name: "registercomponent",
    setup() {
        const form = reactive({
            username: "",
            email: "",
            password: "",
            password_confirmation: "",
        });
        let error = ref([""]);
        let backend_error = ref([""]);
        const validateInput = () => {};
        const router = useRouter()

        const register = async () => {
            let flag = ref(true);
            let error_status = ref([""]);
            if (
                !form.username ||
                !form.email ||
                !form.password ||
                !form.password_confirmation
            ) {
                error_status.value.push("The input field is required");
                flag.value = false;
            }
            if (form.password !== form.password_confirmation) {
                error_status.value.push(
                    "password and confirm password should be same"
                );
                flag.value = false
            }
            if (form.email) {
                let re =
                    /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                error_status.value.push(
                    !re.test(form.email) ?
                    "The email is not a valid " + form.email + " address" :
                    ""
                );
            }
            if (flag.value) {
                await axios
                    .post("/api/register", form)
                    .then((res) => {
                        if (res.status == 200) {
                            router.push({
                                name: 'login'
                            });
                        }
                    })
                    .catch((bak_error) => {
                        if (bak_error.response.status == 422) {
                            backend_error.value = bak_error.response.data.errors;
                        }
                    });
            }
            error.value = error_status.value;
        };

        return {
            form,
            register,
            error,
            validateInput,
            backend_error,
        };
    },
};
</script>

<style>
</style>
