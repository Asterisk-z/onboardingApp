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

export const loadAllUsersComplaints = createAsyncThunk(
  "complaint/loadAllUsersComplaints",
  async (arg) => {
    try {
      const { data } = await axios.get(`complaint/all`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const sendComplaintFeedback = createAsyncThunk(
  "complaint/sendComplaintFeedback",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `complaint/feedback`,
        data: values,
      });
      
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const updateComplaintStatus = createAsyncThunk(
  "complaint/updateComplaintStatus",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `complaint/status`,
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

    // ====== builders for loadAllUsersComplaints ======

    builder.addCase(loadAllUsersComplaints.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadAllUsersComplaints.fulfilled, (state, action) => {
        state.loading = false;
        // state.list = action.payload?.data?.data?.categories;
        state.list = JSON.stringify(action.payload?.data?.data);
    });

    builder.addCase(loadAllUsersComplaints.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
    
    // ====== builders for sendComplaintFeedback ======

    builder.addCase(sendComplaintFeedback.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(sendComplaintFeedback.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(sendComplaintFeedback.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
    
    // ====== builders for updateComplaintStatus ======

    builder.addCase(updateComplaintStatus.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(updateComplaintStatus.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(updateComplaintStatus.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

  },
});

export default complaintStore.reducer;
export const { clearComplaint } = complaintStore.actions;