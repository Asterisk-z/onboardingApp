import { createAsyncThunk, createSlice } from "@reduxjs/toolkit";
import axios from "axios";
import { errorHandler, successHandler } from "../../../utils/Functions";

const initialState = { list: null, error: "", loading: false};


export const loadAllCategories = createAsyncThunk(
  "category/loadAllCategories",
  async (arg) => {
    try {
      const { data } = await axios.get(`categories`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

const categoryStore = createSlice({
  name: "category",
  initialState,
  reducers: {
    clearCategory: (state) => {
      state.list = null;
    },
  },
  extraReducers: (builder) => {

    // ====== builders for loadAllCategories ======

    builder.addCase(loadAllCategories.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadAllCategories.fulfilled, (state, action) => {
        state.loading = false;
        // state.list = action.payload?.data?.data?.categories;
        state.list = JSON.stringify(action.payload?.data?.data?.categories);
    });

    builder.addCase(loadAllCategories.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

  },
});

export default categoryStore.reducer;
export const { clearCategory } = categoryStore.actions;