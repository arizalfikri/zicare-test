<script>
import axios from "axios";
import { RouterLink } from "vue-router";

export default {
  data() {
    return {
      base_url: "http://localhost:8000/api/pasiens",
      data: {
        name: "",
        sex: "male",
        religion: "",
        phone: "",
        address: "",
        nik: "",
      },
      dataError: {
        name: "",
        sex: "",
        religion: "",
        phone: "",
        address: "",
        nik: "",
      },
      error: false,
      list: ["male", "female"],
    };
  },
  components: {
    RouterLink,
  },
  methods: {
    handleBack() {
      window.history.back();
    },
    async handleGetData(id) {
      try {
        const { data } = await axios.get(this.base_url + `/${id}`);

        for (let key in data?.result) {
          this.data[key] = data.result[key];
        }
      } catch (error) {
        console.log(error);
      }
    },
    async checkValue() {
      for (let key in this.data) {
        if (!this.data[key]) {
          this.dataError[key] = `${key} is required`;
          this.error = true;
        }
      }
    },
    async handleSubmit(e) {
      e.preventDefault();
      await this.checkValue();
      if (this.error) {
        Swal.fire({
          icon: "error",
          text: "Please correct your data",
          showConfirmButton: false,
          timer: 1500,
        });
      } else {
        if (this.$route.query?.id) {
          const { data } = await axios({
            method: "PUT",
            headers: {
              "Content-Type": "application/json",
              "Access-Control-Allow-Origin": "*",
            },
            url: this.base_url + `/${this.$route.query.id}`,
            data: this.data,
          });

          if (data.status.code === 200) {
            Swal.fire({
              position: "top-end",
              icon: "success",
              text: "success update data",
              showConfirmButton: false,
              timer: 1500,
            });
          } else {
            Swal.fire({
              position: "top-end",
              icon: "error",
              text: "Something wrong",
              showConfirmButton: false,
              timer: 1500,
            });
          }
        } else {
          const { data } = await axios({
            method: "POST",
            headers: {
              "Content-Type": "application/json",
              "Access-Control-Allow-Origin": "*",
            },
            url: this.base_url,
            data: this.data,
          });

          if (data.status.code === 201) {
            Swal.fire({
              position: "top-end",
              icon: "success",
              text: "success create data",
              showConfirmButton: false,
              timer: 1500,
            });
          } else {
            Swal.fire({
              position: "top-end",
              icon: "error",
              text: "Something wrong",
              showConfirmButton: false,
              timer: 1500,
            });
          }
        }
      }
    },
  },
  created() {
    if (this.$route.query?.id) {
      this.handleGetData(this.$route.query.id);
    }
  },
  watch: {
    "data.name"(newName, oldName) {
      if (newName.length < 1) {
        this.dataError.name = "Name is required";
        this.error = true;
      } else if (newName.length > 50) {
        this.dataError.name = "Maximum name length is 50 characters";
        this.error = true;
      } else {
        this.dataError.name = "";
        this.error = false;
      }
    },
    "data.religion"(newReligion, oldReligion) {
      if (newReligion.length < 1) {
        this.dataError.religion = "Name is required";
        this.error = true;
      } else if (newReligion.length > 15) {
        this.dataError.religion = "Maximum religion length is 15 characters";
        this.error = true;
      } else {
        this.dataError.religion = "";
        this.error = false;
      }
    },
    "data.nik"(newNik, oldNik) {
      if (newNik.length < 1) {
        this.dataError.nik = "Nik is required";
        this.error = true;
      } else if (!Number(newNik)) {
        this.dataError.nik = "Nik must be number";
        this.error = true;
      } else if (newNik.length < 16 && newNik.length > 0) {
        this.dataError.nik = "Nik must be 16 chracters";
        this.error = true;
      } else if (newNik.length > 16) {
        this.dataError.nik = "Maximum Nik length is 16 characters";
        this.error = true;
      } else {
        this.dataError.nik = "";
        this.error = false;
      }
    },
    "data.phone"(newPhone, oldPhone) {
      if (newPhone.length < 1) {
        this.dataError.phone = "Phone is required";
        this.error = true;
      } else if (!Number(newPhone)) {
        this.dataError.phone = "Phone must be number";
        this.error = true;
      } else if (newPhone.length > 13) {
        this.dataError.phone = "Maximum phone length is 13 characters";
        this.error = true;
      } else {
        this.dataError.phone = "";
        this.error = false;
      }
    },
    "data.address"(newAddress, oldAddress) {
      if (newAddress.length < 1) {
        this.dataError.address = "Adress is required";
        this.error = true;
      } else {
        this.dataError.address = "";
        this.error = false;
      }
    },
  },
};
</script>

<template>
  <section class="max-w-7xl m-auto">
    <RouterLink to="/" class="text-blue-500 hover:text-blue-400">{{
      "< Back"
    }}</RouterLink>
    <div class="w-full">
      <form class="w-[40rem] m-auto" :onsubmit="(e) => handleSubmit(e)">
        <div
          class="mt-5 mb-8 font-extrabold text-4xl tracking-wide title capitalize border-b-4 pb-3 border-b-blue-500"
        >
          <p>
            {{ this.$route.query?.id ? "update" : "create" }}
          </p>
          <p>pasien</p>
        </div>
        <div class="columns-1">
          <div class="mb-4 flex flex-col gap-2">
            <input
              type="text"
              class="border-b-2 bg-gray-400 py-2 border-b-cyan-500 placeholder:capitalize bg-opacity-10 border-gray-600 rounded-t-md w-full px-3"
              name="name"
              placeholder="name"
              v-model="data.name"
            />
            <p class="text-red-500 text-xs">{{ dataError.name }}</p>
          </div>
          <div class="mb-4 flex flex-col gap-2">
            <input
              type="text"
              class="border-b-2 bg-gray-400 py-2 border-b-cyan-500 placeholder:capitalize bg-opacity-10 border-gray-600 rounded-t-md w-full px-3"
              name="nik"
              placeholder="nik"
              v-model="data.nik"
            />
            <p class="text-red-500 text-xs">{{ dataError.nik }}</p>
          </div>
          <div class="mb-4 flex flex-col gap-2">
            <label for="">Gender</label>
            <div class="flex gap-10">
              <div
                v-for="(val, key) in list"
                :key="key"
                class="w-fit flex gap-3 items-center"
              >
                <input
                  class="cursor-pointer"
                  type="radio"
                  name="radio"
                  :value="val"
                  v-model="data.sex"
                  :id="val"
                />
                <label :for="val" class="cursor-pointer">{{ val }}</label>
              </div>
            </div>
          </div>
          <div class="mb-4 flex flex-col gap-2">
            <input
              type="text"
              class="border-b-2 bg-gray-400 py-2 border-b-cyan-500 placeholder:capitalize bg-opacity-10 border-gray-600 rounded-t-md w-full px-3"
              name="religion"
              placeholder="religion"
              v-model="data.religion"
            />
            <p class="text-red-500 text-xs">{{ dataError.religion }}</p>
          </div>
          <div class="mb-4 flex flex-col gap-2">
            <input
              type="text"
              class="border-b-2 bg-gray-400 py-2 border-b-cyan-500 placeholder:capitalize bg-opacity-10 border-gray-600 rounded-t-md w-full px-3"
              placeholder="phone"
              name="phone"
              v-model="data.phone"
            />
            <p class="text-red-500 text-xs">{{ dataError.phone }}</p>
          </div>
          <div class="mb-4 flex flex-col gap-2">
            <textarea
              name="address"
              id=""
              rows="3"
              class="border-b-2 bg-gray-400 py-2 border-b-cyan-500 placeholder:capitalize bg-opacity-10 border-gray-600 rounded-t-md w-full px-3"
              placeholder="address"
              v-model="data.address"
            ></textarea>
            <p class="text-red-500 text-xs">{{ dataError.address }}</p>
          </div>
        </div>

        <div class="w-full flex justify-center mt-2">
          <button
            type="submit"
            class="bg-gradient-to-r capitalize from-cyan-500 to-blue-500 rounded-md shadow-lg text-white w-full py-2 transition-transform duration-100 hover:translate-y-1"
          >
            submit
          </button>
        </div>
      </form>
    </div>
  </section>
</template>

<style scoped></style>
