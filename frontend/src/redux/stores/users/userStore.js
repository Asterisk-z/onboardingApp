import { createAsyncThunk, createSlice } from "@reduxjs/toolkit";
import axios from "axios";
import { toast } from "react-toastify";
import { errorHandler, successHandler } from "../../../utils/Functions";
import queryGenerator from "../../../utils/QueryGenerator";
const initialState = {
  list: null,
  request_list: null,
  error: "",
  loading: false,
  stake_list: null, stake_view_all: null, stake_active_list: null,
};


export const loadAllActiveAuthoriser = createAsyncThunk(
  "users/loadAllActiveAuthoriser",
  async (arg) => {
    try {
      const { data } = await axios.get(`user/authorisers`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const loadAllStakeHolderRequests = createAsyncThunk(
  "users/loadAllStakeHolderRequests",
  async (arg) => {
    try {
      const { data } = await axios.get(`sh/access/request`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const updateStakeHolderRequests = createAsyncThunk(
  "users/updateStakeHolderRequests",
  async (values) => {

    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
          // "Content-Type": "multipart/form-data",
        },
        url: `sh/access/request`,
        data: values,
      });
      return successHandler(data, data?.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const loadAllActiveStakeHolders = createAsyncThunk(
  "users/loadAllActiveStakeHolders",
  async (arg) => {
    try {
      const { data } = await axios.get(`meg/stakeholder/active_list`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);



export const loadAllStakeHolders = createAsyncThunk(
  "users/loadAllStakeHolders",
  async (arg) => {
    try {
      const { data } = await axios.get(`meg/stakeholder/view_all`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const createStakeHolder = createAsyncThunk(
  "users/createStakeHolder",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
        },
        url: `meg/stakeholder/create`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);


export const updateStakeHolder = createAsyncThunk(
  "users/updateStakeHolder",
  async (values) => {
    const id = values.get('id')
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
        },
        url: `meg/stakeholder/update/${id}`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const updateStakeHolderStatus = createAsyncThunk(
  "users/updateStakeHolderStatus",
  async (values) => {
    const id = values.get('id')
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
        },
        url: `meg/stakeholder/update-status/${id}`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);
const userStore = createSlice({
  name: "users",
  initialState,
  reducers: {
    clearUser: (state) => {
      state.list = null;
    },
  },
  extraReducers: (builder) => {

    // ====== builders for loadAllActiveAuthoriser ======

    builder.addCase(loadAllActiveAuthoriser.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadAllActiveAuthoriser.fulfilled, (state, action) => {
      state.loading = false;
      state.list = JSON.stringify(action.payload?.data?.data?.users);
    });

    builder.addCase(loadAllActiveAuthoriser.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for loadAllStakeHolderRequests ======

    builder.addCase(loadAllStakeHolderRequests.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadAllStakeHolderRequests.fulfilled, (state, action) => {
      state.loading = false;
      state.request_list = JSON.stringify(action.payload?.data?.data);
    });

    builder.addCase(loadAllStakeHolderRequests.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });


    // ====== builders for updateStakeHolderRequests ======

    builder.addCase(updateStakeHolderRequests.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(updateStakeHolderRequests.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(updateStakeHolderRequests.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload?.message;
    });

    // ====== builders for loadAllActiveStakeHolders ======

    builder.addCase(loadAllActiveStakeHolders.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadAllActiveStakeHolders.fulfilled, (state, action) => {
      state.loading = false;
      // state.list = action.payload?.data?.data?.positions;
      state.stake_active_list = JSON.stringify(action.payload?.data?.data?.users);
    });

    builder.addCase(loadAllActiveStakeHolders.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for loadAllPositions ======

    builder.addCase(loadAllStakeHolders.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadAllStakeHolders.fulfilled, (state, action) => {
      state.loading = false;
      // state.list = action.payload?.data?.data?.categories;
      state.stake_view_all = JSON.stringify(action.payload?.data?.data?.users);
    });

    builder.addCase(loadAllStakeHolders.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });


    // ====== builders for updateStakeHolder ======

    builder.addCase(updateStakeHolder.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(updateStakeHolder.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(updateStakeHolder.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for updateStakeHolderStatus ======

    builder.addCase(updateStakeHolderStatus.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(updateStakeHolderStatus.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(updateStakeHolderStatus.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for createStakeHolder ======

    builder.addCase(createStakeHolder.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(createStakeHolder.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(createStakeHolder.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
  },
});

export default userStore.reducer;
export const { clearUser } = userStore.actions;