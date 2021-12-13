<template>
  <div class="container">

      <div class="item">
        <div class="section">
          <div class="products">
            <div
              class="product"
              v-for="transaction in transactions"
              :key="transaction._id"
            >
              <div class="debit">DEBIT</div>

              <p class="message">{{ transaction.narration }}</p>

              <div class="others">
                <p class="amount">
                  ₦ {{ transaction.amount.toFixed(2) / 100 }}
                </p>
                <p class="date">{{ date(transaction.date) }}</p>
                <p class="time">{{ time(transaction.date) }}</p>
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
      transactions: [],
      loading: false,

      menu: true,

      user: null,
      modal: false,
      ticket: null,
      token: null,
      code: null,
      auth: null,

      next: null,
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
        if (response.message == "You are using an invalid or expired code.") {
          this.launchMono();
          return;
        }

        this.getTrx(response.id);
        this.more();
      })
      .catch(() => {
        console.log("here");
      });
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
        .then((response) => {
          this.transactions = response.data;
          this.next = response.paging.next;
        })
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

    getTickets() {
      this.loading = true;

      axios
        .get("https://revoart.tech/api/users/" + this.token + "/tickets")
        .then((response) => {
          const data = response.data;

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

    more() {
      window.onscroll = () => {
        let bottomOfWindow =
          document.documentElement.scrollTop + window.innerHeight >=
          document.documentElement.offsetHeight - 100;

        if (bottomOfWindow && this.next) {
          const options = {
            method: "GET",
            headers: {
              Accept: "application/json",
              "mono-sec-key": "test_sk_o5brlJBSALqrFJXONjP1",
            },
          };

          fetch(this.next, options)
            .then((response) => response.json())
            .then((response) => {
              this.next = response.paging.next;

              response.data.forEach((element) => {
                this.transactions.push(element);
              });
            })
            .catch((err) => console.error(err));
        }
      };
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
  grid-template-columns: repeat(1, minmax(0, 1fr));
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
  display: flex;
  align-items: center;
  border-bottom: 1px solid #c4c4c4;
  justify-content: space-between;
  column-gap: 40px;
  padding: 20px 40px;
}

.product:last-child {
  border: none;
}

.message {
  width: 60%;
}

.others {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  row-gap: 6px;
  text-align: center;
}

.amount {
  font-weight: bold;
  font-size: 24px !important;
}

.date,
.time {
  font-size: 14px !important;
}

.icon {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  background: #d0310e;
}

.debit {
  font-weight: bold;
  font-size: 14px;
  color: #d0310e;
}

.product p {
  font-size: 15px;
  color: #333;
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

.section {
  width: 800px;
  border: 1px solid #c4c4c4;
  border-radius: 4px;
  margin-bottom: 100px;
}

@media screen and (max-width: 1200px) {
  .section {
    width: 600px !important;
  }

  .product {
    padding: 20px !important;
    column-gap: 20px !important;
  }

  .product .message, .date, .time {
    font-size: 13px !important;
  }

  .amount {
    font-size: 20px;
  }
}

@media screen and (max-width: 700px) {
  .section {
    width: 80vw !important;
  }

  .product {
    padding: 20px !important;
    row-gap: 20px !important;
    flex-direction: column;
    text-align: center;
  }

  .product .message, .date, .time {
    font-size: 13px !important;
    width: fit-content !important;
  }

  .amount {
    font-size: 20px;
  }
}
</style>
