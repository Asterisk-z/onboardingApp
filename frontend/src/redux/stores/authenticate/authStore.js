import { createAsyncThunk, createSlice } from "@reduxjs/toolkit";
import axios from "axios";
import { toast } from "react-toastify";
import { errorHandler, successHandler } from "../../../utils/Functions";
import queryGenerator from "../../../utils/QueryGenerator";
const initialState = {
                    list: null,
                    customer: null,
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
        if (data) {
            console.log('help')
            console.log(data)
        }
      return successHandler(data, "Register Successfully Done and Sent Email");
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

  },
});

export default authStore.reducer;
export const { clearAuth } = authStore.actions;