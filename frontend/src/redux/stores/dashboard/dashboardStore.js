import { createAsyncThunk, createSlice } from "@reduxjs/toolkit";
import axios from "axios";
import { errorHandler, successHandler } from "utils/Functions";
import queryGenerator from "utils/QueryGenerator";
const initialState = { all: null, list: null, complaints: 0, applications: 0, ars: 0, transfer_list: null, user: null, total: null, error: "", loading: false };

export const loadArDashboard = createAsyncThunk(
  "dashboard/loadArDashboard",
  async (values) => {
    
    try {
      const { data } = await axios.get(`ar/dashboard`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const loadAdminDashboard = createAsyncThunk(
  "dashboard/loadAdminDashboard",
  async (values) => {
    
    try {
      const { data } = await axios.get(`admin/dashboard`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);



const dashboardStore = createSlice({
  name: "dashboard",
  initialState,
  reducers: {
    clearDashboard: (state) => {
      state.customer = null;
      state.all_fields = null;
    },
    clearAllFields: (state) => {
      state.all_fields = null;
    },
  },
  extraReducers: (builder) => {

    // ====== builders for loadAdminDashboard ======

    builder.addCase(loadAdminDashboard.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadAdminDashboard.fulfilled, (state, action) => {
        state.loading = false;
        state.complaints = action.payload?.data?.data?.complaints;
        state.applications = action.payload?.data?.data?.applications;
        state.ars = action.payload?.data?.data?.ars;
    });

    builder.addCase(loadAdminDashboard.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    
    // ====== builders for loadArDashboard ======

    builder.addCase(loadArDashboard.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadArDashboard.fulfilled, (state, action) => {
        state.loading = false;
        state.complaints = action.payload?.data?.data?.complaints;
        state.applications = action.payload?.data?.data?.applications;
        state.ars = action.payload?.data?.data?.ars;
    });

    builder.addCase(loadArDashboard.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    
  },
});

export default dashboardStore.reducer;
export const { clearDashboard } = dashboardStore.actions;