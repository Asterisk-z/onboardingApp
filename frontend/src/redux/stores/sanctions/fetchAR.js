import { createAsyncThunk, createSlice } from "@reduxjs/toolkit";
import axios from "axios";
import { errorHandler, successHandler } from "../../../utils/Functions";

const initialState = { list: null, error: "", fetch_ar: null, loading: false};


export const loadAllActiveARs = createAsyncThunk(
  "sanction/loadAllActiveARs",
  async (arg) => {
    try {
      const { data } = await axios.get(`disciplinary-sanctions/fetch_ar`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

const fetchARStore = createSlice({
  name: "fetchAR",
  initialState,
  reducers: {
    clearFetchAR: (state) => {
      state.list = null;
    },
  },
  extraReducers: (builder) => {

    // ====== builders for loadAllActiveARs ======
    builder.addCase(loadAllActiveARs.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadAllActiveARs.fulfilled, (state, action) => {
        state.loading = false;
        state.list = JSON.stringify(action.payload?.data?.data?.fetch_ar);
    });

    builder.addCase(loadAllActiveARs.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
    
  },
});

export default fetchARStore.reducer;
export const { clearFetchAR } = fetchARStore.actions;