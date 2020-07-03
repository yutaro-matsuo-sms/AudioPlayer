<template>
  <v-app>
    <v-content>
      <v-container class="fill-height" fluid>
        <v-row align="center" justify="center">
          <v-col cols="12" sm="8" md="4">
            <v-card class="elevation-12">
              <v-toolbar color="primary" dark flat>
                <v-toolbar-title>ログイン</v-toolbar-title>
                <v-spacer />
              </v-toolbar>
              <v-card-text>
                <v-form>
                  <v-text-field
                    name="email"
                    label="Email"
                    prepend-icon="mdi-email"
                    type="text"
                    v-model="email"
                  />

                  <v-text-field
                    id="password"
                    label="Password"
                    name="password"
                    prepend-icon="mdi-lock"
                    type="password"
                    v-model="password"
                  />
                </v-form>
              </v-card-text>
              <v-card-text color="red" v-if="error">{{this.error_message}}</v-card-text>
              <v-card-actions>
                <v-spacer />
                <a class="text-md-right" href="/register" color="primary">アカウント登録はこちら</a>
                <v-btn @click="postLogin" color="primary">
                  <v-icon>mdi-login</v-icon>ログイン
                </v-btn>
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
      email: "",
      password: "",
      error: false,
      error_message: "ログインに失敗しました。"
    };
  },
  methods: {
    postLogin() {
      axios
        .post(window.location.origin + `/login`, {
          email: this.email,
          password: this.password
        })
        .then(response => {
          window.location.href = window.location.origin + `/player`;
          !this.error;
        })
        .catch(error => {
          console.log(error);
          this.error = true;
        });
    }
  }
};
</script>