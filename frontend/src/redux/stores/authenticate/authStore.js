import { createAsyncThunk, createSlice } from "@reduxjs/toolkit";
import axios from "axios";
import { errorHandler, successHandler } from "../../../utils/Functions";
const initialState = { list: null, user: null, total: null, error: "", loading: false };

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
      return successHandler(data, data.message);
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
        localStorage.removeItem('reset-password-email')
      }
      return successHandler(data, "Login Successful");
    } catch (error) {
      console.log(error.response.data.statusCode)
      console.log(values.email)
      if (error.response.data.statusCode == '666') {
        localStorage.setItem("reset-password-email", values.email);
      }
      return errorHandler(error?.response, true);
    }
  }
);

export const passwordResetInitiate = createAsyncThunk(
  "authenticate/passwordResetInitiate",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
        },
        url: `auth/password/reset/initiate`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);


export const passwordResetOtp = createAsyncThunk(
  "authenticate/passwordResetOtp",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
        },
        url: `auth/password/reset/otp`,
        data: values,
      });
      
      localStorage.setItem('reset-token', data.data.reset.reset_token)
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);


export const passwordChange = createAsyncThunk(
  "authenticate/passwordChange",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
        },
        url: `auth/password/change`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);


export const passwordResetComplete = createAsyncThunk(
  "authenticate/passwordResetComplete",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
          "Authorization": "Bearer "+localStorage.getItem('reset-token')
        },
        url: `auth/password/reset/complete`,
        data: values,
      });
      localStorage.clear();
      return successHandler(data, data.message);
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

    // ====== builders for passwordResetInitiate ======

    builder.addCase(passwordResetInitiate.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(passwordResetInitiate.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(passwordResetInitiate.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
    
    // ====== builders for passwordResetOtp ======

    builder.addCase(passwordResetOtp.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(passwordResetOtp.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(passwordResetOtp.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
    
    // ====== builders for passwordResetComplete ======

    builder.addCase(passwordResetComplete.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(passwordResetComplete.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(passwordResetComplete.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
    
    // ====== builders for passwordChange ======

    builder.addCase(passwordChange.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(passwordChange.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(passwordChange.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
    
  },
});

export default authStore.reducer;
export const { clearAuth } = authStore.actions;