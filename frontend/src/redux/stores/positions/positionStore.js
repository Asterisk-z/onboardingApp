import { createAsyncThunk, createSlice } from "@reduxjs/toolkit";
import axios from "axios";
import { toast } from "react-toastify";
import { errorHandler, successHandler } from "../../../utils/Functions";
import queryGenerator from "../../../utils/QueryGenerator";
import category from "../memberCategory/category";
const initialState = {
                    list: null,
                    error: "",
                    loading: false,
};


export const loadAllPositions = createAsyncThunk(
  "position/loadAllPositions",
  async (arg) => {
    try {
      const { data } = await axios.get(`positions`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const loadAllCategoryPositions = createAsyncThunk(
  "position/loadAllCategoryPositions",
  async (arg) => {
    const category_id = arg.category_id;
    try {
      const { data } = await axios.get(`category/${category_id}/positions`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

const positionStore = createSlice({
  name: "position",
  initialState,
  reducers: {
    clearPosition: (state) => {
      state.list = null;
    },
  },
  extraReducers: (builder) => {

    // ====== builders for loadAllPositions ======

    builder.addCase(loadAllPositions.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadAllPositions.fulfilled, (state, action) => {
      state.loading = false;
        // state.list = action.payload?.data?.data?.positions;
        state.list = JSON.stringify(action.payload?.data?.data?.positions);
    });

    builder.addCase(loadAllPositions.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for loadAllCategoryPositions ======

    builder.addCase(loadAllCategoryPositions.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadAllCategoryPositions.fulfilled, (state, action) => {
      state.loading = false;
        // state.list = action.payload?.data?.data?.positions;
        state.list = JSON.stringify(action.payload?.data?.data);
    });

    builder.addCase(loadAllCategoryPositions.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

  },
});

export default positionStore.reducer;
export const { clearPosition } = positionStore.actions;