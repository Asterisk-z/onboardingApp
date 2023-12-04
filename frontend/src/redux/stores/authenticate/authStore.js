import { createAsyncThunk, createSlice } from "@reduxjs/toolkit";
import axios from "axios";
import { toast } from "react-toastify";
import { errorHandler, successHandler } from "../../../utils/Functions";
import queryGenerator from "../../../utils/QueryGenerator";
const initialState = {
                    list: null,
                    user: null,
                    total: null,
                    error: "",
                    loading: false,
};

export const registerUser = createAsyncThunk(
  "authenticate/registerUser",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
        },
        url: `auth/register`,
        data: values,
      });
      return successHandler(data, "You have successfully signed up as a member. Kindly check your mail to proceed with completion of the membership form");
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const loginUser = createAsyncThunk(
  "authenticate/login",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
        },
        url: `auth/login`,
        data: values,
      });
      if(data) {    
        localStorage.setItem("access-token", data.data.authorization.token);
        localStorage.setItem("role", data.data.user?.role?.name?.split(' ').join(''));
        localStorage.setItem("user_mail", data.data.user.email);
        localStorage.setItem("firstName", data.data.user.firstName);
        localStorage.setItem("id", data.data.user.id);
        localStorage.setItem("logger", btoa(JSON.stringify(data.data.user)));
      }
      return successHandler(data, "Login Successful");
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);


const authStore = createSlice({
  name: "authenticate",
  initialState,
  reducers: {
    clearAuth: (state) => {
      state.customer = null;
    },
  },
  extraReducers: (builder) => {

    // ====== builders for registerUser ======

    builder.addCase(registerUser.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(registerUser.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(registerUser.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for loginUser ======

    builder.addCase(loginUser.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loginUser.fulfilled, (state, action) => {
      state.loading = false;
      
      if (!Array.isArray(state.user)) {
        state.user = [];
      }
      const user = [...state.user];
      user.push(action.payload?.data.data.user);
      state.user = user;
    });

    builder.addCase(loginUser.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
  },
});

export default authStore.reducer;
export const { clearAuth } = authStore.actions;