import { createAsyncThunk, createSlice } from "@reduxjs/toolkit";
import axios from "axios";
import { errorHandler, successHandler } from "../../../utils/Functions";

const initialState = {
  list: null,
  error: "",
  view_all: null,
  active_list: null,
  active: null,
  loading: false,
};

export const loadActiveFees = createAsyncThunk(
  "fees/loadActiveFees",
  async (arg) => {
    try {
      const { data } = await axios.get(`fees-and-dues/current`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const loadFeesAndDues = createAsyncThunk(
  "fees/loadFeesAndDues",
  async (arg) => {
    try {
      const { data } = await axios.get(`meg/fees-and-dues/list_all`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const createFeesAndDues = createAsyncThunk(
  "fees/createFeesAndDues",
  async (values) => {
    try {
      const { data } = await axios.post(`meg/fees-and-dues/create`, values, {
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
        },
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const updateFeesAndDues = createAsyncThunk(
  "fees/updateFeesAndDues",
  async (values) => {
    const id = values.id;
    try {
      const { data } = await axios.post(`meg/fees-and-dues/update/${id}`, values, {
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
        },
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const updateFeesAndDuesStatus = createAsyncThunk(
  "fees/updateFeesAndDuesStatus",
  async (values) => {
    const id = values.get('id');
    try {
      const { data } = await axios.post(`meg/fees-and-dues/update-status/${id}`, values, {
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
        },
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

const feesAndDuesStore = createSlice({
  name: "fees",
  initialState,
  reducers: {
    clearFeesAndDues: (state) => {
      state.list = null;
    },
  },
  extraReducers: (builder) => {
    // builder.addCase(loadFeesAndDues.fulfilled, (state, action) => {
    //   state.list_all = JSON.stringify(action.payload?.data?.data);
    // });

    builder.addCase(loadFeesAndDues.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadFeesAndDues.fulfilled, (state, action) => {
      state.loading = false;
      state.view_all = JSON.stringify(action.payload?.data?.data);
    });

    builder.addCase(loadFeesAndDues.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    builder.addCase(loadActiveFees.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadActiveFees.fulfilled, (state, action) => {
      state.loading = false;
      state.active = JSON.stringify(action.payload?.data?.data);
    });

    builder.addCase(loadActiveFees.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    builder.addCase(createFeesAndDues.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(createFeesAndDues.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(createFeesAndDues.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    builder.addCase(updateFeesAndDues.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(updateFeesAndDues.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(updateFeesAndDues.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    builder.addCase(updateFeesAndDuesStatus.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(updateFeesAndDuesStatus.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(updateFeesAndDuesStatus.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
  },
});

export default feesAndDuesStore.reducer;
export const { clearFeesAndDues } = feesAndDuesStore.actions;
