<template>
  <div class="login-box">
    <div class="login-logo">
      <a href="/"
        ><b>{{ $store.state.app.name }}</b></a
      >
    </div>
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Iniciar Session</p>
        <form @submit.prevent="onLogin()">
          <div class="input-group mb-3">
            <input
              v-model="email"
              type="email"
              class="form-control"
              :rules="userValidation"
              placeholder="Correo"
            />
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
            <!-- <span id="exampleInputEmail1-error" class="error invalid-feedback">Please enter a email address</span> -->
          </div>
          <div class="input-group mb-3">
            <input
              v-model="password"
              type="password"
              class="form-control"
              placeholder="Contraseña"
              v-on:keypress="onValidateEnter"
            />
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
            <!--  <span id="exampleInputEmail1-error" class="error invalid-feedback">Please enter a email address</span> -->
          </div>
          <div class="row">
            <div class="col-12">
              <button
                type="submit"
                class="btn btn-primary btn-block"
                @click="onLogin"
              >
                Iniciar Session
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axiosServices from "../services/axiosServices.js"
import { mapGetters } from 'vuex'

export default {
  data() {
    return {
      email: "",
      password: "",
      iUserId: "",
      validate: false,
      bAlert: false,
      bBtnEnable: false,
      userValidation: [(v) => !!v || "El usuario es requerido."],
      passwordValidation: [
        (v) => !!v || "La contraseña es requerida.",
        (v) => v.length >= 5 || "Minimo 5 carácteres",
        (v) =>
          /^[a-zA-Z0-9!#-+/.*@·~%&¬()=?¿¡{}[\]]{5,}$/.test(v) ||
          "La contraseña contiene caracteres invalidos.",
      ],
    };
  },
  beforeMount() {
    $("body").removeClass("sidebar-mini").addClass("login-page");
    $("title").html(`Login | ${this.$store.state.app.name}`);
  },
  computed: {
    ...mapGetters(['onGetLogin', 'onGetToken'])
  },
  methods: {
    onValidateInputs() {
      this.validate = false;
      if (
        this.email !== "" &&
        this.password !== "" &&
        /^[a-zA-Z0-9!#-+/.*@·~%&¬()=?¿¡{}[\]]{5,}$/.test(this.password)
      ) {
        this.validate = true;
      }
      return this.validate;
    },
    onValidateEnter: function (event) {
      if (event.keyCode == 13) {
        this.onLogin();
      }
    },
    onLogin() {
      /* if (this.onValidateInputs()) { */
        let body = {
          email: this.email.trim(),
          password: this.password,
        };

        axiosServices
          .onAxiosPostLogin("auth/login", body)
          .then((response) => {
            if (response.status == "Success") {
              this.onResponseSuccess(response);
            } else {
              if (response.status == "Error") {
                new Swal({
                heightAuto: false,
                icon: 'error',
                html:`${JSON.stringify(response.errors)})}`,
                title: 'Error de validación'})
              }
            } 
          });
    },
    onResponseSuccess(response) {
      this.$store.dispatch(
        "onSetUserId",
        response.data.user.id ? response.data.user.id : ""
      );
      this.$store.dispatch("onSetLogin", true);
      this.$store.dispatch("onSetSessionData", response.data);
      this.$store.dispatch("onSetToken", response.data.access_token);
      this.$router.replace({name : 'Inicio'});
    },
  },
};
</script>