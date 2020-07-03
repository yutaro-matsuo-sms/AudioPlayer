<template>
  <v-app>
    <v-content>
      <v-container class="fill-height" fluid>
        <v-row align="center" justify="center">
          <v-col cols="12" sm="8" md="4">
            <v-card class="elevation-12">
              <v-toolbar color="primary" dark flat>
                <v-toolbar-title>アカウント登録</v-toolbar-title>
                <v-spacer />
              </v-toolbar>
              <v-card-text>
                <v-form>
                  <v-text-field
                    label="name"
                    name="name"
                    prepend-icon="mdi-account-circle"
                    type="text"
                    autocomplete="off"
                    v-model="name"
                  />

                  <v-text-field
                    label="Email"
                    name="email"
                    prepend-icon="mdi-email"
                    type="text"
                    autocomplete="off"
                    v-model="email"
                  />
                  <v-text-field
                    id="password"
                    label="Password"
                    name="password"
                    prepend-icon="mdi-lock"
                    type="password"
                    autocomplete="off"
                    v-model="password"
                  />

                  <v-text-field
                    id="password"
                    label="Confirm Password"
                    name="confirm password"
                    prepend-icon="mdi-lock-check"
                    type="password"
                    autocomplete="off"
                    v-model="pw_confirm"
                  />
                  <v-card-text v-if="isError">{{ this.error_message }}</v-card-text>
                </v-form>
              </v-card-text>
              <v-card-actions>
                <v-spacer />
                <v-btn @click="postLogin" color="primary">登録</v-btn>
              </v-card-actions>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
export default {
  data() {
    return {
      name: "",
      email: "",
      password: "",
      pw_confirm: "",
      error_message: "",
      isError: false
    };
  },
  methods: {
    postErrorMessage() {
      if (this.password.length < 8) {
        return (this.error_message =
          "パスワードは8文字以上で登録してください。");
      }
    },
    toggleIsError() {
      this.postErrorMessage();
      return (this.isError = !this.isError);
    },
    postLogin() {
      axios
        .post(window.location.origin + `/register`, {
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.pw_confirm
        })
        .then(response => {
          window.location.href = window.location.origin + `/login`;
        })
        .catch(error => {
          this.toggleIsError();
          console.log(error);
        });
    }
  },
  computed: {}
};
</script>