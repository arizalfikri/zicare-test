import { createApp } from "vue";
import "./style.css";
import App from "./App.vue";
import router from "./routes";
// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
const firebaseConfig = {
  apiKey: "AIzaSyAg3RJheD35eeUTS5eTMN7nZ0mp3OV6lME",
  authDomain: "zicare-test.firebaseapp.com",
  projectId: "zicare-test",
  storageBucket: "zicare-test.appspot.com",
  messagingSenderId: "1033331763166",
  appId: "1:1033331763166:web:78a35b7f01dbfd503d1f4f",
};

// Initialize Firebase
initializeApp(firebaseConfig);

const app = createApp(App);
app.use(router);
app.mount("#app");
