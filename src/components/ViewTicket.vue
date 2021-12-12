<template>
  <div class="container">
    <div class="view">
      <div class="left">
        <img :src="ticket.images[0] ? ticket.images[0].url : ''" alt="" />
      </div>

      <div class="right">
        <h3>{{ ticket.title }}</h3>

        <p>
          {{ ticket.description }}
        </p>

        <p>
          Ticket Price:
          <span>NGN {{ ticket.amount.toFixed(2) / 100 }}</span>
        </p>

        <div class="btn out" v-if="token && !code">
          Connect with mono first!
        </div>
        <div
          class="btn"
          v-if="code && token && ticket.supply > 0"
          v-on:click="pay()"
        >
          Purchase Ticket
        </div>
        <div class="btn out" v-if="code && token && ticket.supply <= 0">
          Out of stock!
        </div>
        <div class="btn" v-if="!token" v-on:click="$router.push('login')">
          Sign in first
        </div>

        <div class="close" v-on:click="$emit('close')">X</div>
      </div>
    </div>

    <message
      :message="'Feel free to redeem your NFT voucher'"
      :title="'Congratulations!!!'"
      :a="'Redeem your NFT Voucher'"
      :link="'#/nfts'"
      image=""
      v-if="message"
      v-on:close="message = false"
    />
  </div>
</template>

<script>
import axios from "axios";
import Message from "../components/Message.vue";

export default {
  components: { Message },

  props: ["ticket", "user"],

  data() {
    return {
      token: null,
      message: false,
    };
  },

  methods: {
    sign() {
      axios
        .get(
          "http://revoart.tech/api/users/" +
            this.token +
            "/pay?ticket_id=" +
            this.ticket.id
        )
        .then(() => {
          this.message = true;
        });
    },

    pay() {
      let _this = this;
      // eslint-disable-next-line no-undef
      let handler = PaystackPop.setup({
        key: "live_sk_XdFoqaOacwnEcUCgAvI3",
        email: _this.user.email,
        amount: _this.ticket.amount,
        currency: "NGN",
        callback: function () {
          _this.sign();
        },
        onClose: function () {
          if (confirm("Cancel Transaction?.")) {
            _this.$emit("close");
          }
        },
      });
      handler.openIframe();
    },
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
};
</script>

<style scoped>
.container {
  background: rgba(0, 0, 0, 0.6);
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.view {
  width: 800px;
  height: 450px;
  background: white;
  border-radius: 6px;
  display: flex;
  align-items: center;
  position: relative;
}

.view .left {
  height: 100%;
}

.view .left img {
  width: 300px;
  height: 100%;
  object-fit: cover;
  border-top-left-radius: 6px;
  border-bottom-left-radius: 6px;
}

.right {
  padding: 40px;
  display: flex;
  flex-direction: column;
  row-gap: 10px;
}

span {
  color: #d0310e;
  font-weight: bold;
}

.right h3 {
  color: #d0310e;
  font-size: 24px;
}

.right p {
  font-size: 16px;
}

.view .btn {
  background-color: #d0310e;
  height: 45px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  border-radius: 4px;
  margin-top: 50px;
  user-select: none;
  cursor: pointer;
}

.out {
  background: #c4c4c4 !important;
  cursor: not-allowed;
}

.close {
  position: absolute;
  top: 20px;
  right: 30px;
  z-index: 2;
  padding: 10px;
  font-weight: bold;
  cursor: pointer;
  user-select: none;
}

@media screen and (max-width: 1000px) {
  .container {
    background: rgba(0, 0, 0, 0.6);
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .view {
    width: 500px;
    height: 350px;
    background: white;
    border-radius: 6px;
    display: flex;
    align-items: center;
    position: relative;
  }

  .view .left {
    height: 100%;
  }

  .view .left img {
    width: 150px;
    height: 100%;
    object-fit: cover;
    border-top-left-radius: 6px;
    border-bottom-left-radius: 6px;
  }

  .right {
    padding: 40px;
    display: flex;
    flex-direction: column;
    row-gap: 10px;
  }

  span {
    color: #d0310e;
    font-weight: bold;
  }

  .right h3 {
    color: #d0310e;
    font-size: 20px;
  }

  .right p {
    font-size: 14px;
  }

  .view .btn {
    background-color: #d0310e;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    border-radius: 4px;
    margin-top: 30px;
    user-select: none;
    cursor: pointer;
  }

  .out {
    background: #c4c4c4 !important;
    cursor: not-allowed;
  }

  .close {
    position: absolute;
    top: 20px;
    right: 30px;
    z-index: 2;
    padding: 10px;
    font-weight: bold;
    cursor: pointer;
    user-select: none;
  }
}

@media screen and (max-width: 800px) {
  .container {
    background: rgba(0, 0, 0, 0.6);
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .view {
    width: 350px;
    height: 90%;
    background: white;
    flex-direction: column;
    border-radius: 6px;
    display: flex;
    align-items: center;
    position: relative;
  }

  .view .left {
    height: 100%;
  }

  .view .left img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-top-left-radius: 6px;
    border-top-right-radius: 6px;
    border-bottom-left-radius: 0;
  }

  .right {
    padding: 40px;
    display: flex;
    flex-direction: column;
    row-gap: 10px;
  }

  span {
    color: #d0310e;
    font-weight: bold;
  }

  .right h3 {
    color: #d0310e;
    font-size: 20px;
  }

  .right p {
    font-size: 14px;
  }

  .view .btn {
    background-color: #d0310e;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    border-radius: 4px;
    margin-top: 30px;
    user-select: none;
    cursor: pointer;
  }

  .out {
    background: #c4c4c4 !important;
    cursor: not-allowed;
  }

  .close {
    position: absolute;
    top: 20px;
    right: 30px;
    z-index: 2;
    padding: 10px;
    color: white;
    font-weight: bold;
    cursor: pointer;
    user-select: none;
  }
}

@media screen and (max-width: 550px) {
  .container {
    background: rgba(0, 0, 0, 0.6);
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .view {
    width: 80%;
    height: fit-content;
    background: white;
    flex-direction: column;
    border-radius: 6px;
    display: flex;
    align-items: center;
    position: relative;
  }

  .view .left {
    height: 100%;
  }

  .view .left img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-top-left-radius: 6px;
    border-top-right-radius: 6px;
    border-bottom-left-radius: 0;
  }

  .right {
    padding: 20px;
    display: flex;
    flex-direction: column;
    row-gap: 10px;
  }

  span {
    color: #d0310e;
    font-weight: bold;
  }

  .right h3 {
    color: #d0310e;
    font-size: 20px;
  }

  .right p {
    font-size: 14px;
  }

  .view .btn {
    background-color: #d0310e;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    border-radius: 4px;
    margin-top: 30px;
    user-select: none;
    cursor: pointer;
  }

  .out {
    background: #c4c4c4 !important;
    cursor: not-allowed;
  }

  .close {
    position: absolute;
    top: 20px;
    right: 30px;
    z-index: 2;
    padding: 10px;
    color: white;
    font-weight: bold;
    cursor: pointer;
    user-select: none;
  }
}
</style>
