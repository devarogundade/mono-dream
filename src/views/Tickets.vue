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
              <a href="#/receipts">Receipts</a>
            </li>
            <li>
              <a href="#/nfts">NFTs</a>
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

      <div class="item">
        <h3>Tickets</h3>

        <div class="products">
          <div class="product" v-for="ticket in tickets" :key="ticket.id">
            <div class="image">
              <img :src="ticket.images[0] ? ticket.images[0].url : ''" alt="" />
            </div>

            <div class="content">
              <div class="text">
                <p>{{ ticket.title }}</p>
                <h3>{{ ticket.organizer }}</h3>
              </div>

              <div class="view">
                <div class="btn" v-on:click="viewTicket(ticket)">
                  View Event
                </div>
              </div>
            </div>
          </div>
        </div>
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

export default {
  components: { ViewTicket },
  data() {
    return {
      tickets: [],
      loading: false,

      menu: true,

      user: null,
      modal: false,
      ticket: null,
      token: null,
      code: null,
    };
  },

  mounted() {
    this.getTickets();

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

    getTickets() {
      this.loading = true;

      axios.get("http://revoart.tech/api/tickets").then((response) => {
        const data = response.data;

        if (data.status == true) {
          this.tickets = data.data.data;
          console.log(this.tickets);
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

.product .image {
  width: 100%;
}

.product .image img {
  width: 100%;
  height: 300px;
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
  font-size: 20px;
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

  .product .image {
    width: 100%;
  }

  .product .image img {
    width: 100%;
    height: 300px;
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
    font-size: 20px;
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

  .item {
    width: 1000px;
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

  .product .image {
    width: 100%;
  }

  .product .image img {
    width: 100%;
    height: 300px;
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
    font-size: 20px;
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

  .item {
    width: 800px;
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

  .product .image {
    width: 100%;
  }

  .product .image img {
    width: 100%;
    height: 300px;
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
    font-size: 20px;
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

  .item {
    width: 800px;
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
    grid-template-columns: repeat(2, minmax(0, 1fr));
    column-gap: 50px;
    row-gap: 50px;
    margin-bottom: 100px;
  }

  .products .product {
    width: 100%;
    display: flex;
    flex-direction: column;
  }

  .product .image {
    width: 100%;
  }

  .product .image img {
    width: 100%;
    height: 300px;
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
    font-size: 20px;
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

  .item {
    width: 600px;
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
    grid-template-columns: repeat(2, minmax(0, 1fr));
    column-gap: 50px;
    row-gap: 50px;
    margin-bottom: 100px;
  }

  .products .product {
    width: 100%;
    display: flex;
    flex-direction: column;
  }

  .product .image {
    width: 100%;
  }

  .product .image img {
    width: 100%;
    height: 300px;
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
    font-size: 15px;
  }
  .product h3 {
    font-size: 14px;
  }

  .view .btn {
    border: 2px #d0310e solid;
    padding: 10px 0;
    border-radius: 4px;
    color: #d0310e;
    cursor: pointer;
    font-size: 13px;
    user-select: none;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: 300ms;
    width: 80px;
  }

  .view .btn:hover {
    color: white;
    background: #d0310e;
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

  .item {
    width: 500px;
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
    grid-template-columns: repeat(2, minmax(0, 1fr));
    column-gap: 50px;
    row-gap: 50px;
    margin-bottom: 100px;
  }

  .products .product {
    width: 100%;
    display: flex;
    flex-direction: column;
  }

  .product .image {
    width: 100%;
  }

  .product .image img {
    width: 100%;
    height: 300px;
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
    font-size: 15px;
  }
  .product h3 {
    font-size: 14px;
  }

  .view .btn {
    border: 2px #d0310e solid;
    padding: 10px 0;
    border-radius: 4px;
    color: #d0310e;
    cursor: pointer;
    font-size: 13px;
    user-select: none;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: 300ms;
    width: 80px;
  }

  .view .btn:hover {
    color: white;
    background: #d0310e;
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

  .item {
    width: 450px;
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
    grid-template-columns: repeat(2, minmax(0, 1fr));
    column-gap: 50px;
    row-gap: 40px;
    margin-bottom: 50px;
  }

  .products .product {
    width: 100%;
    display: flex;
    flex-direction: column;
  }

  .product .image {
    width: 100%;
  }

  .product .image img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 4px;
  }

  .product .content {
    display: flex;
    justify-content: space-between;
    flex-direction: column;
    align-items: center;
    column-gap: 10px;
    margin-top: 20px;
  }

  .product p {
    font-size: 15px;
  }
  .product h3 {
    font-size: 14px;
  }

  .view .btn {
    border: 2px #d0310e solid;
    padding: 10px 0;
    border-radius: 4px;
    color: #d0310e;
    margin-top: -30px;
    cursor: pointer;
    font-size: 13px;
    user-select: none;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: 300ms;
    width: 80px;
  }

  .view .btn:hover {
    color: white;
    background: #d0310e;
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

  .products {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    column-gap: 50px;
    row-gap: 40px;
    margin-bottom: 50px;
  }

  .products .product {
    width: 100%;
    display: flex;
    flex-direction: column;
  }

  .product .image {
    width: 100%;
  }

  .product .image img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 4px;
  }

  .product .content {
    display: flex;
    justify-content: space-between;
    flex-direction: column;
    align-items: center;
    column-gap: 10px;
    margin-top: 20px;
  }

  .product p {
    font-size: 15px;
  }
  .product h3 {
    font-size: 14px;
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

  .item {
    width: 300px;
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
    column-gap: 50px;
    row-gap: 40px;
    margin-bottom: 50px;
  }

  .products .product {
    width: 100%;
    display: flex;
    flex-direction: column;
  }

  .product .image {
    width: 100%;
  }

  .product .image img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 4px;
  }

  .product .content {
    display: flex;
    justify-content: space-between;
    flex-direction: column;
    align-items: center;
    column-gap: 10px;
    margin-top: 20px;
  }

  .product p {
    font-size: 15px;
  }
  .product h3 {
    font-size: 14px;
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

  .item {
    width: 250px;
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
    column-gap: 50px;
    row-gap: 40px;
    margin-bottom: 50px;
  }

  .products .product {
    width: 100%;
    display: flex;
    flex-direction: column;
  }

  .product .image {
    width: 100%;
  }

  .product .image img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 4px;
  }

  .product .content {
    display: flex;
    justify-content: space-between;
    flex-direction: column;
    align-items: center;
    column-gap: 10px;
    margin-top: 20px;
  }

  .product p {
    font-size: 15px;
  }
  .product h3 {
    font-size: 14px;
  }

  .mobile {
    display: inline;
  }
}
</style>
