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
        // state.list = action.payload?.data?.data?.countries;
        state.list = JSON.stringify(action.payload?.data?.data?.users);
    });

    builder.addCase(loadAllActiveAuthoriser.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

  },
});

export default userStore.reducer;
export const { clearUser } = userStore.actions;