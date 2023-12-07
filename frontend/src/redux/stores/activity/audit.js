import { createAsyncThunk, createSlice } from "@reduxjs/toolkit";
import axios from "axios";
import { toast } from "react-toastify";
import { errorHandler, successHandler } from "../../../utils/Functions";
import queryGenerator from "../../../utils/QueryGenerator";
const initialState = {
                    list: null,
                    ulist: null,
                    error: "",
                    loading: false,
};


export const loadAllUserLog = createAsyncThunk(
  "activity/loadAllUserLog",
  async (arg) => {
    try {
      const { data } = await axios.get(`user/logs`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);


export const loadAllAuditLog = createAsyncThunk(
  "activity/loadAllAuditLog",
  async (arg) => {
    try {
      const { data } = await axios.get(`audits/logs`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

const activityStore = createSlice({
  name: "activity",
  initialState,
  reducers: {
    clearActivity: (state) => {
      state.list = null;
    },
  },
  extraReducers: (builder) => {

    // ====== builders for loadAllAuditLog ======

    builder.addCase(loadAllAuditLog.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadAllAuditLog.fulfilled, (state, action) => {
      state.loading = false;
        state.list = JSON.stringify(action.payload?.data?.data);
    });

    builder.addCase(loadAllAuditLog.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for loadAllUserLog ======

    builder.addCase(loadAllUserLog.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadAllUserLog.fulfilled, (state, action) => {
        state.loading = false;
        state.ulist = JSON.stringify(action.payload?.data?.data);
    });

    builder.addCase(loadAllUserLog.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

  },
});

export default activityStore.reducer;
export const { clearActivity } = activityStore.actions;