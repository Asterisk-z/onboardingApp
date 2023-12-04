import { createAsyncThunk, createSlice } from "@reduxjs/toolkit";
import axios from "axios";
import { errorHandler, successHandler } from "../../../utils/Functions";

const initialState = { list: null, error: "", loading: false};


export const loadAllComplaintTypes = createAsyncThunk(
  "complaintType/loadAllComplaintTypes",
  async (arg) => {
    try {
      const { data } = await axios.get(`complaint-types`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

const complaintTypeStore = createSlice({
  name: "complaintType",
  initialState,
  reducers: {
    clearComplaintType: (state) => {
      state.list = null;
    },
  },
  extraReducers: (builder) => {

    // ====== builders for loadAllComplaintTypes ======

    builder.addCase(loadAllComplaintTypes.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadAllComplaintTypes.fulfilled, (state, action) => {
        state.loading = false;
        state.list = JSON.stringify(action.payload?.data?.data?.compliant_types);
    });

    builder.addCase(loadAllComplaintTypes.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

  },
});

export default complaintTypeStore.reducer;
export const { clearComplaintType } = complaintTypeStore.actions;