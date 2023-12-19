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


export const loadAllSettings = createAsyncThunk(
  "settings/loadAllSettings",
  async (arg) => {
    const query = queryGenerator(arg);
    try {
      const { data } = await axios.get(`system/configs?${query}`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

const settingStore = createSlice({
  name: "settings",
  initialState,
  reducers: {
    clearSettings: (state) => {
      state.list = null;
    },
  },
  extraReducers: (builder) => {

    // ====== builders for loadAllSettings ======

    builder.addCase(loadAllSettings.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadAllSettings.fulfilled, (state, action) => {
      state.loading = false;
        // state.list = action.payload?.data?.data?.countries;  
        state.list = JSON.stringify(action.payload?.data?.data);
    });

    builder.addCase(loadAllSettings.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

  },
});

export default settingStore.reducer;
export const { clearSettings } = settingStore.actions;