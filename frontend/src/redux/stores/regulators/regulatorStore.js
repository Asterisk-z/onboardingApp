import { createAsyncThunk, createSlice } from "@reduxjs/toolkit";
import axios from "axios";
// import { toast } from "react-toastify";
import { errorHandler, successHandler } from "../../../utils/Functions";
// import queryGenerator from "../../../utils/QueryGenerator";
// import category from "../memberCategory/category";
const initialState = {
                    list: null,
                    error: "", view_all: null,
                    loading: false,
};


// export const loadAllActivePositions = createAsyncThunk(
//   "position/loadAllActivePositions",
//   async (arg) => {
//     try {
//       const { data } = await axios.get(`positions`);
//       return successHandler(data);
//     } catch (error) {
//       return errorHandler(error);
//     }
//   }
// );



export const loadAllRegulators = createAsyncThunk(
  "regulator/loadAllRegulators",
  async (arg) => {
    try {
      const { data } = await axios.get(`meg/regulators/view_all`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const createRegulator = createAsyncThunk(
  "regulator/createRegulator",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
        },
        url: `meg/regulators/create`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);


export const updateRegulator = createAsyncThunk(
  "regulator/updateRegulator",
  async (values) => {
    const id = values.get('id')
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
        },
        url: `meg/regulators/update/${id}`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const updateRegulatorStatus = createAsyncThunk(
  "regulator/updateRegulatorStatus",
  async (values) => {
    const id = values.get('id')
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
        },
        url: `meg/regulators/update-status/${id}`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);


const regulatorStore = createSlice({
  name: "regulator",
  initialState,
  reducers: {
    clearRegulator: (state) => {
      state.list = null;
    },
  },
  extraReducers: (builder) => {

    // ====== builders for loadAllActivePositions ======

    // builder.addCase(loadAllActivePositions.pending, (state) => {
    //   state.loading = true;
    // });

    // builder.addCase(loadAllActivePositions.fulfilled, (state, action) => {
    //   state.loading = false;
    //     // state.list = action.payload?.data?.data?.positions;
    //     state.list = JSON.stringify(action.payload?.data?.data?.positions);
    // });

    // builder.addCase(loadAllActivePositions.rejected, (state, action) => {
    //   state.loading = false;
    //   state.error = action.payload.message;
    // });

    // ====== builders for loadAllPositions ======

    builder.addCase(loadAllRegulators.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadAllRegulators.fulfilled, (state, action) => {
        state.loading = false;
        // state.list = action.payload?.data?.data?.categories;
        state.view_all = JSON.stringify(action.payload?.data?.data);
    });

    builder.addCase(loadAllRegulators.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });


    // ====== builders for updateRegulator ======

    builder.addCase(updateRegulator.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(updateRegulator.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(updateRegulator.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
    
    // ====== builders for updateRegulatorStatus ======

    builder.addCase(updateRegulatorStatus.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(updateRegulatorStatus.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(updateRegulatorStatus.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
    
    // ====== builders for createRegulator ======

    builder.addCase(createRegulator.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(createRegulator.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(createRegulator.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

  },
});

export default regulatorStore.reducer;
export const { clearRegulator } = regulatorStore.actions;