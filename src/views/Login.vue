<template>
  <div class="container">
    <div class="login">
      <div class="left">
        <h3 class="logo">Dream</h3>

        <div class="form">
          <h6>Log In</h6>
          <p>Sign in to continue</p>

          <input type="email" placeholder="Email Address" v-model="email" />
          <input type="password" placeholder="Password" v-model="password" />

          <div class="signin" v-if="!loading" v-on:click="login()">Sign In</div>
          <div class="signin" v-else>Checking...</div>

          <div class="other">
            <a href="#/register">You do not have an account? Create account</a>
          </div>
        </div>
      </div>
      <div class="right">
        <div class="dim"></div>
        <img src="../assets/login.png" alt="" />
        <ul>
          <li>
            <a href="#">Home</a>
          </li>
          <li>
            <a href="#/nft-partners">NFT Partners</a>
          </li>
          <li>
            <a href="#/tickets">Tickets</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      email: "",
      password: "",

      loading: false,
      token: null,
    };
  },

  beforeMount() {
    // extract jwt token
    const cookie = document.cookie.split("; ");
    cookie.forEach((element) => {
      if (element.startsWith("rust=")) {
        this.token = element.replace("rust=", "");
      }
    });
    if (this.token != null) {
      this.$router.push("tickets");
    }
  },
  methods: {
    login() {
      this.loading = true;

      axios
        .post(
          "http://revoart.tech/api/login?email=" +
            this.email +
            "&password=" +
            this.password
        )
        .then((response) => {
          const data = response.data;

          if (data.status) {
            const date = new Date();
            date.setTime(date.getTime() + 7 * 24 * 60 * 60 * 1000);
            const expires = "expires=" + date.toUTCString();
            document.cookie =
              "rust=" + data.data.id + ";" + expires + ";path=/";

            this.$router.push("tickets");
          } else {
            alert(data.message)
          }

          this.loading = false;
        });
    },
  },
};
</script>

<style scoped>
.container {
  overflow: hidden;
  height: 100vh;
}

.login {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
}

.login .logo {
  color: #d0310e;
  font-size: 30px;
}

.login h6 {
  font-size: 20px;
  color: #d0310e;
}

.login p {
  font-size: 15px;
}

input[type="email"] {
  margin-top: 50px;
}

input {
  border: 1px solid #d0310e;
  border-radius: 4px;
  padding: 15px;
  background: transparent;
  font-size: 15px;
  color: #333;
  width: 400px;
}

.signin {
  width: 400px;
  height: 50px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-size: 15px;
  cursor: pointer;
  margin-top: 20px;
  user-select: none;
  background: #d0310e;
  border-radius: 4px;
}

.login .left {
  padding: 50px;
}

.login .right {
  position: relative;
}

.login .form {
  margin-top: 50px;
  display: flex;
  align-items: center;
  flex-direction: column;
  row-gap: 6px;
}

.login .right img {
  width: 100%;
  object-fit: cover;
}

.dim {
  width: 100%;
  height: 100%;
  background-image: linear-gradient(transparent, rgba(0, 0, 0, 0.6));
  z-index: 1;
  position: absolute;
  left: 0;
  top: 0;
}

.other {
  font-size: 15px;
  margin-top: 50px;
}

.other a {
  color: #d0310e;
}

ul {
  height: 100px;
  width: 100%;
  padding: 0 100px;
  z-index: 2;
  display: flex;
  align-items: center;
  justify-content: space-between;
  column-gap: 100px;
  position: absolute;
  left: 0;
  top: 0;
}

ul a {
  color: white;
}

@media screen and (max-width: 1000px) {
  .login .right {
    display: none;
  }

  .login .left {
    width: 100vw;
  }
}

@media screen and (max-width: 1000px) {
  .login .right {
    display: none;
  }

  .login .left {
    width: 100vw;
  }

  input {
    border: 1px solid #d0310e;
    border-radius: 4px;
    padding: 15px;
    background: transparent;
    font-size: 15px;
    color: #333;
    width: 300px;
  }

  .signin {
    width: 300px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 15px;
    cursor: pointer;
    margin-top: 20px;
    user-select: none;
    background: #d0310e;
    border-radius: 4px;
  }
}
</style>
