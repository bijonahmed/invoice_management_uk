<template>
  <Datepicker :inputFormat="'yyyy-MM-dd h:i:s'" v-model="date" />
</template>

<script>
import Datepicker from "vue3-datepicker";
export default {
  name: "App",
  data() {
    return {
      isFocused: false,
      date: new Date(),
    };
  },
  components: {
    Datepicker,
  },
  methods: {
    handleOnFocus() {
      console.log("Focused");
      this.isFocused = true;
    },
    handlOnBlur() {
      this.isFocused = false;
    },
  },
};
</script>

<style>
/* #app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
} */
.label-visible {
  top: -35px;
  left: 4px;
  visibility: visible;
}
.label-invisible {
  top: -10px;
  left: 4px;
  visibility: hidden;
}
.input-field {
  margin-top: 30px;
  position: relative;
}
.input-field > input {
  width: 100%;
}
.input-field > p {
  position: absolute;
  font-size: 14px;
  transition: 0.3s;
}
</style>