<script>
import axios from "axios";
import { RouterLink } from "vue-router";

export default {
  components: {
    RouterLink,
  },
  data() {
    return {
      base_url: "http://localhost:8000/api/pasiens",
      data: {
        nik: "",
        name: "",
        religion: "",
        sex: "",
        phone: "",
        address: "",
      },
    };
  },
  methods: {
    async handleGetData(id) {
      try {
        const { data } = await axios.get(this.base_url + `/${id}`);

        this.data = data.result;
      } catch (error) {
        console.log(error);
      }
    },
  },
  created() {
    this.handleGetData(this.$route.params.id);
  },
};
</script>

<template>
  <section class="max-w-7xl m-auto">
    <div class="flex gap-3">
      <RouterLink to="/" class="text-blue-500 hover:text-blue-400">{{
        "< Back"
      }}</RouterLink>
    </div>
    <div
      class="mt-5 mb-8 font-extrabold text-4xl tracking-wide title capitalize border-b-4 pb-3 border-b-blue-500"
    >
      <p>detail</p>
      <p>pasien</p>
    </div>

    <table>
      <tbody>
        <tr>
          <td>name</td>
          <td class="px-3">:</td>
          <td>{{ data.name }}</td>
        </tr>
        <tr>
          <td>sex</td>
          <td class="px-3">:</td>
          <td>{{ data.sex }}</td>
        </tr>
        <tr>
          <td>phone</td>
          <td class="px-3">:</td>
          <td>{{ data.phone }}</td>
        </tr>
        <tr>
          <td>religion</td>
          <td class="px-3">:</td>
          <td>{{ data.religion }}</td>
        </tr>
        <tr>
          <td>address</td>
          <td class="px-3">:</td>
          <td>{{ data.address }}</td>
        </tr>
      </tbody>
    </table>
  </section>
</template>

<style scoped></style>
