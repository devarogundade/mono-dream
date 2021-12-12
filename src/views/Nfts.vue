<template>
  <div class="container">
    <div class="nfts">
      <div class="header">
        <div class="left">
          <h3 class="logo">Dream</h3>
        </div>

        <div class="right">
          <ul ref="menu">
            <li>
              <a href="">Home</a>
            </li>
            <li>
              <a href="#/receipts">Receipts</a>
            </li>
            <li>
              <a href="#/tickets">Tickets</a>
            </li>
            <li>
              <a v-on:click="logout()" v-if="token">Logout</a>
              <a href="#/login" v-else>Login</a>
            </li>
            <li v-if="token != null && code == null">
              <img src="../assets/mono.png" v-on:click="launchMono" alt="" />
            </li>
          </ul>

          <img
            v-if="token != null && code == null"
            src="../assets/mono.png"
            v-on:click="launchMono"
            class="mobile mono"
            alt=""
          />
        </div>

        <p class="mobile menu" v-on:click="so()" v-if="menu">Menu</p>
        <p class="mobile menu" v-on:click="sc()" v-else>Close</p>
      </div>

      <div class="item" v-if="user">
        <h3>{{ user.username }}'s NFTs</h3>

        <div class="products" v-if="user.wallet.nfts">
          <div class="product" v-for="nft in user.wallet.nfts" :key="nft">
            <video src="../assets/magic-box.mp4" autoplay loop></video>
            <div class="claim" v-on:click="claim(nft)" v-if="claiming != nft">
              Claim
            </div>
            <div class="claim" v-if="claiming == nft">Claiming..</div>
          </div>
        </div>
        <div class="empty" v-else>
          Hi, {{ user.email }} you have no NFTs <br />
          purchase a ticket to receive a NFT. <br />
          <br />
          <a href="#/tickets">Go to tickets</a>
        </div>
      </div>
    </div>
    <message
      v-if="message"
      v-on:close="message = false"
      :message="'You have just redeemed your NFT Voucher Check your email for the voucher code.'"
      :image="'../assets/happy.png'"
      :a="'Go to tickets'"
      :link="'#/tickets'"
      :title="'Yay!!'"
    />
  </div>
</template>

<script>
import axios from "axios";
import Message from "../components/Message.vue";

export default {
  components: { Message },
  data() {
    return {
      nfts: [],
      loading: false,
      claiming: null,

      menu: true,

      user: null,
      modal: false,
      ticket: null,
      token: null,
      code: null,
      message: false,
    };
  },

  mounted() {
    this.getUser();
  },

  beforeMount() {
    // extract jwt token
    const cookie = document.cookie.split("; ");
    cookie.forEach((element) => {
      if (element.startsWith("rust=")) {
        this.token = element.replace("rust=", "");
      }
      if (element.startsWith("code=")) {
        this.code = element.replace("code=", "");
      }
    });
  },

  methods: {
    sc() {
      this.menu = true;
      this.$refs["menu"].classList.remove("menu-open");
    },

    so() {
      this.menu = false;
      this.$refs["menu"].classList.add("menu-open");
    },

    claim(id) {
      this.claiming = id;
      axios
        .get("http://revoart.tech/api/users/" + this.token + "/claim")
        .then((response) => {
          const data = response.data;

          if (data.status == true) {
            this.user = data.data;
          }

          this.claiming = false;
          this.message = true;
        });
    },
    logout() {
      const date = new Date();
      date.setTime(date.getTime() - 7 * 24 * 60 * 60 * 1000);
      const expires = "expires=" + date.toUTCString();
      document.cookie = "rust=" + ";" + expires + ";path=/";
      document.cookie = "code=" + ";" + expires + ";path=/";

      this.$router.push("/");
    },

    launchMono() {
      const options = {
        onSuccess: function (response) {
          const date = new Date();
          date.setTime(date.getTime() + 7 * 24 * 60 * 60 * 1000);
          const expires = "expires=" + date.toUTCString();
          document.cookie = "code=" + response.code + ";" + expires + ";path=/";

          this.code = response.code;
        },

        onClose: function () {},
      };

      this.$launchMono(options);
    },
    getUser() {
      this.loading = true;

      axios
        .get("http://revoart.tech/api/users/" + this.token)
        .then((response) => {
          const data = response.data;

          if (data.status == true) {
            this.user = data.data;
          }

          this.loading = false;
        });
    },

    viewTicket(ticket) {
      this.ticket = ticket;
      this.modal = true;
    },
  },
};
</script>

<style scoped>
.mobile {
    display: none;
}
.container {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}
.nfts {
  width: 100%;
  display: flex;
  align-items: center;
  flex-direction: column;
  justify-content: center;
}
.header {
  height: 100px;
  position: sticky;
  top: 0;
  background: #f4f4f4;
  width: 1400px;
}
.header,
.header ul {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.header ul {
  column-gap: 100px;
}

ul img {
  width: 220px;
  cursor: pointer;
  object-fit: cover;
}

.header .logo {
  font-size: 30px;
  color: #d0310e;
}

.header a {
  color: #333;
  font-size: 20px;
}

.item {
  width: 1400px;
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-top: 50px;
}

.item h3 {
  font-size: 30px;
  color: #d0310e;
  margin-bottom: 50px;
}

.products {
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  column-gap: 80px;
  row-gap: 50px;
  margin-bottom: 100px;
}

.products .product {
  width: 100%;
  display: flex;
  flex-direction: column;
}

.product video {
  width: 100%;
  height: 400px;
  object-fit: cover;
  border-radius: 4px;
}

.empty {
  text-align: center;
  font-size: 20px;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.empty a {
  background: #d0310e;
  color: white;
  padding: 10px;
  font-weight: bold;
  border-radius: 4px;
  width: 250px;
  display: block;
}

.claim {
  border: 2px solid #d0310e;
  color: #d0310e;
  transition: 300ms;
  padding: 10px;
  user-select: none;
  cursor: pointer;
  margin-top: 10px;
  text-align: center;
  font-weight: bold;
  width: 100%;
}

.claim:hover {
  color: white;
  background: #d0310e;
}
@media screen and (max-width: 1500px) {
  .container {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .tickets {
    width: 100%;
    display: flex;
    align-items: center;
    flex-direction: column;
    justify-content: center;
  }
  .header {
    height: 100px;
    position: sticky;
    top: 0;
    background: #f4f4f4;
    width: 1200px;
  }
  .header,
  .header ul {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .header ul {
    column-gap: 100px;
  }

  ul img {
    width: 220px;
    cursor: pointer;
    object-fit: cover;
  }

  .header .logo {
    font-size: 30px;
    color: #d0310e;
  }

  .header a {
    color: #333;
    font-size: 20px;
  }

  .item {
    width: 1200px;
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-top: 50px;
  }

  .item h3 {
    font-size: 30px;
    color: #d0310e;
    margin-bottom: 50px;
  }

  .mobile {
    display: none;
  }
}

@media screen and (max-width: 1300px) {
  .container {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .tickets {
    width: 100%;
    display: flex;
    align-items: center;
    flex-direction: column;
    justify-content: center;
  }
  .header {
    height: 100px;
    position: sticky;
    top: 0;
    background: #f4f4f4;
    width: 1000px;
  }
  .header,
  .header ul {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .header ul {
    column-gap: 50px;
  }

  ul img {
    width: 220px;
    cursor: pointer;
    object-fit: cover;
  }

  .header .logo {
    font-size: 30px;
    color: #d0310e;
  }

  .header a {
    color: #333;
    font-size: 20px;
  }

  .view .btn {
    border: 2px #d0310e solid;
    padding: 10px 0;
    border-radius: 4px;
    color: #d0310e;
    cursor: pointer;
    font-size: 15px;
    user-select: none;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: 300ms;
    width: 120px;
  }

  .view .btn:hover {
    color: white;
    background: #d0310e;
  }
}

@media screen and (max-width: 1100px) {
  .container {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .tickets {
    width: 100%;
    display: flex;
    align-items: center;
    flex-direction: column;
    justify-content: center;
  }
  .header {
    height: 80px;
    position: sticky;
    top: 0;
    background: #f4f4f4;
    width: 800px;
  }
  .header,
  .header ul {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .header ul {
    column-gap: 20px;
  }

  ul img {
    width: 220px;
    cursor: pointer;
    object-fit: cover;
  }

  .header .logo {
    font-size: 30px;
    color: #d0310e;
  }

  .header a {
    color: #333;
    font-size: 20px;
  }

  .products {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    column-gap: 80px;
    row-gap: 50px;
    margin-bottom: 100px;
  }

  .products .product {
    width: 100%;
    display: flex;
    flex-direction: column;
  }

  .product video {
    width: 100%;
    height: 300px;
    object-fit: cover;
    border-radius: 4px;
  }
}
@media screen and (max-width: 900px) {
  .container {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .tickets {
    width: 100%;
    display: flex;
    align-items: center;
    flex-direction: column;
    justify-content: center;
  }
  .header {
    height: 80px;
    position: sticky;
    top: 0;
    background: #f4f4f4;
    width: 700px;
  }
  .header ul {
    position: fixed;
    height: 100%;
    width: 50%;
    top: 0;
    background: #c4c4c4;
    flex-direction: column;
    justify-content: center;
    left: -50%;
    transition: 300ms;
  }

  .menu-open {
    left: 0 !important;
  }

  .header ul {
    row-gap: 20px;
  }

  ul img,
  .mono {
    width: 220px;
    cursor: pointer;
    object-fit: cover;
  }

  .header .logo {
    font-size: 30px;
    color: #d0310e;
  }

  .header a {
    color: #333;
    font-size: 20px;
  }

  .mobile {
    display: inline;
  }
}

@media screen and (max-width: 800px) {
  .container {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .tickets {
    width: 100%;
    display: flex;
    align-items: center;
    flex-direction: column;
    justify-content: center;
  }
  .header {
    height: 80px;
    position: sticky;
    top: 0;
    background: #f4f4f4;
    width: 600px;
  }
  .header ul {
    position: fixed;
    height: 100%;
    width: 50%;
    top: 0;
    background: #c4c4c4;
    flex-direction: column;
    justify-content: center;
    left: -50%;
    transition: 300ms;
  }

  .products {
    display: grid;
    grid-template-columns: repeat(1, minmax(0, 1fr));
    column-gap: 80px;
    row-gap: 50px;
    margin-bottom: 100px;
  }

  .products .product {
    width: 100%;
    display: flex;
    flex-direction: column;
  }

  .product video {
    width: 100%;
    object-fit: cover;
    border-radius: 4px;
  }

  .menu-open {
    left: 0 !important;
  }

  .header ul {
    row-gap: 20px;
  }

  ul img,
  .mono {
    width: 220px;
    cursor: pointer;
    object-fit: cover;
  }

  .header .logo {
    font-size: 30px;
    color: #d0310e;
  }

  .header a {
    color: #333;
    font-size: 20px;
  }
  .mobile {
    display: inline;
  }
}

@media screen and (max-width: 700px) {
  .container {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .tickets {
    width: 100%;
    display: flex;
    align-items: center;
    flex-direction: column;
    justify-content: center;
  }
  .header {
    height: 80px;
    position: sticky;
    top: 0;
    background: #f4f4f4;
    width: 500px;
  }
  .header ul {
    position: fixed;
    height: 100%;
    width: 50%;
    top: 0;
    background: #c4c4c4;
    flex-direction: column;
    justify-content: center;
    left: -50%;
    transition: 300ms;
  }

  .menu-open {
    left: 0 !important;
  }

  .header ul {
    row-gap: 20px;
  }

  ul img,
  .mono {
    width: 220px;
    cursor: pointer;
    object-fit: cover;
  }

  .header .logo {
    font-size: 30px;
    color: #d0310e;
  }

  .header a {
    color: #333;
    font-size: 20px;
  }

  .mobile {
    display: inline;
  }
}

@media screen and (max-width: 600px) {
  .container {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .tickets {
    width: 100%;
    display: flex;
    align-items: center;
    flex-direction: column;
    justify-content: center;
  }
  .header {
    height: 80px;
    position: sticky;
    top: 0;
    background: #f4f4f4;
    width: 450px;
  }
  .header ul {
    position: fixed;
    height: 100%;
    width: 50%;
    top: 0;
    background: #c4c4c4;
    flex-direction: column;
    justify-content: center;
    left: -50%;
    transition: 300ms;
  }

  .menu-open {
    left: 0 !important;
  }

  .header ul {
    row-gap: 20px;
  }

  ul img,
  .mono {
    width: 180px;
    cursor: pointer;
    object-fit: cover;
  }

  .header .logo {
    font-size: 30px;
    color: #d0310e;
  }

  .header a {
    color: #333;
    font-size: 20px;
  }

  .mobile {
    display: inline;
  }
}

@media screen and (max-width: 500px) {
  .container {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .tickets {
    width: 100%;
    display: flex;
    align-items: center;
    flex-direction: column;
    justify-content: center;
  }
  .header {
    height: 80px;
    position: sticky;
    top: 0;
    background: #f4f4f4;
    width: 350px;
  }
  .header ul {
    position: fixed;
    height: 100%;
    width: 50%;
    top: 0;
    background: #c4c4c4;
    flex-direction: column;
    justify-content: center;
    left: -50%;
    transition: 300ms;
  }

  .menu-open {
    left: 0 !important;
  }

  .header ul {
    row-gap: 20px;
  }

  ul img,
  .mono {
    width: 180px;
    cursor: pointer;
    object-fit: cover;
  }

  .header .logo {
    font-size: 30px;
    color: #d0310e;
  }

  .header a {
    color: #333;
    font-size: 20px;
  }

  .item {
    width: 400px;
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-top: 50px;
  }

  .item h3 {
    font-size: 30px;
    color: #d0310e;
    margin-bottom: 50px;
  }

  .mobile {
    display: inline;
  }
}

@media screen and (max-width: 500px) {
  .container {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .tickets {
    width: 100%;
    display: flex;
    align-items: center;
    flex-direction: column;
    justify-content: center;
  }
  .header {
    height: 80px;
    position: sticky;
    top: 0;
    background: #f4f4f4;
    width: 400px;
  }
  .header ul {
    position: fixed;
    height: 100%;
    width: 50%;
    top: 0;
    background: #c4c4c4;
    flex-direction: column;
    justify-content: center;
    left: -50%;
    transition: 300ms;
  }

  .menu-open {
    left: 0 !important;
  }

  .header ul {
    row-gap: 20px;
  }

  ul img,
  .mono {
    width: 150px !important;
    cursor: pointer;
    object-fit: cover;
  }

  .header .logo {
    font-size: 24px !important;
    color: #d0310e;
  }

  .header a {
    color: #333;
    font-size: 20px;
  }

  .mobile {
    display: inline;
  }
}

@media screen and (max-width: 400px) {
  .container {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .tickets {
    width: 100%;
    display: flex;
    align-items: center;
    flex-direction: column;
    justify-content: center;
  }
  .header {
    height: 80px;
    position: sticky;
    top: 0;
    background: #f4f4f4;
    width: 300px;
  }
  .header ul {
    position: fixed;
    height: 100%;
    width: 50%;
    top: 0;
    background: #c4c4c4;
    flex-direction: column;
    justify-content: center;
    left: -50%;
    transition: 300ms;
  }

  .menu-open {
    left: 0 !important;
  }

  .header ul {
    row-gap: 20px;
  }

  ul img,
  .mono {
    width: 180px;
    cursor: pointer;
    object-fit: cover;
  }

  .header .logo {
    font-size: 30px;
    color: #d0310e;
  }

  .header a {
    color: #333;
    font-size: 20px;
  }

  .mobile {
    display: inline;
  }
}
</style>
