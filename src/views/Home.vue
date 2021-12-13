<template>
  <div class="container">
    <div class="home">
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
              <a href="#/nft-partners">NFT Partners</a>
            </li>
            <li>
              <a href="#/tickets">Tickets</a>
            </li>
          </ul>
        </div>

        <p class="mobile menu" v-on:click="so()" v-if="menu">Menu</p>
        <p class="mobile menu" v-on:click="sc()" v-else>Close</p>
      </div>

      <div class="banner">
        <img src="../assets/banner.svg" alt="" />
        <div class="dim"></div>
        <div class="content">
          <h1>
            Get Access to Live Events <br />
            at Discounted Rates
          </h1>

          <div class="buttons">
            <a href="#/login">Sign in</a>
            <a href="#/register">Sign up</a>
          </div>
        </div>
      </div>

      <div class="partners">
        <img src="../assets/redhat.png" alt="" />
        <img src="../assets/airbnb.png" alt="" />
        <img src="../assets/peloton.svg" alt="" />
        <img src="../assets/terra.svg" alt="" />
        <img src="../assets/eventbrite.svg" alt="" />
      </div>

      <div class="nft">
        <h3>NFT Partners</h3>

        <div class="people">
          <div class="person">
            <div class="image">
              <img src="../assets/person1.png" alt="" />
            </div>

            <div class="bio">
              <h3>Tanika Goggins</h3>
              <p>CEO, Revint NFTs</p>
            </div>
          </div>

          <div class="person">
            <div class="image">
              <img src="../assets/person2.png" alt="" />
            </div>

            <div class="bio">
              <h3>Tanika Goggins</h3>
              <p>CEO, Revint NFTs</p>
            </div>
          </div>

          <div class="person">
            <div class="image">
              <img src="../assets/person3.png" alt="" />
            </div>

            <div class="bio">
              <h3>Tanika Goggins</h3>
              <p>CEO, Revint NFTs</p>
            </div>
          </div>

          <div class="person">
            <div class="image">
              <img src="../assets/person4.png" alt="" />
            </div>

            <div class="bio">
              <h3>Tanika Goggins</h3>
              <p>CEO, Revint NFTs</p>
            </div>
          </div>
        </div>
      </div>

      <div class="tes">
        <h3>Testimonial</h3>

        <div class="say">
          <div class="image">
            <img src="../assets/say1.png" alt="" />
          </div>

          <div class="content">
            <img src="../assets/quote.png" alt="" class="quote" />
            <p>
              It’s been wonderful this past two years having found a company
              like Dream. They made ticket sales to events Foray Theatre host
              seamless, and we see turn ups at these events. <br /><br />
              So grateful to the team!!
            </p>

            <div class="name">
              <h3>Xhaso Udianmeng</h3>
              <h3>CEO, Foray Theatre</h3>
            </div>
          </div>
        </div>

        <div class="say">
          <div class="image">
            <img src="../assets/say2.png" alt="" />
          </div>

          <div class="content">
            <p>
              Dream has truly made me believe that bringing theatre in Africa
              isn’t a tall order, and that there are those willing to
              collaborate in this ecosystem. Great team!
            </p>

            <div class="name">
              <h3>Gary Verhtichuk</h3>
              <h3>CEO, Bays Kulture</h3>
            </div>
          </div>
        </div>
      </div>

      <div class="footer">
        <div class="left">
          <div class="dim"></div>
          <div class="text">
            <h3>Let's get you tickets.</h3>
            <p>Visit us at www.dreams.test</p>
          </div>
        </div>
        <div class="right">
          <div class="social">
            <p>Follow us:</p>
            <div class="images">
              <img src="../assets/facebook.png" alt="" />
              <img src="../assets/twitter.png" alt="" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      menu: true,
    };
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
  overflow-x: hidden;
}
.home {
  width: 100%;
  display: flex;
  align-items: center;
  flex-direction: column;
  justify-content: center;
  overflow-x: hidden;
}
.header {
  height: 100px;
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

.header .logo {
  font-size: 30px;
  color: #d0310e;
}

.header a {
  color: #333;
  font-size: 20px;
}

.banner {
  width: 100%;
  height: 520px;
  position: relative;
  left: 0;
}

.banner img {
  object-fit: cover;
  position: absolute;
  height: 100%;
  width: 100vw;
  left: 0;
  top: 0;
}

.dim {
  width: 100%;
  height: 100%;
  background-image: linear-gradient(transparent, rgba(0, 0, 0, 0.4));
  z-index: 1;
  position: absolute;
  left: 0;
  top: 0;
}

.banner .content {
  z-index: 2;
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
}

.banner h1 {
  z-index: 2;
  color: #fff;
  font-size: 60px;
}

.content .buttons {
  margin-top: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  column-gap: 50px;
}

.buttons a {
  width: 200px;
  height: 60px;
  display: flex;
  align-items: center;
  justify-content: center;
  user-select: none;
  cursor: pointer;
  border: 2px solid #d0310e;
  color: white;
  font-size: 20px;
}

.buttons a:first-child {
  background: #d0310e;
}

.partners {
  width: 100%;
  height: 100px;
  display: flex;
  align-items: center;
  justify-content: center;
  column-gap: 100px;
  background: #c4c4c4;
}

.partners img {
  height: 40px;
  object-fit: cover;
}

.nft {
  width: 1400px;
  display: flex;
  flex-direction: column;
  align-items: center;
  margin: 120px 0;
}

.nft h3 {
  color: #d0310e;
  font-size: 40px;
  font-weight: 600;
}

.people {
  margin-top: 100px;
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  column-gap: 100px;
  grid-row-gap: 100px;
  width: 100%;
}

.person {
  display: flex;
  align-items: center;
  justify-content: center;
  column-gap: 50px;
}

.person .image {
  width: 200px;
  height: 200px;
}

.person h3 {
  font-size: 20px;
  color: black;
}

.person p {
  font-size: 14px;
  color: #d0310e;
  font-weight: bold;
}

.person img {
  object-fit: cover;
  width: 100%;
  height: 100%;
  border-radius: 50%;
}

.tes {
  width: 1400px;
  display: flex;
  flex-direction: column;
  align-items: center;
  margin: 120px;
  margin-top: 50px;
}

.tes h3 {
  color: #d0310e;
  font-size: 40px;
  font-weight: 600;
}

.say {
  display: flex;
  justify-content: center;
  align-items: center;
  column-gap: 100px;
  margin-top: 100px;
  width: 1200px;
}

.tes .say:last-child {
  flex-direction: row-reverse;
}

.tes .say:last-child .content {
  align-items: flex-end;
  text-align: end;
}

.say .image {
  width: 350px;
  height: 450px;
}

.say .image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.say .content {
  display: flex;
  flex-direction: column;
  row-gap: 50px;
  position: relative;
}

.say .content p {
  width: 600px;
}

.say .quote {
  width: 40px;
  height: 40px;
  object-fit: fill;
  position: absolute;
  top: -50px;
}

.say .name h3 {
  font-size: 15px;
}

.footer {
  margin-top: 100px;
  width: 100%;
  background-color: #c4c4c4;
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  height: 400px;
}

.footer .left {
  background-image: url("../assets/footer.png");
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
  position: relative;
}

.footer .text {
  z-index: 2;
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
  color: white;
  text-align: left;
}

.footer .text h3 {
  font-size: 30px;
}

.footer .text p {
  font-size: 16px;
}

.footer .right {
  display: flex;
  align-items: flex-end;
  justify-content: flex-end;
  padding: 50px;
}

.footer .social {
  display: flex;
  align-content: center;
  flex-direction: column;
  row-gap: 20px;
  font-weight: bold;
}

.footer .social .images {
  display: flex;
  align-items: center;
  column-gap: 20px;
}

.footer .social img {
  width: 50px;
  height: 50px;
}

@media screen and (max-width: 1500px) {
  .container {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .home {
    width: 100%;
    display: flex;
    align-items: center;
    flex-direction: column;
    justify-content: center;
  }
  .header {
    height: 100px;
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

  .header .logo {
    font-size: 30px;
    color: #d0310e;
  }

  .header a {
    color: #333;
    font-size: 20px;
  }

  .banner {
    width: 100%;
    height: 520px;
    position: relative;
    left: 0;
  }

  .banner img {
    object-fit: cover;
    position: absolute;
    height: 100%;
    width: 100vw;
    left: 0;
    top: 0;
  }

  .dim {
    width: 100%;
    height: 100%;
    background-image: linear-gradient(transparent, rgba(0, 0, 0, 0.4));
    z-index: 1;
    position: absolute;
    left: 0;
    top: 0;
  }

  .banner .content {
    z-index: 2;
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
  }

  .banner h1 {
    z-index: 2;
    color: #fff;
    font-size: 60px;
  }

  .content .buttons {
    margin-top: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    column-gap: 50px;
  }

  .buttons a {
    width: 200px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    user-select: none;
    cursor: pointer;
    border: 2px solid #d0310e;
    color: white;
    font-size: 20px;
  }

  .buttons a:first-child {
    background: #d0310e;
  }

  .partners {
    width: 100%;
    height: 100px;
    display: flex;
    align-items: center;
    justify-content: center;
    column-gap: 100px;
    background: #c4c4c4;
  }

  .partners img {
    height: 40px;
    object-fit: cover;
  }

  .nft {
    width: 1200px;
    display: flex;
    flex-direction: column;
    align-items: center;
    margin: 120px 0;
  }

  .nft h3 {
    color: #d0310e;
    font-size: 40px;
    font-weight: 600;
  }

  .people {
    margin-top: 100px;
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    column-gap: 100px;
    grid-row-gap: 100px;
    width: 100%;
  }

  .person {
    display: flex;
    align-items: center;
    justify-content: center;
    column-gap: 50px;
  }

  .person .image {
    width: 200px;
    height: 200px;
  }

  .person h3 {
    font-size: 20px;
    color: black;
  }

  .person p {
    font-size: 14px;
    color: #d0310e;
    font-weight: bold;
  }

  .person img {
    object-fit: cover;
    border-radius: 50%;
  }

  .tes {
    width: 1200px;
    display: flex;
    flex-direction: column;
    align-items: center;
    margin: 120px;
    margin-top: 50px;
  }

  .tes h3 {
    color: #d0310e;
    font-size: 40px;
    font-weight: 600;
  }

  .say {
    display: flex;
    justify-content: center;
    align-items: center;
    column-gap: 100px;
    margin-top: 100px;
    width: 1200px;
  }

  .tes .say:last-child {
    flex-direction: row-reverse;
  }

  .tes .say:last-child .content {
    align-items: flex-end;
    text-align: end;
  }

  .say .image {
    width: 350px;
    height: 450px;
  }

  .say .image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .say .content {
    display: flex;
    flex-direction: column;
    row-gap: 50px;
    position: relative;
  }

  .say .content p {
    width: 600px;
  }

  .say .quote {
    width: 40px;
    height: 40px;
    object-fit: fill;
    position: absolute;
    top: -50px;
  }

  .say .name h3 {
    font-size: 15px;
  }

  .footer {
    margin-top: 100px;
    width: 100%;
    background-color: #c4c4c4;
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    height: 400px;
  }

  .footer .left {
    background-image: url("../assets/footer.png");
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    position: relative;
  }

  .footer .text {
    z-index: 2;
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    color: white;
    text-align: left;
  }

  .footer .text h3 {
    font-size: 30px;
  }

  .footer .text p {
    font-size: 16px;
  }

  .footer .right {
    display: flex;
    align-items: flex-end;
    justify-content: flex-end;
    padding: 50px;
  }

  .footer .social {
    display: flex;
    align-content: center;
    flex-direction: column;
    row-gap: 20px;
    font-weight: bold;
  }

  .footer .social .images {
    display: flex;
    align-items: center;
    column-gap: 20px;
  }

  .footer .social img {
    width: 50px;
    height: 50px;
  }

  @media screen and (max-width: 1300px) {
    .container {
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .home {
      width: 100%;
      display: flex;
      align-items: center;
      flex-direction: column;
      justify-content: center;
    }
    .header {
      height: 100px;
      width: 1000px;
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

    .header .logo {
      font-size: 30px;
      color: #d0310e;
    }

    .header a {
      color: #333;
      font-size: 20px;
    }

    .banner {
      width: 100%;
      height: 480px;
      position: relative;
      left: 0;
    }

    .banner img {
      object-fit: cover;
      position: absolute;
      height: 100%;
      width: 100vw;
      left: 0;
      top: 0;
    }

    .dim {
      width: 100%;
      height: 100%;
      background-image: linear-gradient(transparent, rgba(0, 0, 0, 0.4));
      z-index: 1;
      position: absolute;
      left: 0;
      top: 0;
    }

    .banner .content {
      z-index: 2;
      position: absolute;
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%);
      text-align: center;
    }

    .banner h1 {
      z-index: 2;
      color: #fff;
      font-size: 50px;
    }

    .content .buttons {
      margin-top: 30px;
      display: flex;
      align-items: center;
      justify-content: center;
      column-gap: 40px;
    }

    .buttons a {
      width: 180px;
      height: 50px;
      display: flex;
      align-items: center;
      justify-content: center;
      user-select: none;
      cursor: pointer;
      border: 2px solid #d0310e;
      color: white;
      font-size: 18px;
    }

    .buttons a:first-child {
      background: #d0310e;
    }

    .partners {
      width: 100%;
      height: 80px;
      display: flex;
      align-items: center;
      justify-content: center;
      column-gap: 100px;
      background: #c4c4c4;
    }

    .partners img {
      height: 30px;
      object-fit: cover;
    }

    .nft {
      width: 1000px;
      display: flex;
      flex-direction: column;
      align-items: center;
      margin: 120px 0;
    }

    .nft h3 {
      color: #d0310e;
      font-size: 40px;
      font-weight: 600;
    }

    .people {
      margin-top: 80px;
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      column-gap: 80px;
      grid-row-gap: 80px;
      width: 90%;
    }

    .person {
      display: flex;
      align-items: center;
      justify-content: center;
      column-gap: 40px;
    }

    .person .image {
      width: 150px;
      height: 150px;
    }

    .person h3 {
      font-size: 20px;
      color: black;
    }

    .person p {
      font-size: 14px;
      color: #d0310e;
      font-weight: bold;
    }

    .person img {
      object-fit: cover;
      border-radius: 50%;
    }

    .tes {
      width: 1000px;
      display: flex;
      flex-direction: column;
      align-items: center;
      margin: 80px;
      margin-top: 40px;
    }

    .tes h3 {
      color: #d0310e;
      font-size: 40px;
      font-weight: 600;
    }

    .say {
      display: flex;
      justify-content: center;
      align-items: center;
      column-gap: 100px;
      margin-top: 100px;
      width: 1200px;
    }

    .tes .say:last-child {
      flex-direction: row-reverse;
    }

    .tes .say:last-child .content {
      align-items: flex-end;
      text-align: end;
    }

    .say .image {
      width: 300px;
      height: 400px;
    }

    .say .image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .say .content {
      display: flex;
      flex-direction: column;
      row-gap: 50px;
      position: relative;
    }

    .say .content p {
      width: 600px;
    }

    .say .quote {
      width: 40px;
      height: 40px;
      object-fit: fill;
      position: absolute;
      top: -50px;
    }

    .say .name h3 {
      font-size: 15px;
    }

    .footer {
      margin-top: 70px;
      width: 100%;
      background-color: #c4c4c4;
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      height: 300px;
    }

    .footer .left {
      background-image: url("../assets/footer.png");
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      position: relative;
    }

    .footer .text {
      z-index: 2;
      position: absolute;
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%);
      text-align: center;
      color: white;
      text-align: left;
    }

    .footer .text h3 {
      font-size: 30px;
    }

    .footer .text p {
      font-size: 16px;
    }

    .footer .right {
      display: flex;
      align-items: flex-end;
      justify-content: flex-end;
      padding: 50px;
    }

    .footer .social {
      display: flex;
      align-content: center;
      flex-direction: column;
      row-gap: 20px;
      font-weight: bold;
    }

    .footer .social .images {
      display: flex;
      align-items: center;
      column-gap: 20px;
    }

    .footer .social img {
      width: 50px;
      height: 50px;
    }
  }

  @media screen and (max-width: 1100px) {
    .container {
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .home {
      width: 100%;
      display: flex;
      align-items: center;
      flex-direction: column;
      justify-content: center;
    }
    .header {
      height: 80px;
      width: 800px;
    }
    .header,
    .header ul {
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .header ul {
      column-gap: 80px;
    }

    .header .logo {
      font-size: 26px;
      color: #d0310e;
    }

    .header a {
      color: #333;
      font-size: 20px;
    }

    .banner {
      width: 100%;
      height: 450px;
      position: relative;
      left: 0;
    }

    .banner img {
      object-fit: cover;
      position: absolute;
      height: 100%;
      width: 100vw;
      left: 0;
      top: 0;
    }

    .dim {
      width: 100%;
      height: 100%;
      background-image: linear-gradient(transparent, rgba(0, 0, 0, 0.4));
      z-index: 1;
      position: absolute;
      left: 0;
      top: 0;
    }

    .banner .content {
      z-index: 2;
      position: absolute;
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%);
      text-align: center;
    }

    .banner h1 {
      z-index: 2;
      color: #fff;
      font-size: 45px;
    }

    .content .buttons {
      margin-top: 30px;
      display: flex;
      align-items: center;
      justify-content: center;
      column-gap: 40px;
    }

    .buttons a {
      width: 150px;
      height: 50px;
      display: flex;
      align-items: center;
      justify-content: center;
      user-select: none;
      cursor: pointer;
      border: 2px solid #d0310e;
      color: white;
      font-size: 18px;
    }

    .buttons a:first-child {
      background: #d0310e;
    }

    .partners {
      width: 100%;
      height: 60px;
      display: flex;
      align-items: center;
      justify-content: center;
      column-gap: 50px;
      background: #c4c4c4;
    }

    .partners img {
      height: 24px;
      object-fit: cover;
    }

    .nft {
      width: 1000px;
      display: flex;
      flex-direction: column;
      align-items: center;
      margin: 50px 0;
    }

    .nft h3 {
      color: #d0310e;
      font-size: 30px;
      font-weight: 600;
    }

    .people {
      margin-top: 50px;
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      column-gap: 80px;
      grid-row-gap: 80px;
      width: 90%;
    }

    .person {
      display: flex;
      align-items: center;
      justify-content: center;
      column-gap: 20px;
    }

    .person .image {
      width: 100px;
      height: 100px;
    }

    .person h3 {
      font-size: 20px;
      color: black;
    }

    .person p {
      font-size: 14px;
      color: #d0310e;
      font-weight: bold;
    }

    .person img {
      object-fit: cover;
      border-radius: 50%;
    }

    .tes {
      width: 800px;
      display: flex;
      flex-direction: column;
      align-items: center;
      margin: 50px;
      margin-top: 40px;
    }

    .tes h3 {
      color: #d0310e;
      font-size: 40px;
      font-weight: 600;
    }

    .say {
      display: flex;
      justify-content: center;
      align-items: center;
      column-gap: 40px;
      margin-top: 40px;
      width: 1200px;
    }

    .tes .say:last-child {
      flex-direction: row-reverse;
    }

    .tes .say:last-child .content {
      align-items: flex-end;
      text-align: end;
    }

    .say .image {
      width: 200px;
      height: 300px;
    }

    .say .image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .say .content {
      display: flex;
      flex-direction: column;
      row-gap: 50px;
      position: relative;
    }

    .say .content p {
      width: 500px;
    }

    .say .quote {
      width: 40px;
      height: 40px;
      object-fit: fill;
      position: absolute;
      top: -50px;
    }

    .say .name h3 {
      font-size: 15px;
    }

    .footer {
      margin-top: 70px;
      width: 100%;
      background-color: #c4c4c4;
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      height: 300px;
    }

    .footer .left {
      background-image: url("../assets/footer.png");
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      position: relative;
    }

    .footer .text {
      z-index: 2;
      position: absolute;
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%);
      text-align: center;
      color: white;
      text-align: left;
    }

    .footer .text h3 {
      font-size: 30px;
    }

    .footer .text p {
      font-size: 16px;
    }

    .footer .right {
      display: flex;
      align-items: flex-end;
      justify-content: flex-end;
      padding: 50px;
    }

    .footer .social {
      display: flex;
      align-content: center;
      flex-direction: column;
      row-gap: 20px;
      font-weight: bold;
    }

    .footer .social .images {
      display: flex;
      align-items: center;
      column-gap: 20px;
    }

    .footer .social img {
      width: 50px;
      height: 50px;
    }
  }

  @media screen and (max-width: 900px) {
    .mobile {
      display: block;
    }
    .container {
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .home {
      width: 100%;
      display: flex;
      align-items: center;
      flex-direction: column;
      justify-content: center;
    }
    .header {
      height: 80px;
      width: 800px;
    }
    .header ul {
      position: fixed;
      background: #c4c4c4;
      width: 50%;
      height: 100vh;
      flex-direction: column;
      justify-content: center;
      row-gap: 10px;
      top: 0;
      z-index: 10;
      transition: 300ms;
      left: -50%;
    }

    .menu-open {
      left: 0 !important;
    }

    .header ul {
      column-gap: 80px;
    }

    .header .logo {
      font-size: 26px;
      color: #d0310e;
    }

    .header a {
      color: #333;
      font-size: 20px;
    }

    .banner {
      width: 100%;
      height: 450px;
      position: relative;
      left: 0;
    }

    .banner img {
      object-fit: cover;
      position: absolute;
      height: 100%;
      width: 100vw;
      left: 0;
      top: 0;
    }

    .dim {
      width: 100%;
      height: 100%;
      background-image: linear-gradient(transparent, rgba(0, 0, 0, 0.4));
      z-index: 1;
      position: absolute;
      left: 0;
      top: 0;
    }

    .banner .content {
      z-index: 2;
      position: absolute;
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%);
      text-align: center;
    }

    .banner h1 {
      z-index: 2;
      color: #fff;
      font-size: 45px;
    }

    .content .buttons {
      margin-top: 30px;
      display: flex;
      align-items: center;
      justify-content: center;
      column-gap: 40px;
    }

    .buttons a {
      width: 150px;
      height: 50px;
      display: flex;
      align-items: center;
      justify-content: center;
      user-select: none;
      cursor: pointer;
      border: 2px solid #d0310e;
      color: white;
      font-size: 18px;
    }

    .buttons a:first-child {
      background: #d0310e;
    }

    .partners {
      width: 100%;
      height: 60px;
      display: flex;
      align-items: center;
      justify-content: center;
      column-gap: 50px;
      background: #c4c4c4;
    }

    .partners img {
      height: 24px;
      object-fit: cover;
    }

    .nft {
      width: 1000px;
      display: flex;
      flex-direction: column;
      align-items: center;
      margin: 50px 0;
    }

    .nft h3 {
      color: #d0310e;
      font-size: 30px;
      font-weight: 600;
    }

    .people {
      margin-top: 50px;
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      column-gap: 80px;
      grid-row-gap: 80px;
      width: 90%;
    }

    .person {
      display: flex;
      align-items: center;
      justify-content: center;
      column-gap: 20px;
    }

    .person .image {
      width: 100px;
      height: 100px;
    }

    .person h3 {
      font-size: 20px;
      color: black;
    }

    .person p {
      font-size: 14px;
      color: #d0310e;
      font-weight: bold;
    }

    .person img {
      object-fit: cover;
      border-radius: 50%;
    }

    .tes {
      width: 800px;
      display: flex;
      flex-direction: column;
      align-items: center;
      margin: 50px;
      margin-top: 40px;
    }

    .tes h3 {
      color: #d0310e;
      font-size: 40px;
      font-weight: 600;
    }

    .say {
      display: flex;
      justify-content: center;
      align-items: center;
      column-gap: 40px;
      margin-top: 40px;
      width: 1200px;
    }

    .tes .say:last-child {
      flex-direction: row-reverse;
    }

    .tes .say:last-child .content {
      align-items: flex-end;
      text-align: end;
    }

    .say .image {
      width: 200px;
      height: 300px;
    }

    .say .image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .say .content {
      display: flex;
      flex-direction: column;
      row-gap: 50px;
      position: relative;
    }

    .say .content p {
      width: 500px;
    }

    .say .quote {
      width: 40px;
      height: 40px;
      object-fit: fill;
      position: absolute;
      top: -50px;
    }

    .say .name h3 {
      font-size: 15px;
    }

    .footer {
      margin-top: 70px;
      width: 100%;
      background-color: #c4c4c4;
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      height: 300px;
    }

    .footer .left {
      background-image: url("../assets/footer.png");
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      position: relative;
    }

    .footer .text {
      z-index: 2;
      position: absolute;
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%);
      text-align: center;
      color: white;
      text-align: left;
    }

    .footer .text h3 {
      font-size: 30px;
    }

    .footer .text p {
      font-size: 16px;
    }

    .footer .right {
      display: flex;
      align-items: flex-end;
      justify-content: flex-end;
      padding: 50px;
    }

    .footer .social {
      display: flex;
      align-content: center;
      flex-direction: column;
      row-gap: 20px;
      font-weight: bold;
    }

    .footer .social .images {
      display: flex;
      align-items: center;
      column-gap: 20px;
    }

    .footer .social img {
      width: 50px;
      height: 50px;
    }
  }

  @media screen and (max-width: 800px) {
    .mobile {
      display: block;
    }
    .container {
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .home {
      width: 100%;
      display: flex;
      align-items: center;
      flex-direction: column;
      justify-content: center;
    }
    .header {
      height: 80px;
      width: 600px;
    }
    .header ul {
      position: fixed;
      background: #c4c4c4;
      width: 50%;
      height: 100vh;
      flex-direction: column;
      justify-content: center;
      row-gap: 10px;
      top: 0;
      z-index: 10;
      transition: 300ms;
      left: -50%;
    }

    .menu-open {
      left: 0 !important;
    }

    .header ul {
      column-gap: 80px;
    }

    .header .logo {
      font-size: 26px;
      color: #d0310e;
    }

    .header a {
      color: #333;
      font-size: 20px;
    }

    .banner {
      width: 100%;
      height: 450px;
      position: relative;
      left: 0;
    }

    .banner img {
      object-fit: cover;
      position: absolute;
      height: 100%;
      width: 100vw;
      left: 0;
      top: 0;
    }

    .dim {
      width: 100%;
      height: 100%;
      background-image: linear-gradient(transparent, rgba(0, 0, 0, 0.4));
      z-index: 1;
      position: absolute;
      left: 0;
      top: 0;
    }

    .banner .content {
      z-index: 2;
      position: absolute;
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%);
      text-align: center;
    }

    .banner h1 {
      z-index: 2;
      color: #fff;
      font-size: 45px;
    }

    .content .buttons {
      margin-top: 30px;
      display: flex;
      align-items: center;
      justify-content: center;
      column-gap: 40px;
    }

    .buttons a {
      width: 150px;
      height: 50px;
      display: flex;
      align-items: center;
      justify-content: center;
      user-select: none;
      cursor: pointer;
      border: 2px solid #d0310e;
      color: white;
      font-size: 18px;
    }

    .buttons a:first-child {
      background: #d0310e;
    }

    .partners {
      width: 100%;
      height: 50px;
      display: flex;
      align-items: center;
      justify-content: center;
      column-gap: 50px;
      background: #c4c4c4;
    }

    .partners img {
      height: 20px;
      object-fit: cover;
    }

    .nft {
      width: 600px;
      display: flex;
      flex-direction: column;
      align-items: center;
      margin: 50px 0;
    }

    .nft h3 {
      color: #d0310e;
      font-size: 30px;
      font-weight: 600;
    }

    .people {
      margin-top: 50px;
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      column-gap: 80px;
      grid-row-gap: 80px;
      width: 90%;
    }

    .person {
      display: flex;
      align-items: center;
      justify-content: center;
      column-gap: 20px;
    }

    .person .image {
      width: 80px;
      height: 80px;
    }

    .person h3 {
      font-size: 20px;
      color: black;
    }

    .person p {
      font-size: 14px;
      color: #d0310e;
      font-weight: bold;
    }

    .person img {
      object-fit: cover;
      border-radius: 50%;
    }

    .tes {
      width: 600px;
      display: flex;
      flex-direction: column;
      align-items: center;
      margin: 50px;
      margin-top: 40px;
    }

    .tes h3 {
      color: #d0310e;
      font-size: 40px;
      font-weight: 600;
    }

    .say {
      display: flex;
      justify-content: center;
      align-items: center;
      column-gap: 40px;
      margin-top: 40px;
      width: 600px;
    }

    .tes .say:last-child {
      flex-direction: row-reverse;
    }

    .tes .say:last-child .content {
      align-items: flex-end;
      text-align: end;
    }

    .say .image {
      width: 100%;
      height: 300px;
    }

    .say .image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .say .content {
      display: flex;
      flex-direction: column;
      row-gap: 50px;
      position: relative;
    }

    .say .content p {
      width: fit-content;
    }

    .say .quote {
      width: 40px;
      height: 40px;
      object-fit: fill;
      position: absolute;
      top: -50px;
    }

    .say .name h3 {
      font-size: 15px;
    }

    .footer {
      margin-top: 70px;
      width: 100%;
      background-color: #c4c4c4;
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      height: 300px;
    }

    .footer .left {
      background-image: url("../assets/footer.png");
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      position: relative;
    }

    .footer .text {
      z-index: 2;
      position: absolute;
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%);
      text-align: center;
      color: white;
      text-align: left;
    }

    .footer .text h3 {
      font-size: 30px;
    }

    .footer .text p {
      font-size: 16px;
    }

    .footer .right {
      display: flex;
      align-items: flex-end;
      justify-content: flex-end;
      padding: 50px;
    }

    .footer .social {
      display: flex;
      align-content: center;
      flex-direction: column;
      row-gap: 20px;
      font-weight: bold;
    }

    .footer .social .images {
      display: flex;
      align-items: center;
      column-gap: 20px;
    }

    .footer .social img {
      width: 50px;
      height: 50px;
    }
  }

  @media screen and (max-width: 650px) {
    .header,
    .nft,
    .say {
      width: 500px;
    }

    .nft,
    .people {
      grid-template-columns: repeat(1, minmax(0, 1fr));
    }

    .say {
      flex-direction: column !important;
      row-gap: 20px;
    }

    .banner h1 {
      font-size: 30px !important;
    }

    .banner .buttons {
      flex-direction: column;
      row-gap: 10px;
    }

    .buttons a {
      width: 120px;
      height: 40px;
    }

    .footer {
      grid-template-columns: repeat(1, minmax(0, 1fr));
      height: fit-content;
    }

    .footer .left {
      height: 200px;
    }
  }

  @media screen and (max-width: 550px) {
    .header,
    .nft,
    .say {
      width: 450px;
    }

    .nft,
    .people {
      grid-template-columns: repeat(1, minmax(0, 1fr));
    }

    .say {
      flex-direction: column !important;
      row-gap: 20px;
    }

    .banner h1 {
      font-size: 30px !important;
    }

    .banner .buttons {
      flex-direction: column;
      row-gap: 10px;
    }

    .buttons a {
      width: 120px;
      height: 40px;
    }

    .footer {
      grid-template-columns: repeat(1, minmax(0, 1fr));
      height: fit-content;
    }

    .footer .left {
      height: 200px;
    }

    .partners {
      column-gap: 5px;
    }

    .partners img {
      height: 15px;
    }
  }

  @media screen and (max-width: 500px) {
    .header,
    .nft,
    .say {
      width: 400px;
    }

    .nft,
    .people {
      grid-template-columns: repeat(1, minmax(0, 1fr));
    }

    .say {
      flex-direction: column !important;
      row-gap: 20px;
    }

    .banner h1 {
      font-size: 30px !important;
    }

    .banner .buttons {
      flex-direction: column;
      row-gap: 10px;
    }

    .buttons a {
      width: 120px;
      height: 40px;
    }

    .footer {
      grid-template-columns: repeat(1, minmax(0, 1fr));
      height: fit-content;
    }

    .footer .left {
      height: 200px;
    }
  }

  @media screen and (max-width: 450px) {
    .header,
    .nft,
    .say {
      width: 380px;
    }

    .nft,
    .people {
      grid-template-columns: repeat(1, minmax(0, 1fr));
    }

    .say {
      flex-direction: column !important;
      row-gap: 20px;
    }

    .banner h1 {
      font-size: 30px !important;
    }

    .banner .buttons {
      flex-direction: column;
      row-gap: 10px;
    }

    .buttons a {
      width: 120px;
      height: 40px;
    }

    .footer {
      grid-template-columns: repeat(1, minmax(0, 1fr));
      height: fit-content;
    }

    .footer .left {
      height: 200px;
    }
  }

  @media screen and (max-width: 400px) {
    .header,
    .nft,
    .say {
      width: 300px;
    }

    .nft,
    .people {
      grid-template-columns: repeat(1, minmax(0, 1fr));
    }

    .say {
      flex-direction: column !important;
      row-gap: 20px;
    }

    .banner h1 {
      font-size: 30px !important;
    }

    .banner .buttons {
      flex-direction: column;
      row-gap: 10px;
    }

    .buttons a {
      width: 120px;
      height: 40px;
    }

    .footer {
      grid-template-columns: repeat(1, minmax(0, 1fr));
      height: fit-content;
    }

    .footer .left {
      height: 200px;
    }
  }
}
</style>
