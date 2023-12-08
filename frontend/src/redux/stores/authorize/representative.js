import { createAsyncThunk, createSlice } from "@reduxjs/toolkit";
import axios from "axios";
import { errorHandler, successHandler } from "../../../utils/Functions";
const initialState = { all: null, list: null, user: null, total: null, error: "", loading: false };

export const userLoadUserARs = createAsyncThunk(
  "arUsers/userLoadUserARs",
  async (values) => {
    try {
      const { data } = await axios.get(`ar/list`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const userSearchUserARs = createAsyncThunk(
  "arUsers/userSearchUserARs",
  async (values) => {
    try {
      const { data } = await axios.get(`ar/search`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const userViewUserAR = createAsyncThunk(
  "arUsers/userViewUserAR",
  async (values) => {
    try {
      const { data } = await axios.get(`ar/view/user_id`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const userCreateUserAR = createAsyncThunk(
  "arUsers/userCreateUserAR",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
        },
        url: `ar/add`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const userUpdateUserAR = createAsyncThunk(
  "arUsers/userUpdateUserAR",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
        },
        url: `ar/update/user_id`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const userCancelUpdateUserAR = createAsyncThunk(
  "arUsers/userCancelUpdateUserAR",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
        },
        url: `ar/cancel-update/user_id`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const userProcessUpdateUserAR = createAsyncThunk(
  "arUsers/userProcessUpdateUserAR",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
        },
        url: `ar/process-update/user_id`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);


export const userLoadTransferUserAR = createAsyncThunk(
  "arUsers/userLoadTransferUserAR",
  async (values) => {
    try {
      const { data } = await axios.get(`ar/transfer/?status=pending`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const userLoadStatusChangeUserAR = createAsyncThunk(
  "arUsers/userLoadStatusChangeUserAR",
  async (values) => {
    try {
      const { data } = await axios.get(`ar/change-status/?status=pending`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const userTransferUserAR = createAsyncThunk(
  "arUsers/userTransferUserAR",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
        },
        url: `ar/transfer/user_id`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const userStatusChangeUserAR = createAsyncThunk(
  "arUsers/userStatusChangeUserAR",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
        },
        url: `ar/change-status/user_id`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);



const arUsersStore = createSlice({
  name: "arUsers",
  initialState,
  reducers: {
    clearArUser: (state) => {
      state.customer = null;
    },
  },
  extraReducers: (builder) => {

    // ====== builders for userLoadUserARs ======

    builder.addCase(userLoadUserARs.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(userLoadUserARs.fulfilled, (state, action) => {
        state.loading = false;
        // state.list = action.payload?.data?.data?.categories;
        state.list = JSON.stringify(action.payload?.data?.data);
    });

    builder.addCase(userLoadUserARs.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for userSearchUserARs ======

    builder.addCase(userSearchUserARs.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(userSearchUserARs.fulfilled, (state, action) => {
        state.loading = false;
        // state.list = action.payload?.data?.data?.categories;
        state.list = JSON.stringify(action.payload?.data?.data);
    });

    builder.addCase(userSearchUserARs.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for userViewUserAR ======

    builder.addCase(userViewUserAR.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(userViewUserAR.fulfilled, (state, action) => {
        state.loading = false;
        // state.list = action.payload?.data?.data?.categories;
        state.list = JSON.stringify(action.payload?.data?.data);
    });

    builder.addCase(userViewUserAR.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
  
    // ====== builders for userCreateUserAR ======

    builder.addCase(userCreateUserAR.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(userCreateUserAR.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(userCreateUserAR.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
  
    // ====== builders for userUpdateUserAR ======

    builder.addCase(userUpdateUserAR.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(userUpdateUserAR.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(userUpdateUserAR.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
  
    // ====== builders for userCancelUpdateUserAR ======

    builder.addCase(userCancelUpdateUserAR.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(userCancelUpdateUserAR.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(userCancelUpdateUserAR.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
  
    // ====== builders for userProcessUpdateUserAR ======

    builder.addCase(userProcessUpdateUserAR.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(userProcessUpdateUserAR.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(userProcessUpdateUserAR.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for userLoadTransferUserAR ======

    builder.addCase(userLoadTransferUserAR.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(userLoadTransferUserAR.fulfilled, (state, action) => {
        state.loading = false;
        // state.list = action.payload?.data?.data?.categories;
        state.list = JSON.stringify(action.payload?.data?.data);
    });

    builder.addCase(userLoadTransferUserAR.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });


    // ====== builders for userLoadStatusChangeUserAR ======

    builder.addCase(userLoadStatusChangeUserAR.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(userLoadStatusChangeUserAR.fulfilled, (state, action) => {
        state.loading = false;
        // state.list = action.payload?.data?.data?.categories;
        state.list = JSON.stringify(action.payload?.data?.data);
    });

    builder.addCase(userLoadStatusChangeUserAR.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for userTransferUserAR ======

    builder.addCase(userTransferUserAR.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(userTransferUserAR.fulfilled, (state, action) => {
        state.loading = false;
    });

    builder.addCase(userTransferUserAR.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });


    // ====== builders for userStatusChangeUserAR ======

    builder.addCase(userStatusChangeUserAR.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(userStatusChangeUserAR.fulfilled, (state, action) => {
        state.loading = false;
    });

    builder.addCase(userStatusChangeUserAR.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
    
  },
});

export default arUsersStore.reducer;
export const { clearArUser } = arUsersStore.actions;