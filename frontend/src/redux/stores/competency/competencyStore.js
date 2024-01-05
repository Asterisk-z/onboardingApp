import { createAsyncThunk, createSlice } from "@reduxjs/toolkit";
import axios from "axios";
import { errorHandler, successHandler } from "../../../utils/Functions";
const initialState = { list: null, list_active: null, user: null, total: null, error: "", loading: false };




export const loadAllActiveCompetency = createAsyncThunk(
  "competency/loadAllActiveCompetency",
  async (arg) => {
    try {
      const { data } = await axios.get(`competency/list-active`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const sendCompetency = createAsyncThunk(
  "competency/sendCompetency",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `competency/submit-competency`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const loadAllCompetency = createAsyncThunk(
  "competency/loadAllCompetency",
  async (arg) => {
    try {
      const { data } = await axios.get(`meg/competency-framework/list-all`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const createCompetency = createAsyncThunk(
  "competency/createCompetency",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `meg/competency-framework/create`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const updateCompetency = createAsyncThunk(
  "competency/updateCompetency",
  async (values) => {
    const id = values.get('competency_id')
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `meg/competency-framework/update/${id}`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const updateStatusCompetency = createAsyncThunk(
  "competency/updateStatusCompetency",
  async (values) => {
    const id = values.get('competency_id')
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `meg/competency-framework/update-status/${id}`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const loadCCOArCompetency = createAsyncThunk(
  "competency/loadCCOArCompetency",
  async (arg) => {
    try {
      const { data } = await axios.get(`cco/competency/ar`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const updateCCOStatusCompetency = createAsyncThunk(
  "competency/updateCCOStatusCompetency",
  async (values) => {
    
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `cco/competency/status`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);




const competencyStore = createSlice({
  name: "competency",
  initialState,
  reducers: {
    clearCompetency: (state) => {
      state.customer = null;
    },
  },
  extraReducers: (builder) => {

    // ====== builders for loadAllActiveCompetency ======

    builder.addCase(loadAllActiveCompetency.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadAllActiveCompetency.fulfilled, (state, action) => {
        state.loading = false;
        state.list_active = JSON.stringify(action.payload?.data?.data);
    });

    builder.addCase(loadAllActiveCompetency.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    
    // ====== builders for loadCCOArCompetency ======

    builder.addCase(loadCCOArCompetency.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadCCOArCompetency.fulfilled, (state, action) => {
        state.loading = false;
        state.list_active = JSON.stringify(action.payload?.data?.data);
    });

    builder.addCase(loadCCOArCompetency.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });


    // ====== builders for sendCompetency ======

    builder.addCase(sendCompetency.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(sendCompetency.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(sendCompetency.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for loadAllCompetency ======

    builder.addCase(loadAllCompetency.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadAllCompetency.fulfilled, (state, action) => {
        state.loading = false;
        state.list = JSON.stringify(action.payload?.data?.data);
    });

    builder.addCase(loadAllCompetency.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for createCompetency ======

    builder.addCase(createCompetency.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(createCompetency.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(createCompetency.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for updateCompetency ======

    builder.addCase(updateCompetency.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(updateCompetency.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(updateCompetency.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for updateStatusCompetency ======

    builder.addCase(updateStatusCompetency.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(updateStatusCompetency.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(updateStatusCompetency.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
    
    // ====== builders for updateCCOStatusCompetency ======

    builder.addCase(updateCCOStatusCompetency.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(updateCCOStatusCompetency.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(updateCCOStatusCompetency.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
    
  },
});

export default competencyStore.reducer;
export const { clearCompetency } = competencyStore.actions;