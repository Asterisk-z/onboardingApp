import { createAsyncThunk, createSlice } from "@reduxjs/toolkit";
import axios from "axios";
import { errorHandler, successHandler } from "../../../utils/Functions";

const initialState = { list: null, error: "", all_list: null, loading: false};


export const loadAllActiveComplaintTypes = createAsyncThunk(
  "complaintType/loadAllActiveComplaintTypes",
  async (arg) => {
    try {
      const { data } = await axios.get(`complaint-types`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);


export const loadAllComplaintTypes = createAsyncThunk(
  "complainType/loadAllComplaintTypes",
  async (arg) => {
    try {
      const { data } = await axios.get(`meg/complain-type/list`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const createComplaintTypes = createAsyncThunk(
  "complainType/createComplaintTypes",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
        },
        url: `meg/complain-type/create`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);


export const updateComplaintTypes = createAsyncThunk(
  "complainType/updateComplaintTypes",
  async (values) => {
    const id = values.get('complaintType_id')
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
        },
        url: `meg/complain-type/update/${id}`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const updateComplaintTypesStatus = createAsyncThunk(
  "complainType/updateComplaintTypesStatus",
  async (values) => {
    const id = values.get('complaintType_id')
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
        },
        url: `meg/complain-type/update-status/${id}`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
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

    // ====== builders for loadAllActiveComplaintTypes ======

    builder.addCase(loadAllActiveComplaintTypes.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadAllActiveComplaintTypes.fulfilled, (state, action) => {
        state.loading = false;
        state.list = JSON.stringify(action.payload?.data?.data?.compliant_types);
    });

    builder.addCase(loadAllActiveComplaintTypes.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
    
    // ====== builders for loadAllComplaintTypes ======

    builder.addCase(loadAllComplaintTypes.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadAllComplaintTypes.fulfilled, (state, action) => {
        state.loading = false;
        // state.list = action.payload?.data?.data?.categories;
        state.all_list = JSON.stringify(action.payload?.data?.data.compliant_types);
    });

    builder.addCase(loadAllComplaintTypes.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });


    // ====== builders for updateComplaintTypes ======

    builder.addCase(updateComplaintTypes.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(updateComplaintTypes.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(updateComplaintTypes.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
    
    // ====== builders for updateComplaintTypesStatus ======

    builder.addCase(updateComplaintTypesStatus.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(updateComplaintTypesStatus.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(updateComplaintTypesStatus.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
    
    // ====== builders for createComplaintTypes ======

    builder.addCase(createComplaintTypes.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(createComplaintTypes.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(createComplaintTypes.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });


  },
});

export default complaintTypeStore.reducer;
export const { clearComplaintType } = complaintTypeStore.actions;