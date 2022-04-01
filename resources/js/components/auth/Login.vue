<template>
    <div class="register-container full-height sm-p-t-30">
        <div class="d-flex justify-content-center flex-column full-height ">
            <h3 class="text-center">Welcome User</h3>
            <!-- Error and Info messages -->
            <div class="alert alert-danger mt-3 mb-0" role="alert" v-if="authError">{{ authError }}</div>
            <div class="alert alert-info mt-3 mb-0" role="alert" v-if="authInfo">{{ authInfo }}</div>
            <!-- End Error and Info messages -->
            <form @submit.prevent="authenticate('login-form')" class="p-t-15" data-vv-scope="login-form">
                <div :class="{'form-group form-group-default': true, 'mb-0': errors.has('login-form.email') }">
                    <label>Login <span>*</span></label>
                    <div class="controls">
                        <input v-validate="'required'" class="form-control" type="text" name="usename" v-model="form.usename" placeholder="Email Address">
                    </div>
                </div>
                <span v-show="errors.has('login-form.email')" class="help is-danger">{{ errors.first('login-form.email') }}</span>
                <div :class="{'form-group form-group-default': true, 'mb-0': errors.has('login-form.password') }">
                    <label>Password <span>*</span></label>
                    <div class="controls">
                        <input  v-validate="'required|min:6'" class="form-control" type="password" name="password" v-model="form.password" placeholder="Credentials">
                    </div>
                    </div>
                <span v-show="errors.has('login-form.password')" class="help is-danger">{{ errors.first('login-form.password') }}</span>
                <button class="btn btn-primary btn-block btn-cons m-t-10" :disabled="isLoading" type="submit">Login</button>
            </form>
        </div>
    </div>
</template>

<script>
    import {login} from '@/helpers/auth'
    import { mapGetters } from 'vuex'

    export default {
        name: "login",
        data() {
            return {
                form: {
                    role: null,
                    email: null,
                    password: null
                }
            }
        },
        methods: {
            authenticate(scope) {
                this.$validator.validateAll(scope).then((result) => {
                    if (result) {
                        this.form.role = this.$route.meta.mustRole
                        this.$store.dispatch('auth/loading');
                        login(this.$data.form)
                            .then((res) => {
                            if(res.info) {
                                this.$store.commit("auth/loginInfo", res);
                                this.form.password = null;
                                setTimeout(() => {
                                    this.resetFormError()
                                },5);
                            } else if(res.error) {
                                this.$store.commit("auth/loginError", res);
                                this.form.password = null;
                                setTimeout(() => {
                                    this.resetFormError()
                                },5);
                            } else {
                                this.$store.dispatch("auth/login", res)
                                .then(() => {
                                    if(this.$route.params.nextUrl) {
                                        window.location.href = this.$route.params.nextUrl;
                                    } else {
                                        this.$router.push({name: 'home'})
                                    }
                                })
                            }
                        })
                    }
                });
            },
            resetFormError() {
                this.errors.clear('login-form')
            }
        },
        computed: {
            ...mapGetters('auth', {
                authError: 'authError',
                authInfo: 'authInfo',
                isLoading: 'isLoading'
            })
        },
        mounted() {
            // Clear alerts every proccess
            this.$store.dispatch('auth/clearAlerts');
        }
    }
</script>