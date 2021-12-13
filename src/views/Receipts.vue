<template>
  <div class="container">
    <div class="tickets">
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
              <a href="#/tickets">Tickets</a>
            </li>
            <li>
              <a href="#/nfts">NFTs</a>
            </li>
            <li>
              <a v-on:click="logout()" v-if="token" class="cursor">Logout</a>
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

      <div class="item">
        <div class="tab">
          <div v-on:click="left = true" :class="left ? 'active' : ''">
            My Tickets
          </div>
          <div v-on:click="left = false" :class="left ? '' : 'active'">
            Transactions
          </div>
        </div>

        <div class="section" v-if="left">
          <div class="head" :class="!active ? 'nhead' : ''">
            <h3>December</h3>
            <img
              src="../assets/arrow.png"
              alt=""
              v-on:click="active = !active"
              :class="active ? 'active' : ''"
            />
          </div>
          <div class="products" v-if="active">
            <div class="product" v-for="ticket in tickets" :key="ticket.id">
              <h3 class="name">{{ ticket.ticket.title }}</h3>
              <div class="others">
                <img
                  :src="
                    ticket.ticket.images[0] ? ticket.ticket.images[0].url : ''
                  "
                  alt=""
                />

                <div class="text1">
                  <p>
                    <span>Date: </span> {{ date(ticket.ticket.created_at) }}
                  </p>
                  <p>
                    <span>Time : </span> {{ time(ticket.ticket.created_at) }}
                  </p>
                </div>

                <div class="border"></div>

                <div class="text2">
                  <p>
                    <span>Amount: </span> ₦
                    {{ ticket.ticket.amount.toFixed(2) / 100 }}
                  </p>
                  <p><span>Narraton : </span>Bought a Ticket</p>
                </div>
              </div>
            </div>

            <div class="empty" v-if="tickets.length <= 0">
              Hi, you have no Tickets <br />
              purchase a ticket and receive a NFT. <br />
              <br />
              <a href="#/tickets">Go to tickets</a>
            </div>
          </div>
        </div>

        <transactions v-else />
      </div>
    </div>

    <view-ticket
      v-if="modal"
      :ticket="ticket"
      v-on:close="modal = false"
      :user="user"
    />
  </div>
</template>

<script>
import axios from "axios";
import ViewTicket from "../components/ViewTicket.vue";
import Transactions from "../components/Transactions.vue";

export default {
  components: { ViewTicket, Transactions },
  data() {
    return {
      tickets: [],
      loading: false,
      active: true,
      left: true,

      menu: true,

      user: null,
      modal: false,
      ticket: null,
      token: null,
      code: null,
      auth: null,
    };
  },

  mounted() {
    this.getTickets();

    this.getUser();

    const options = {
      method: "POST",
      headers: {
        Accept: "application/json",
        "mono-sec-key": "test_sk_o5brlJBSALqrFJXONjP1",
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ code: this.code }),
    };

    fetch("https://api.withmono.com/account/auth", options)
      .then((response) => response.json())
      .then((response) => {
        this.getTrx(response.id);
      })
      .catch((err) => console.error(err));
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
      if (element.startsWith("auth=")) {
        this.auth = element.replace("auth=", "");
      } else {
        this.auth = null;
      }
    });
  },

  methods: {
    getUser() {
      this.loading = true;

      axios
        .get("https://revoart.tech/api/users/" + this.token)
        .then((response) => {
          const data = response.data;

          if (data.status == true) {
            this.user = data.data;
          }

          this.loading = false;
        });
    },

    sc() {
      this.menu = true;
      this.$refs["menu"].classList.remove("menu-open");
    },

    so() {
      this.menu = false;
      this.$refs["menu"].classList.add("menu-open");
    },

    logout() {
      const date = new Date();
      date.setTime(date.getTime() - 7 * 24 * 60 * 60 * 1000);
      const expires = "expires=" + date.toUTCString();
      document.cookie = "rust=" + ";" + expires + ";path=/";
      document.cookie = "code=" + ";" + expires + ";path=/";
      document.cookie = "auth=" + ";" + expires + ";path=/";

      this.$router.push("/");
    },

    getTrx(id) {
      const options = {
        method: "GET",
        headers: {
          Accept: "application/json",
          "mono-sec-key": "test_sk_o5brlJBSALqrFJXONjP1",
        },
      };

      fetch(
        "https://api.withmono.com/accounts/" + id + "/transactions",
        options
      )
        .then((response) => response.json())
        .then((response) => console.log(response))
        .catch((err) => console.error(err));
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

    date(date) {
      return new Date(date).toLocaleDateString("en-US", {
        weekday: "short", // long, short, narrow
        day: "numeric", // numeric, 2-digit
        year: "numeric", // numeric, 2-digit
        month: "long", // numeric, 2-digit, long, short, narrow
      });
    },

    time(date) {
      return new Date(date).toLocaleTimeString();
    },

    getTickets() {
      this.loading = true;

      axios
        .get("https://revoart.tech/api/users/" + this.token + "/tickets")
        .then((response) => {
          const data = response.data;

          console.log(data);

          if (data.status == true) {
            this.tickets = data.data;
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
.empty {
  text-align: center;
  font-size: 20px;
  display: flex;
  margin-top: 20px;
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

.mobile {
  display: none;
}
.container {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow-x: hidden !important;
}
.tickets {
  width: 100%;
  display: flex;
  align-items: center;
  flex-direction: column;
  justify-content: center;
  overflow-x: hidden !important;
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
  grid-template-columns: repeat(1, minmax(0, 1fr));
  margin-bottom: 100px;
}

.product p {
  font-size: 15px;
}

.product span {
  color: #d0310e;
  font-weight: bold;
}

.products .product {
  width: 100%;
  padding: 50px 80px;
}

.product .name {
  font-size: 24px;
  color: #333;
}

.others div {
  display: flex;
  flex-direction: column;
  row-gap: 10px;
}

.others .border {
  background-color: #000;
  height: 150px;
  width: 2px;
}

.product .others {
  display: flex;
  margin-top: -30px;
  column-gap: 40px;
  align-items: center;
  justify-content: space-between;
}

.product img {
  width: 220px;
  height: 200px;
  object-fit: cover;
  border-radius: 4px;
}

.product .content {
  display: flex;
  justify-content: space-between;
  align-items: center;
  column-gap: 10px;
  margin-top: 20px;
}

.product p {
  font-size: 16px;
}
.product h3 {
  font-size: 15px;
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

.section {
  width: 1000px;
  background: #ebebeb;
  border-radius: 4px;
  margin-top: 50px;
  height: fit-content !important;
}

.head {
  display: flex;
  align-items: center;
  height: 60px;
  justify-content: space-between;
  padding: 0 80px;
  border-bottom: 2px #000000 solid;
}

.head h3 {
  color: #000;
  text-align: center;
  display: flex;
  align-items: center;
  margin: 0;
  justify-content: center;
}

.head img {
  width: 40px;
  height: 40px;
  padding: 10px;
  cursor: pointer;
  transition: 300ms;
  transform: rotate(180deg);
}

.tab {
  width: 1000px;
  max-width: 80vw !important;
  height: 50px !important;
  overflow-x: unset !important;
  background: #c4c4c4;
  margin-top: -40px;
  border-radius: 4px;
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  align-items: center;
}

.tab div {
  width: 100%;
  display: flex;
  justify-content: center;
  font-weight: bold;
  font-size: 20px;
  align-items: center;
  border-radius: 4px;
  user-select: none;
  height: 100%;
  cursor: pointer;
}

.tab .active {
  background: #949494;
}

.head .active {
  transform: rotate(0deg);
}

.nhead {
  border: none !important;
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
  .header,
  .section {
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
  .header,
  .section {
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
  .header,
  .section {
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
  .header,
  .section {
    width: 700px;
  }

  .section {
    width: 500px;
  }

  .head h3 {
    font-size: 20px;
  }
  .products,
  .head {
    padding: 20px;
  }
  .products .product {
    padding: 10px;
  }
  .product .others {
    row-gap: 10px;
    flex-direction: column;
    margin-bottom: 30px;
  }
  .others .border {
    width: 100px;
    height: 2px;
  }
  .product .others img {
    width: 100px;
    height: 100px;
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
  .header,
  .section {
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
  .header,
  .section {
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
  .header,
  .section {
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
  .header,
  .section {
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
  .header,
  .section {
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
  .header,
  .section {
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
