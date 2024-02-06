import { createAsyncThunk, createSlice } from "@reduxjs/toolkit";
import axios from "axios";
import { toast } from "react-toastify";
import { errorHandler, successHandler } from "../../../utils/Functions";
import queryGenerator from "../../../utils/QueryGenerator";
const initialState = { list: null, error: "", all_list: null, loading: false };

export const loadAllActivePositions = createAsyncThunk(
  "position/loadAllActivePositions",
  async (arg) => {
    try {
      const { data } = await axios.get(`positions`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const loadAllCategoryPositions = createAsyncThunk(
  "position/loadAllCategoryPositions",
  async (values) => {
    try {
       const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
        },
        url: `category/positions`,
        data: values,
      });
      
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const loadAllPositions = createAsyncThunk(
  "position/loadAllPositions",
  async (arg) => {
    try {
      const { data } = await axios.get(`meg/position/list`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const createPosition = createAsyncThunk(
  "position/createPosition",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
        },
        url: `meg/position/create`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const mapToCategories = createAsyncThunk(
  "position/mapToCategories",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
        },
        url: `meg/position/mapToCategories`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const unlinkFromCategories = createAsyncThunk(
  "position/unlinkFromCategories",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
        },
        url: `meg/position/unlinkFromCategories`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);


export const updatePosition = createAsyncThunk(
  "position/updatePosition",
  async (values) => {
    const id = values.get('position_id')
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
        },
        url: `meg/position/update/${id}`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const updatePositionStatus = createAsyncThunk(
  "position/updatePositionStatus",
  async (values) => {
    const id = values.get('position_id')
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
        },
        url: `meg/position/update-status/${id}`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);


const positionStore = createSlice({
  name: "position",
  initialState,
  reducers: {
    clearPosition: (state) => {
      state.list = null;
    },
  },
  extraReducers: (builder) => {

    // ====== builders for loadAllActivePositions ======

    builder.addCase(loadAllActivePositions.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadAllActivePositions.fulfilled, (state, action) => {
      state.loading = false;
        // state.list = action.payload?.data?.data?.positions;
        state.list = JSON.stringify(action.payload?.data?.data?.positions);
    });

    builder.addCase(loadAllActivePositions.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for loadAllCategoryPositions ======

    builder.addCase(loadAllCategoryPositions.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadAllCategoryPositions.fulfilled, (state, action) => {
      state.loading = false;
        // state.list = action.payload?.data?.data?.positions;
        state.list = JSON.stringify(action.payload?.data?.data);
    });

    builder.addCase(loadAllCategoryPositions.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for loadAllPositions ======

    builder.addCase(loadAllPositions.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadAllPositions.fulfilled, (state, action) => {
        state.loading = false;
        // state.list = action.payload?.data?.data?.categories;
        state.all_list = JSON.stringify(action.payload?.data?.data.positions);
    });

    builder.addCase(loadAllPositions.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });


    // ====== builders for updatePosition ======

    builder.addCase(updatePosition.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(updatePosition.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(updatePosition.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
    
    // ====== builders for updatePositionStatus ======

    builder.addCase(updatePositionStatus.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(updatePositionStatus.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(updatePositionStatus.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
    
    // ====== builders for unlinkFromCategories ======

    builder.addCase(unlinkFromCategories.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(unlinkFromCategories.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(unlinkFromCategories.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for mapToCategories ======

    builder.addCase(mapToCategories.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(mapToCategories.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(mapToCategories.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for createPosition ======

    builder.addCase(createPosition.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(createPosition.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(createPosition.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

  },
});

export default positionStore.reducer;
export const { clearPosition } = positionStore.actions;