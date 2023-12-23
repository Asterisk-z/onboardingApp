import { createAsyncThunk, createSlice } from "@reduxjs/toolkit";
import axios from "axios";
import { errorHandler, successHandler } from "../../../utils/Functions";

const initialState = { list: null, all_list: null, error: "", loading: false};


export const loadAllActiveCategories = createAsyncThunk(
  "category/loadAllActiveCategories",
  async (arg) => {
    try {
      const { data } = await axios.get(`categories`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const loadAllCategories = createAsyncThunk(
  "category/loadAllCategories",
  async (arg) => {
    try {
      const { data } = await axios.get(`membership/category/list`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const createMembershipCategory = createAsyncThunk(
  "category/createMembershipCategory",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
        },
        url: `membership/category/create`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);


export const mapToPositions = createAsyncThunk(
  "category/mapToPositions",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
        },
        url: `membership/category/mapToPositions`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const unlinkFromPositions = createAsyncThunk(
  "category/unlinkFromPositions",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
        },
        url: `membership/category/unlinkFromPositions`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);



export const updateMembershipCategory = createAsyncThunk(
  "category/updateMembershipCategory",
  async (values) => {
    const id = values.get('category_id')
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
        },
        url: `membership/category/update/${id}`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const updateMembershipCategoryStatus = createAsyncThunk(
  "category/updateMembershipCategoryStatus",
  async (values) => {
    const id = values.get('category_id')
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
        },
        url: `membership/category/update-status/${id}`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

const categoryStore = createSlice({
  name: "category",
  initialState,
  reducers: {
    clearCategory: (state) => {
      state.list = null;
    },
  },
  extraReducers: (builder) => {

    // ====== builders for loadAllActiveCategories ======

    builder.addCase(loadAllActiveCategories.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadAllActiveCategories.fulfilled, (state, action) => {
        state.loading = false;
        // state.list = action.payload?.data?.data?.categories;
        state.list = JSON.stringify(action.payload?.data?.data?.categories);
    });

    builder.addCase(loadAllActiveCategories.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for loadAllCategories ======

    builder.addCase(loadAllCategories.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadAllCategories.fulfilled, (state, action) => {
        state.loading = false;
        // state.list = action.payload?.data?.data?.categories;
        state.all_list = JSON.stringify(action.payload?.data?.data.categories);
    });

    builder.addCase(loadAllCategories.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });


    // ====== builders for updateMembershipCategory ======

    builder.addCase(updateMembershipCategory.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(updateMembershipCategory.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(updateMembershipCategory.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
   
 
    // ====== builders for mapToPositions ======

    builder.addCase(mapToPositions.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(mapToPositions.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(mapToPositions.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for unlinkFromPositions ======

    builder.addCase(unlinkFromPositions.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(unlinkFromPositions.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(unlinkFromPositions.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
    
    // ====== builders for updateMembershipCategoryStatus ======

    builder.addCase(updateMembershipCategoryStatus.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(updateMembershipCategoryStatus.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(updateMembershipCategoryStatus.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
    
    // ====== builders for createMembershipCategory ======

    builder.addCase(createMembershipCategory.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(createMembershipCategory.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(createMembershipCategory.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

  },
});

export default categoryStore.reducer;
export const { clearCategory } = categoryStore.actions;