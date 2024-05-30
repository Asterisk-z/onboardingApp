import { createAsyncThunk, createSlice } from "@reduxjs/toolkit";
import axios from "axios";
import { errorHandler, successHandler } from "../../../utils/Functions";

const initialState = { list: null, error: "", loading: false, view_all: null };


export const loadAllSanctions = createAsyncThunk(
  "sanction/loadAllSanctions",
  async (arg) => {
    try {
      const { data } = await axios.get(`disciplinary-sanctions/list_all`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const loadUserSanctions = createAsyncThunk(
  "sanction/loadUserSanctions",
  async (arg) => {
    try {
      const { data } = await axios.get(`disciplinary-sanctions/my_sanctions`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const sendSanction = createAsyncThunk(
  "disciplinary-sanctions/sendSanction",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `disciplinary-sanctions/create`,
        data: values,
      });

      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const updateSanctionStatus = createAsyncThunk(
  "disciplinary-sanctions/updateSanctionStatus",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `disciplinary-sanctions/update-status`,
        data: values,
      });

      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);



const sanctionStore = createSlice({
  name: "sanction",
  initialState,
  reducers: {
    clearSanction: (state) => {
      state.list = null;
    },
  },
  extraReducers: (builder) => {

    // ====== builders for sendSanction ======

    builder.addCase(sendSanction.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(sendSanction.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(sendSanction.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for updateSanctionStatus ======

    builder.addCase(updateSanctionStatus.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(updateSanctionStatus.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(updateSanctionStatus.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
    // ====== builders for loadAllSanctions ======

    builder.addCase(loadAllSanctions.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadAllSanctions.fulfilled, (state, action) => {
      state.loading = false;
      // state.list = action.payload?.data?.data?.categories;
      state.view_all = JSON.stringify(action.payload?.data?.data);
    });

    builder.addCase(loadAllSanctions.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for loadUserSanctions ======

    builder.addCase(loadUserSanctions.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadUserSanctions.fulfilled, (state, action) => {
      state.loading = false;
      // state.list = action.payload?.data?.data?.categories;
      state.view_all = JSON.stringify(action.payload?.data?.data);
    });

    builder.addCase(loadUserSanctions.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
  },
});

export default sanctionStore.reducer;
export const { clearSanction } = sanctionStore.actions;