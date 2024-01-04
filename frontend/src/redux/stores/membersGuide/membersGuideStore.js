import { createAsyncThunk, createSlice } from "@reduxjs/toolkit";
import axios from "axios";
import { errorHandler, successHandler } from "../../../utils/Functions";

const initialState = {
  list: null,
  error: "",
  all_guides: null,
  active_list: null,
  active: null,
  loading: false,
};


export const loadAllMembersGuide = createAsyncThunk(
  "members-guide/loadAllMembersGuide",
  async (arg) => {
    try {
      const { data } = await axios.get(`meg/member-guides/list-all`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const createMembersGuide = createAsyncThunk(
  "members-guide/createMembersGuide",
  async (values) => {
    try {
      const { data } = await axios.post(`meg/member-guides/create`, values, {
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const updateMembersGuide = createAsyncThunk(
  "members-guide/updateMemberGuide",
  async (values) => {
    const id = values.id;
    try {
      const { data } = await axios.post(`meg/member-guides/update/${id}`, values, {
        headers: {
          Accept: "application/json",
          "Content-Type": "multipart/form-data",
        },
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const updateMembersGuideStatus = createAsyncThunk(
  "members-guide/updateMembersGuideStatus",
  async (values) => {
    const id = values.get('id');
    try {
      const { data } = await axios.post(`meg/member-guides/update-status/${id}`, values, {
        headers: {
          Accept: "application/json",
          "Content-Type": "multipart/form-data",
        },
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

const membersGuideStore = createSlice({
  name: "members_guide",
  initialState,
  reducers: {
    clearMembersGuide: (state) => {
      state.list = null;
    },
  },
  extraReducers: (builder) => {

    builder.addCase(loadAllMembersGuide.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadAllMembersGuide.fulfilled, (state, action) => {
      state.loading = false;
      console.log('frefrf')
      state.all_guides = JSON.stringify(action.payload?.data?.data);
    });

    builder.addCase(loadAllMembersGuide.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    builder.addCase(createMembersGuide.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(createMembersGuide.fulfilled, (state, action) => {
      console.log('herer')
      state.loading = false;
    });

    builder.addCase(createMembersGuide.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    builder.addCase(updateMembersGuide.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(updateMembersGuide.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(updateMembersGuide.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    builder.addCase(updateMembersGuideStatus.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(updateMembersGuideStatus.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(updateMembersGuideStatus.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
  },
});

export default membersGuideStore.reducer;
export const { clearMembersGuide } = membersGuideStore.actions;
