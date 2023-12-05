import { createAsyncThunk, createSlice } from "@reduxjs/toolkit";
import axios from "axios";
import { errorHandler, successHandler } from "../../../utils/Functions";

const initialState = { list: null, error: "", loading: false};


export const loadAllComplaints = createAsyncThunk(
  "complaint/loadAllComplaints",
  async (arg) => {
    try {
      const { data } = await axios.get(`complaint`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const sendComplaint = createAsyncThunk(
  "complaint/sendComplaint",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `complaint/store`,
        data: values,
      });
      
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);
const complaintStore = createSlice({
  name: "complaint",
  initialState,
  reducers: {
    clearComplaint: (state) => {
      state.list = null;
    },
  },
  extraReducers: (builder) => {

    // ====== builders for sendComplaint ======

    builder.addCase(sendComplaint.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(sendComplaint.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(sendComplaint.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for loadAllComplaints ======

    builder.addCase(loadAllComplaints.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadAllComplaints.fulfilled, (state, action) => {
        state.loading = false;
        // state.list = action.payload?.data?.data?.categories;
        state.list = JSON.stringify(action.payload?.data?.data);
    });

    builder.addCase(loadAllComplaints.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

  },
});

export default complaintStore.reducer;
export const { clearComplaint } = complaintStore.actions;