import { createAsyncThunk, createSlice } from "@reduxjs/toolkit";
import axios from "axios";
import { toast } from "react-toastify";
import { errorHandler, successHandler } from "../../../utils/Functions";
import queryGenerator from "../../../utils/QueryGenerator";
const initialState = {
  list: null,
  request_list: null,
  error: "",
  loading: false,
};


export const loadAllActiveAuthoriser = createAsyncThunk(
  "users/loadAllActiveAuthoriser",
  async (arg) => {
    try {
      const { data } = await axios.get(`user/authorisers`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const loadAllStakeHolderRequests = createAsyncThunk(
  "users/loadAllStakeHolderRequests",
  async (arg) => {
    try {
      const { data } = await axios.get(`sh/access/request`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const updateStakeHolderRequests = createAsyncThunk(
  "users/updateStakeHolderRequests",
  async (values) => {

    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
          // "Content-Type": "multipart/form-data",
        },
        url: `sh/access/request`,
        data: values,
      });
      return successHandler(data, data?.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

const userStore = createSlice({
  name: "users",
  initialState,
  reducers: {
    clearUser: (state) => {
      state.list = null;
    },
  },
  extraReducers: (builder) => {

    // ====== builders for loadAllActiveAuthoriser ======

    builder.addCase(loadAllActiveAuthoriser.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadAllActiveAuthoriser.fulfilled, (state, action) => {
      state.loading = false;
      state.list = JSON.stringify(action.payload?.data?.data?.users);
    });

    builder.addCase(loadAllActiveAuthoriser.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for loadAllStakeHolderRequests ======

    builder.addCase(loadAllStakeHolderRequests.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadAllStakeHolderRequests.fulfilled, (state, action) => {
      state.loading = false;
      state.request_list = JSON.stringify(action.payload?.data?.data);
    });

    builder.addCase(loadAllStakeHolderRequests.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });


    // ====== builders for updateStakeHolderRequests ======

    builder.addCase(updateStakeHolderRequests.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(updateStakeHolderRequests.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(updateStakeHolderRequests.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload?.message;
    });

  },
});

export default userStore.reducer;
export const { clearUser } = userStore.actions;