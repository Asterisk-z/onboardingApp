import { createAsyncThunk, createSlice } from "@reduxjs/toolkit";
import axios from "axios";
import { toast } from "react-toastify";
import { errorHandler, successHandler } from "../../../utils/Functions";
import queryGenerator from "../../../utils/QueryGenerator";
const initialState = {
                    list: null,
                    doh_list: null,
                    systems: null,
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
export const loadGetSignature = createAsyncThunk(
  "settings/loadGetSignature",
  async () => {
    
    try {
      const { data } = await axios.get(`doh/signature`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const postSignature = createAsyncThunk(
  "settings/postSignature",
  async (values) => {
    
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `doh/signature`,
        data: values,
      });
      return successHandler(data);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const loadFmdqSystems = createAsyncThunk(
  "settings/loadFmdqSystems",
  async () => {

    try {
      const { data } = await axios.get(`general/fmdq-systems`);
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

    // ====== builders for loadGetSignature ======

    builder.addCase(loadGetSignature.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadGetSignature.fulfilled, (state, action) => {
      state.loading = false;
      // state.list = action.payload?.data?.data?.countries;  
      state.doh_list = JSON.stringify(action.payload?.data?.data);
    });

    builder.addCase(loadGetSignature.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for postSignature ======

    builder.addCase(postSignature.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(postSignature.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(postSignature.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for loadFmdqSystems ======

    builder.addCase(loadFmdqSystems.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadFmdqSystems.fulfilled, (state, action) => {
      state.loading = false;
      // state.list = action.payload?.data?.data?.countries;  
      state.systems = JSON.stringify(action.payload?.data?.data);
    });

    builder.addCase(loadFmdqSystems.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
  },
});

export default settingStore.reducer;
export const { clearSettings } = settingStore.actions;