import React from "react";
import ReactDOM from 'react-dom/client';
import { BrowserRouter } from "react-router-dom";
import App from "./App";
import { toast } from "react-toastify";
import "App.css"

import "./assets/scss/dashlite.scss";
import "./assets/scss/style-email.scss";

import axios from "axios";
import { Provider } from "react-redux";

import reportWebVitals from "./reportWebVitals";

import store from "./redux/app/store";

axios.defaults.baseURL = process.env.REACT_APP_APP_API;

const accessToken = localStorage.getItem("access-token");

axios.defaults.headers.common["Authorization"] = `Bearer ${accessToken}`;

axios.defaults.headers.common["Access-Control-Allow-Origin"] = `*`;

axios.interceptors.response.use(function (config) {
    // Do something before request is sent
    return config;
  }, function (error) {
    console.log(error.response)
    // console.log(error.response.data)
      // if(error.response.status == '999') {
      //   toast.success(error.response.statusText);
      //   window.location.href = `${process.env.PUBLIC_URL}/logout`
      // }
    return Promise.reject(error);
  });

const root = ReactDOM.createRoot(document.getElementById('root'));

root.render(
  <>
    <Provider store={store}>
      <BrowserRouter>
        <App />
      </BrowserRouter>
    </Provider>

  </>
);

// If you want to start measuring performance in your app, pass a function
// to log results (for example: reportWebVitals(console.log))
// or send to an analytics endpoint. Learn more: https://bit.ly/CRA-vitals
reportWebVitals();
