import { createAsyncThunk, createSlice } from "@reduxjs/toolkit";
import axios from "axios";
import queryGenerator from "utils/QueryGenerator";
import { errorHandler, successHandler } from "../../../utils/Functions";
const initialState = { list: null, list_all: null, single_event: null, list_all_registered: null, list_all_invited: null, list_all_registrations: null, list_active: null, user: null, total: null, error: "", loading: false };




export const loadAllEvent = createAsyncThunk(
  "educationEvent/loadAllEvent",
  async (arg) => {
    // ?show_past_events=1&name=ar&from_date=2023-07-12&to_date
    // {'show_past_events' : 1, "name" : "ar", "from_date" : "2023-07-12", "to_date" : "2023-07-12"}
    const query = queryGenerator(arg);
    try {
      const { data } = await axios.get(`events?${query}`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const loadSingleEvent = createAsyncThunk(
  "educationEvent/loadSingleEvent",
  async (arg) => {
    const query = arg.event_id;
    try {
      const { data } = await axios.get(`events/view/${query}`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);


//Store to View Events that you've Registerd for as an AR
export const loadAllRegisteredEvent = createAsyncThunk(
  "educationEvent/loadAllRegisteredEvent",
  async (arg) => {
    try {
      const { data } = await axios.get(`events/registered`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);


//Store to show AR's events that are available for them
export const loadAllInvitedEvent = createAsyncThunk(
  "educationEvent/loadAllInvitedEvent",
  async (arg) => {
    try {
      const { data } = await axios.get(`events/invited`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const megCreateEvent = createAsyncThunk(
  "educationEvent/megCreateEvent",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `events/add`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const megUpdateEvent = createAsyncThunk(
  "educationEvent/megUpdateEvent",
  async (values) => {
    const event_id = values.event_id;
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `events/update/${event_id}`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const megUpdateInvitedEvent = createAsyncThunk(
  "educationEvent/megUpdateInvitedEvent",
  async (values) => {
    const event_id = values.get('event_id');
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `events/update-invited/${event_id}`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const megDeleteEvent = createAsyncThunk(
  "educationEvent/megDeleteEvent",
  async (values) => {
    const event_id = values.get('event_id');
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `events/delete/${event_id}`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const MEGFSGLoadAllEventRegistration = createAsyncThunk(
  "educationEvent/MEGFSGLoadAllEventRegistration",
  async (arg) => {
    const event_id = arg.event_id
    try {
      const { data } = await axios.get(`events/registrations/${event_id}`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const MEGFSGUpdateEventRegistrationStatus = createAsyncThunk(
  "educationEvent/MEGFSGUpdateEventRegistrationStatus",
  async (values) => {
    const event_id = values.get('event_id');
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `events/registration-update-status/${event_id}`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const arEventRegistration = createAsyncThunk(
  "educationEvent/arEventRegistration",
  async (values) => {
    const event_id = values.get('event_id');
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `events/register/${event_id}`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);


export const sendForCertificateSigning = createAsyncThunk(
  "educationEvent/sendForCertificateSigning",
  async (values) => {
    const event_id = values.get('event_id');
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `events/send-for-certificate-signing/${event_id}`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);


export const signCertificate = createAsyncThunk(
  "educationEvent/signCertificate",
  async (values) => {
    const event_id = values.get('event_id');
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `events/sign-certificate/${event_id}`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);



export const sendCertificate = createAsyncThunk(
  "educationEvent/sendCertificate",
  async (values) => {
    const event_id = values.event_id;
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `events/send-certificates/${event_id}`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);




const eventStore = createSlice({
  name: "educationEvent",
  initialState,
  reducers: {
    clearEvent: (state) => {
      state.customer = null;
      state.single_event = null;
    },
  },
  extraReducers: (builder) => {

    // ====== builders for loadAllEvent ======

    builder.addCase(loadAllEvent.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadAllEvent.fulfilled, (state, action) => {
      state.loading = false;
      state.list_all = JSON.stringify(action.payload?.data?.data);
    });

    builder.addCase(loadAllEvent.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for loadSingleEvent ======

    builder.addCase(loadSingleEvent.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadSingleEvent.fulfilled, (state, action) => {
      state.loading = false;
      state.single_event = JSON.stringify(action.payload?.data?.data);
    });

    builder.addCase(loadSingleEvent.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for loadAllRegisteredEvent ======

    builder.addCase(loadAllRegisteredEvent.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadAllRegisteredEvent.fulfilled, (state, action) => {
      state.loading = false;
      state.list_all_registered = JSON.stringify(action.payload?.data?.data);
    });

    builder.addCase(loadAllRegisteredEvent.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for loadAllInvitedEvent ======

    builder.addCase(loadAllInvitedEvent.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadAllInvitedEvent.fulfilled, (state, action) => {
      state.loading = false;
      state.list_all_invited = JSON.stringify(action.payload?.data?.data);
    });

    builder.addCase(loadAllInvitedEvent.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });


    // ====== builders for megCreateEvent ======

    builder.addCase(megCreateEvent.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(megCreateEvent.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(megCreateEvent.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for megUpdateEvent ======

    builder.addCase(megUpdateEvent.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(megUpdateEvent.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(megUpdateEvent.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for megUpdateInvitedEvent ======

    builder.addCase(megUpdateInvitedEvent.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(megUpdateInvitedEvent.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(megUpdateInvitedEvent.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for megDeleteEvent ======

    builder.addCase(megDeleteEvent.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(megDeleteEvent.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(megDeleteEvent.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for MEGFSGLoadAllEventRegistration ======

    builder.addCase(MEGFSGLoadAllEventRegistration.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(MEGFSGLoadAllEventRegistration.fulfilled, (state, action) => {
      state.loading = false;
      state.list_all_registrations = JSON.stringify(action.payload?.data?.data);
    });

    builder.addCase(MEGFSGLoadAllEventRegistration.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for MEGFSGUpdateEventRegistrationStatus ======

    builder.addCase(MEGFSGUpdateEventRegistrationStatus.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(MEGFSGUpdateEventRegistrationStatus.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(MEGFSGUpdateEventRegistrationStatus.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for arEventRegistration ======

    builder.addCase(arEventRegistration.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(arEventRegistration.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(arEventRegistration.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });


    // ====== builders for sendForCertificateSigning ======

    builder.addCase(sendForCertificateSigning.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(sendForCertificateSigning.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(sendForCertificateSigning.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
    // ====== builders for signCertificate ======

    builder.addCase(signCertificate.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(signCertificate.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(signCertificate.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
    // ====== builders for sendCertificate ======

    builder.addCase(sendCertificate.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(sendCertificate.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(sendCertificate.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

  },
});

export default eventStore.reducer;
export const { clearEvent } = eventStore.actions;