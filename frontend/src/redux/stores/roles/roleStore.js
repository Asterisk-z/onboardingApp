import { createAsyncThunk, createSlice } from "@reduxjs/toolkit";
import axios from "axios";
import { toast } from "react-toastify";
import { errorHandler, successHandler } from "../../../utils/Functions";
import queryGenerator from "../../../utils/QueryGenerator";
const initialState = {
                    list: null,
                    error: "",
                    loading: false,
};


export const loadUserRoles = createAsyncThunk(
  "role/loadUserRoles",
  async (arg) => {
    try {
      const { data } = await axios.get(`ar_roles`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const loadAdminRoles = createAsyncThunk(
  "role/loadAdminRoles",
  async (arg) => {
    try {
      const { data } = await axios.get(`admin_roles`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

const roleStore = createSlice({
  name: "role",
  initialState,
  reducers: {
    clearRole: (state) => {
      state.list = null;
    },
  },
  extraReducers: (builder) => {

    // ====== builders for loadAdminRoles ======

    builder.addCase(loadAdminRoles.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadAdminRoles.fulfilled, (state, action) => {
      state.loading = false;
        // state.list = action.payload?.data?.data?.roles;
        state.list = JSON.stringify(action.payload?.data?.data?.roles);
    });

    builder.addCase(loadAdminRoles.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
    
    // ====== builders for loadUserRoles ======

    builder.addCase(loadUserRoles.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadUserRoles.fulfilled, (state, action) => {
      state.loading = false;
        // state.list = action.payload?.data?.data?.roles;
        state.list = JSON.stringify(action.payload?.data?.data?.roles);
    });

    builder.addCase(loadUserRoles.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

  },
});

export default roleStore.reducer;
export const { clearRole } = roleStore.actions;