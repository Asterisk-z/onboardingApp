import { createAsyncThunk, createSlice } from "@reduxjs/toolkit";
import axios from "axios";
import { errorHandler, successHandler } from "utils/Functions";
import queryGenerator from "utils/QueryGenerator";
const initialState = { all: null, list: null, user_application: null, application_details: null, initial_application: null, all_fields: null, overall_fields: null, preview: [], list_extra: {}, status_list: null, transfer_list: null, user: null, total: null, error: "", loading: false };


export const fetchApplication = createAsyncThunk(
  "application/fetchApplication",
  async (values) => {

    try {
      const { data } = await axios.get(`membership/application/get_application/${values.application_uuid}`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const fetchInitialApplication = createAsyncThunk(
  "application/fetchInitialApplication",
  async (values) => {

    const query = queryGenerator(values);
    try {
      const { data } = await axios.get(`membership/application/initial?${query}`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const loadApplication = createAsyncThunk(
  "application/loadApplication",
  async (values) => {
    const query = queryGenerator(values);
    try {
      const { data } = await axios.get(`membership/application/detail?${query}`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const loadPreview = createAsyncThunk(
  "application/loadPreview",
  async (values) => {
    const query = queryGenerator(values);
    try {
      const { data } = await axios.get(`membership/application/preview?${query}`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const loadPageFields = createAsyncThunk(
  "application/loadPageFields",
  async (values) => {
    const query = queryGenerator(values);
    try {
      const { data } = await axios.get(`membership/application/fields?${query}`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const loadAllFields = createAsyncThunk(
  "application/loadAllFields",
  async (values) => {
    const query = queryGenerator(values);
    try {
      const { data } = await axios.get(`membership/application/all-fields?${query}`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const loadFieldOption = createAsyncThunk(
  "application/loadFieldOption",
  async (values) => {
    const query = queryGenerator(values);
    try {
      const { data } = await axios.get(`membership/application/field/option?${query}`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const loadExtra = createAsyncThunk(
  "application/loadExtra",
  async (values) => {
    const query = queryGenerator(values);
    try {
      const { data } = await axios.get(`membership/application/extra?${query}`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const retainField = createAsyncThunk(
  "application/retainField",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `membership/application/retain`,
        data: values,
      });
      return successHandler(data);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const uploadField = createAsyncThunk(
  "application/uploadField",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `membership/application/upload`,
        data: values,
      });
      return successHandler(data);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const updateStep = createAsyncThunk(
  "application/updateStep",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `membership/application/update-step`,
        data: values,
      });
      return successHandler(data);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);


export const submitPage = createAsyncThunk(
  "application/submitPage",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `membership/application/submitPage`,
        data: values,
      });
      return successHandler(data);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const completeApplication = createAsyncThunk(
  "application/completeApplication",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `membership/application/complete`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const conversionRequest = createAsyncThunk(
  "application/conversionRequest",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `membership/application/conversion-request`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const additionRequest = createAsyncThunk(
  "application/additionRequest",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `membership/application/addition-request`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);



const applicationStore = createSlice({
  name: "application",
  initialState,
  reducers: {
    clearArUser: (state) => {
      state.customer = null;
      state.all_fields = null;
      state.application_details = null;
    },
    clearAllFields: (state) => {
      state.all_fields = null;
    },
  },
  extraReducers: (builder) => {

    // ====== builders for fetchApplication ======

    builder.addCase(fetchApplication.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(fetchApplication.fulfilled, (state, action) => {
      state.loading = false;
      state.application_details = JSON.stringify(action.payload?.data?.data);
    });

    builder.addCase(fetchApplication.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for fetchInitialApplication ======

    builder.addCase(fetchInitialApplication.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(fetchInitialApplication.fulfilled, (state, action) => {
      state.loading = false;
      state.initial_application = JSON.stringify(action.payload?.data?.data);
    });

    builder.addCase(fetchInitialApplication.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for loadApplication ======

    builder.addCase(loadApplication.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadApplication.fulfilled, (state, action) => {
      state.loading = false;
      state.user_application = JSON.stringify(action.payload?.data?.data);
    });

    builder.addCase(loadApplication.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for loadFieldOption ======

    builder.addCase(loadFieldOption.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadFieldOption.fulfilled, (state, action) => {
      state.loading = false;
      // state.list = action.payload?.data?.data?.categories;

      if (!Array.isArray(state.all)) {
        state.all = [];
      }

      const all = [...state.all];

      all.push(action.payload?.data.data);
      state.all = all;

    });

    builder.addCase(loadFieldOption.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for loadExtra ======

    builder.addCase(loadExtra.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadExtra.fulfilled, (state, action) => {
      state.loading = false;
      // state.list = action.payload?.data?.data?.categories;

      if (!Array.isArray(state.list_extra)) {
        state.list_extra = {};
      }

      const list_extra = state.list_extra;
      const data = { ...list_extra, [action.payload?.data.data.name]: action.payload?.data.data };
      state.list_extra = data;

    });

    builder.addCase(loadExtra.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });


    // ====== builders for loadPreview ======

    builder.addCase(loadPreview.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadPreview.fulfilled, (state, action) => {
      state.loading = false;
      // state.list = action.payload?.data?.data?.categories;
      // state.list = JSON.stringify(action.payload?.data?.data);

      // if (!Array.isArray(state.all_fields)) {
      state.preview = [];
      // }

      // const all_fields = [...state.all_fields];
      const preview = [];
      // console.log(new Date())
      preview.push(...action.payload?.data.data);
      state.preview = preview;
    });

    builder.addCase(loadPreview.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for loadPageFields ======

    builder.addCase(loadPageFields.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadPageFields.fulfilled, (state, action) => {
      state.loading = false;
      // state.list = action.payload?.data?.data?.categories;
      // state.list = JSON.stringify(action.payload?.data?.data);

      // if (!Array.isArray(state.all_fields)) {
      state.all_fields = [];
      // }

      // const all_fields = [...state.all_fields];
      const all_fields = [];
      // console.log(new Date())
      all_fields.push(...action.payload?.data.data);
      state.all_fields = all_fields;
    });

    builder.addCase(loadPageFields.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });


    // ====== builders for loadAllFields ======

    builder.addCase(loadAllFields.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadAllFields.fulfilled, (state, action) => {
      state.loading = false;

      if (!Array.isArray(state.overall_fields)) {
        state.overall_fields = [];
      }

      // let overall_fields = [];
      let overall_fields = action.payload?.data.data;
      // // console.log(new Date())
      state.overall_fields = overall_fields;
      // state.overall_fields = action.payload?.data.data;

    });

    builder.addCase(loadAllFields.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });


    // ====== builders for retainField ======

    builder.addCase(retainField.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(retainField.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(retainField.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for uploadField ======

    builder.addCase(uploadField.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(uploadField.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(uploadField.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for updateStep ======

    builder.addCase(updateStep.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(updateStep.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(updateStep.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for submitPage ======

    builder.addCase(submitPage.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(submitPage.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(submitPage.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });



    // ====== builders for additionRequest ======

    builder.addCase(additionRequest.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(additionRequest.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(additionRequest.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for conversionRequest ======

    builder.addCase(conversionRequest.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(conversionRequest.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(conversionRequest.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for completeApplication ======

    builder.addCase(completeApplication.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(completeApplication.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(completeApplication.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });


  },
});

export default applicationStore.reducer;
export const { clearArUser } = applicationStore.actions;