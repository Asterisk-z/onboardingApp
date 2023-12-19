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


export const loadAllActiveInstitutions = createAsyncThunk(
  "institutions/loadAllActiveInstitutions",
  async (arg) => {
    try {
      const { data } = await axios.get(`institution/list`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

const institutionStore = createSlice({
  name: "institutions",
  initialState,
  reducers: {
    clearInstitution: (state) => {
      state.list = null;
    },
  },
  extraReducers: (builder) => {

    // ====== builders for loadAllActiveInstitutions ======

    builder.addCase(loadAllActiveInstitutions.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadAllActiveInstitutions.fulfilled, (state, action) => {
      state.loading = false;
        // state.list = action.payload?.data?.data?.countries;
        state.list = JSON.stringify(action.payload?.data?.data);
    });

    builder.addCase(loadAllActiveInstitutions.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

  },
});

export default institutionStore.reducer;
export const { clearInstitution } = institutionStore.actions;