import { createAsyncThunk, createSlice } from "@reduxjs/toolkit";
import axios from "axios";
import { errorHandler, successHandler } from "utils/Functions";
import queryGenerator from "utils/QueryGenerator";
const initialState = { all: null, list: null, user: null, total: null, error: "", loading: false };

export const userLoadUserARs = createAsyncThunk(
  "arUsers/userLoadUserARs",
  async (values) => {
    const query = queryGenerator(values);
    try {
      const { data } = await axios.get(`ar/list?${query}`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const adminLoadUserARs = createAsyncThunk(
  "arUsers/adminLoadUserARs",
  async (values) => {
    try {
      const { data } = await axios.get(`meg/ar/list`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const userSearchUserARs = createAsyncThunk(
  "arUsers/userSearchUserARs",
  async (values) => {
//     first_name
// last_name
    const query = queryGenerator(values);
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
    const id = values.get('user_id')
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
        },
        url: `ar/update/${id}`,
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
    const id = values.get('user_id')
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
        },
        url: `ar/cancel-update/${id}`,
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
    const id = values.get('user_id')
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
        },
        url: `ar/process-update/${id}`,
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

export const megLoadTransferUserAR = createAsyncThunk(
  "arUsers/megLoadTransferUserAR",
  async (values) => {
    try {
      const { data } = await axios.get(`meg/ar/transfer/?status=pending`);
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


export const megProcessTransferUserAR = createAsyncThunk(
  "arUsers/megProcessTransferUserAR",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
        },
        url: `meg/ar/process-add/user_id`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const megProcessAddUserAR = createAsyncThunk(
  "arUsers/megProcessAddUserAR",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
        },
        url: `meg/ar/process-transfer/user_id`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const userProcessTransferUserAR = createAsyncThunk(
  "arUsers/userProcessTransferUserAR",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
        },
        url: `ar/process-transfer/user_id`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const userProcessChangeStatusUserAR = createAsyncThunk(
  "arUsers/userProcessChangeStatusUserAR",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
        },
        url: `ar/process-change-status/user_id`,
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
    
    // ====== builders for adminLoadUserARs ======

    builder.addCase(adminLoadUserARs.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(adminLoadUserARs.fulfilled, (state, action) => {
        state.loading = false;
        // state.list = action.payload?.data?.data?.categories;
        state.list = JSON.stringify(action.payload?.data?.data);
    });

    builder.addCase(adminLoadUserARs.rejected, (state, action) => {
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

    // ====== builders for userProcessTransferUserAR ======

    builder.addCase(userProcessTransferUserAR.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(userProcessTransferUserAR.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(userProcessTransferUserAR.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for userProcessChangeStatusUserAR ======

    builder.addCase(userProcessChangeStatusUserAR.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(userProcessChangeStatusUserAR.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(userProcessChangeStatusUserAR.rejected, (state, action) => {
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


    // ====== builders for megLoadTransferUserAR ======

    builder.addCase(megLoadTransferUserAR.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(megLoadTransferUserAR.fulfilled, (state, action) => {
        state.loading = false;
        // state.list = action.payload?.data?.data?.categories;
        state.list = JSON.stringify(action.payload?.data?.data);
    });

    builder.addCase(megLoadTransferUserAR.rejected, (state, action) => {
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
    
    // ====== builders for megProcessTransferUserAR ======

    builder.addCase(megProcessTransferUserAR.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(megProcessTransferUserAR.fulfilled, (state, action) => {
        state.loading = false;
    });

    builder.addCase(megProcessTransferUserAR.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
    
    // ====== builders for megProcessAddUserAR ======

    builder.addCase(megProcessAddUserAR.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(megProcessAddUserAR.fulfilled, (state, action) => {
        state.loading = false;
    });

    builder.addCase(megProcessAddUserAR.rejected, (state, action) => {
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