import { createAsyncThunk, createSlice } from "@reduxjs/toolkit";
import axios from "axios";
import { toast } from "react-toastify";
import { errorHandler, successHandler } from "../../../utils/Functions";
import queryGenerator from "../../../utils/QueryGenerator";
const initialState = {
  list_changes: null,
  list_ar_changes: null,
  list: null,
  request_list: null,
  error: "",
  loading: false,
  stake_list: null, stake_view_all: null, stake_active_list: null,
};


export const sendNotificationOfChange = createAsyncThunk(
  "changes/sendNotificationOfChange",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `change-request/send`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const loadArNotificationOfChange = createAsyncThunk(
  "changes/loadArNotificationOfChange",
  async (arg) => {
    try {
      const { data } = await axios.get(`change-request/ar-list`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const arUpdateNotificationOfChangeStatus = createAsyncThunk(
  "changes/arUpdateNotificationOfChangeStatus",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `change-request/update-status`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const arSendCommentNotificationOfChange = createAsyncThunk(
  "changes/arSendCommentNotificationOfChange",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `change-request/ar-comment`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const megSendCommentNotificationOfChange = createAsyncThunk(
  "changes/megSendCommentNotificationOfChange",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `change-request/meg-comment`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const loadMegNotificationOfChange = createAsyncThunk(
  "changes/loadMegNotificationOfChange",
  async (arg) => {
    try {
      const { data } = await axios.get(`change-request/list`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const megUpdateNotificationOfChangeStatus = createAsyncThunk(
  "changes/megUpdateNotificationOfChangeStatus",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `change-request/meg-update-status`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);




const changeStore = createSlice({
  name: "changes",
  initialState,
  reducers: {
    clearUser: (state) => {
      state.list = null;
    },
  },
  extraReducers: (builder) => {


    // ====== builders for sendNotificationOfChange ======

    builder.addCase(sendNotificationOfChange.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(sendNotificationOfChange.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(sendNotificationOfChange.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for loadArNotificationOfChange ======

    builder.addCase(loadArNotificationOfChange.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadArNotificationOfChange.fulfilled, (state, action) => {
      state.loading = false;
      state.list_ar_changes = JSON.stringify(action.payload?.data?.data);
    });

    builder.addCase(loadArNotificationOfChange.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });


    // ====== builders for loadMegNotificationOfChange ======

    builder.addCase(loadMegNotificationOfChange.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadMegNotificationOfChange.fulfilled, (state, action) => {
      state.loading = false;
      state.list_changes = JSON.stringify(action.payload?.data?.data);
    });

    builder.addCase(loadMegNotificationOfChange.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for arUpdateNotificationOfChangeStatus ======

    builder.addCase(arUpdateNotificationOfChangeStatus.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(arUpdateNotificationOfChangeStatus.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(arUpdateNotificationOfChangeStatus.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });


    // ====== builders for megUpdateNotificationOfChangeStatus ======

    builder.addCase(megUpdateNotificationOfChangeStatus.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(megUpdateNotificationOfChangeStatus.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(megUpdateNotificationOfChangeStatus.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for arSendCommentNotificationOfChange ======

    builder.addCase(arSendCommentNotificationOfChange.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(arSendCommentNotificationOfChange.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(arSendCommentNotificationOfChange.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for megSendCommentNotificationOfChange ======

    builder.addCase(megSendCommentNotificationOfChange.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(megSendCommentNotificationOfChange.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(megSendCommentNotificationOfChange.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

  },
});

export default changeStore.reducer;
export const { clearUser } = changeStore.actions;