<template>
    <div class="w-50 m-auto">
        <div class="card card-body">
            <form action="">
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="text" name="email" placeholder="Enter your e-mail" class="form-control" v-model="email" :class="[{'is-invalid': errorFor('email')}]">
                    <errors :errors="errorFor('email')"></errors>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="email" placeholder="Enter your password" class="form-control" v-model="password" :class="[{'is-invalid': errorFor('password')}]">
                    <errors :errors="errorFor('password')"></errors>
                </div>
                <button type="submit" class="btn btn-primary btn-lg btn-block" :disabled="loading" @click.prevent="login">Log-in</button>
                <hr>
                <div class="text-nowrap">
                    No account yet?
                    <router-link :to="{name: 'home'}">Register</router-link>
                </div>
                <div class="text-nowrap">
                    Forgoten password?
                    <router-link :to="{name: 'home'}">Reset password</router-link>
                </div>
            </form>

        </div>
    </div>
</template>
<script>
import validation from '../mixins/validation';

export default {
    mixins: [validation],
    data() {
        return {
            email: null,
            password: null,
            loading: false
        }
    },
    methods: {
        async login() {
            this.loading = true;
            this.errors = null;
            try {
                await axios.get('/sanctum/csrf-cookie')
                await axios.post('/login', {
                    email: this.email,
                    password: this.password
                });
                await axios.get('/user');
            } catch (e) {
                console.log(e.response)
                this.errors = e.response.data.errors;
            }
            this.loading = false;
        }
    }
}
</script>
