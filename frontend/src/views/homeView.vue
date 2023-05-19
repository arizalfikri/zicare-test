<script>
import axios from "axios";

export default {
  data() {
    return {
      data_pasien: [],
      base_url: "http://localhost:8000/api/pasiens",
      action: [
        {
          label: "detail",
          className:
            "bg-slate-500 hover:bg-slate-400 py-1 px-3 rounded-sm text-white",
        },
        {
          label: "update",
          className:
            "bg-green-500 hover:bg-green-400 py-1 px-3 rounded-sm text-white",
        },
        {
          label: "delete",
          icon: "../assets/gif/delete.gif",
          className:
            "bg-delete-500 hover:bg-delete-400 py-1 px-3 rounded-sm text-white flex items-center",
        },
      ],
    };
  },
  methods: {
    handleToFormPasien() {
      this.$router.push({ path: "/form" });
    },
    async getData() {
      try {
        const response = await axios.get(this.base_url);
        const { data } = response;
        this.data_pasien = data.result;
      } catch (error) {
        console.log(error);
      }
    },
    async handleClick(action) {
      const { label, id } = action;
      if (label === "update") {
        this.$router.push({ path: "/form", query: { id: id } });
      }
      if (label === "delete") {
        Swal.fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!",
        }).then(async (result) => {
          if (result.isConfirmed) {
            await axios.delete(this.base_url + `/${id}`);
            this.getData();
            Swal.fire("Deleted!", "Your file has been deleted.", "success");
          }
        });
      }
      if (label === "detail") {
        this.$router.push({ path: `/detail/${id}` });
      }
    },
  },
  created() {
    this.getData();
  },
};
</script>

<template>
  <section class="capitalize w-full max-w-7xl m-auto">
    <div class="">
      <!-- <h1 class="capitalize text-xl">list pasien</h1> -->
      <div
        class="mt-5 mb-5 font-extrabold text-4xl tracking-wide title capitalize"
      >
        <p>list&nbsp;<span>pasien</span></p>
      </div>
      <button
        class="bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-400 hover:to-blue-400 capitalize rounded-md shadow-lg text-white w-40 py-2"
        :onclick="handleToFormPasien"
      >
        add pasien
      </button>
    </div>

    <table class="table-fixed w-full mt-10">
      <thead class="bg-slate-300">
        <tr class="capitalize h-10">
          <th class="w-[5%]">no</th>
          <th class="w-[25%] text-start">name</th>
          <th class="w-[25%] text-start">nik</th>
          <th class="w-[10%]">sex</th>
          <th class="w-[35%] text-center -date">action</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="(pasien, i) in data_pasien"
          :key="i"
          class="border-b-2 border-b-gray-500 h-11"
        >
          <td class="text-center">{{ i + 1 }}</td>
          <td>{{ pasien.name }}</td>
          <td class="text-left">{{ pasien.nik }}</td>
          <td class="text-center">{{ pasien.sex }}</td>
          <td class="">
            <div class="flex justify-end h-14 items-center gap-2">
              <button
                v-for="({ className, label, icon }, i) in action"
                :key="i"
                :class="className"
                :onclick="() => handleClick({ label: label, id: pasien.id })"
              >
                {{ label }}
              </button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
    <div v-if="data_pasien.length < 1" class="text-center text-gray-600 mt-5">
      empty data
    </div>
  </section>
</template>

<style scoped></style>
