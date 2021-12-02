<template>
    <div>
        <form method="POST" @submit="checkForm">
            <input type="hidden" name="_token" :value="csrf">
            <input type="hidden" name="role_id" value="2">
            <input type="hidden" name="status" value="PENDING">

            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right">Full Name</label>

                <div class="col-md-6">
                    <input id="full_name" name="full_name" type="text" class="form-control" v-model="createForm.full_name">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right">Nick Name</label>

                <div class="col-md-6">
                    <input id="nick_name" name="nick_name" type="text" class="form-control" v-model="createForm.nick_name">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right">Email</label>

                <div class="col-md-6">
                    <input id="email" name="email" type="email" class="form-control" v-model="createForm.email">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right">Password</label>

                <div class="col-md-6">
                    <input id="password" name="password" type="password" class="form-control" v-model="createForm.password">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right">Password Confirm</label>

                <div class="col-md-6">
                    <input id="password_confirm" name="password_confirm" type="password" class="form-control" v-model="password_confirm">
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <span v-if="errors.length" style="color: #F00000; font-size: small;">
                        <br /><b>Please correct the following error(s):</b>
                        <ul>
                            <li v-for="error in errors">{{ error }}</li>
                        </ul>
                    </span>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),

                authToken: null,

                errors: [],

                password_confirm: null,

                createForm: {
                    full_name: null,
                    nick_name: null,
                    email: null,
                    password: null
                }
            }
        },
        methods: {
            validEmail: function (email) {
                var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            },
            minimumPassword: function (password) {
                return password.length >= 5;
            },
            checkForm: function (e) {
                this.errors = [];

                if (!this.createForm.full_name) {
                    this.errors.push('Full name required.');
                }

                if (!this.createForm.email) {
                    this.errors.push('Email required.');
                } else if (!this.validEmail(this.createForm.email)) {
                    this.errors.push('Valid email required.');
                }

                if (!this.createForm.password) {
                    this.errors.push('Password required.');
                } else if (!this.minimumPassword(this.createForm.password)) {
                    this.errors.push('Password length min 8 digits.');
                } else if (this.createForm.password !== this.password_confirm) {
                    this.errors.push('Password doesn\'t match with confirm.');
                }

                if (!this.errors.length) {
                    return true;
                }

                e.preventDefault();
            }
        }
    }
</script>
