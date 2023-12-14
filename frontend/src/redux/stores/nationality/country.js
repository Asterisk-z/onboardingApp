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


export const loadAllCountries = createAsyncThunk(
  "country/loadAllCountries",
  async (arg) => {
    try {
      const { data } = await axios.get(`nationalities`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

const countryStore = createSlice({
  name: "country",
  initialState,
  reducers: {
    clearCountry: (state) => {
      state.list = null;
    },
  },
  extraReducers: (builder) => {

    // ====== builders for loadAllCountries ======

    builder.addCase(loadAllCountries.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadAllCountries.fulfilled, (state, action) => {
      state.loading = false;
        // state.list = action.payload?.data?.data?.countries;  
        state.list = JSON.stringify(action.payload?.data?.data?.countries);
    });

    builder.addCase(loadAllCountries.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

  },
});

export default countryStore.reducer;
export const { clearCountry } = countryStore.actions;