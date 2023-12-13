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


export const loadViewMessages = createAsyncThunk(
  "broadcast/loadViewMessages",
  async (arg) => {
    try {
      const { data } = await axios.get(`broadcasts/view-messages`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const CreateBroadcast = createAsyncThunk(
  "broadcast/CreateBroadcast",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
        },
        url: `broadcasts/create-message`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

const broadcastStore = createSlice({
  name: "broadcast",
  initialState,
  reducers: {
    clearBroadcast: (state) => {
      state.list = null;
    },
  },
  extraReducers: (builder) => {

    // ====== builders for loadViewMessages ======

    builder.addCase(loadViewMessages.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadViewMessages.fulfilled, (state, action) => {
      state.loading = false;
        // state.list = action.payload?.data?.data?.countries;
        state.list = JSON.stringify(action.payload?.data?.data);
    });

    builder.addCase(loadViewMessages.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
        
    // ====== builders for CreateBroadcast ======

    builder.addCase(CreateBroadcast.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(CreateBroadcast.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(CreateBroadcast.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

  },
});

export default broadcastStore.reducer;
export const { clearBroadcast } = broadcastStore.actions;