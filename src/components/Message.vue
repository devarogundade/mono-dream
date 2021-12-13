<template>
  <div class="container">
    <div class="view">
      <p>{{ title }}</p>
      <img src="../assets/happy.png" alt="" />
      <p>{{ message }}</p>
      <a :href="link">{{ a }}</a>
      <div class="close" v-on:click="$emit('close')">X</div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["message", "image", "title", "a", "link"],
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
            overflow-x: hidden;
  align-items: center;
  justify-content: center;
}

.view {
  width: 600px;
  height: 450px;
  max-width: 80%;
  background: white;
  border-radius: 6px;
  text-align: center;
  display: flex;
            overflow-x: hidden;
  align-items: center;
  flex-direction: column;
  row-gap: 50px;
  position: relative;
  padding: 50px;
  justify-content: center;
}

img {
  width: 100px;
  margin-top: -30px;
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

a {
  border: 2px solid#d0310e;
  color: #d0310e;
  padding: 10px;
  font-weight: bold;
  border-radius: 4px;
  width: 250px;
  display: block;
}
</style>
